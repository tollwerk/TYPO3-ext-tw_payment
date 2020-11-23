<?php

namespace Tollwerk\TwPayment\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Joschi Kuphal <joschi@tollwerk.de>, tollwerk GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use SJBR\StaticInfoTables\Domain\Model\SystemLanguage;
use SJBR\StaticInfoTables\Domain\Repository\SystemLanguageRepository;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Tollwerk\TwPayment\Domain\Model\Transaction;
use Tollwerk\TwPayment\Domain\Repository\CurrencyRepository;
use Tollwerk\TwPayment\Domain\Repository\TransactionRepository;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

require_once(__DIR__ . '/../../Resources/Private/Vendor/autoload.php');

/**
 * TransactionController
 */
class TransactionController extends ActionController
{
    /**
     * transactionRepository
     *
     * @var TransactionRepository
     */
    protected $transactionRepository = null;

    /**
     * Currency repository
     *
     * @var CurrencyRepository
     */
    protected $currencyRepository = null;

    /**
     * System language repository
     *
     * @var SystemLanguageRepository
     */
    protected $languageRepository;

    /**
     * Inject the transaction repository
     *
     * @param TransactionRepository $transactionRepository
     */
    public function injectTransactionRepository(TransactionRepository $transactionRepository): void
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Inject the currency repository
     *
     * @param CurrencyRepository $currencyRepository
     */
    public function injectCurrencyRepository(CurrencyRepository $currencyRepository): void
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Inject the system language repository
     *
     * @param SystemLanguageRepository $languageRepository
     */
    public function injectLanguageRepository(SystemLanguageRepository $languageRepository): void
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * List action
     *
     * @return void
     */
    public function listAction()
    {
        $languages = [0 => $this->settings['defaultLang']];

        // Gather all languages
        /** @var SystemLanguage $systemLanguage */
        foreach ($this->languageRepository as $systemLanguage) {
            $languages[$systemLanguage->getUid()] = $systemLanguage->getTitle();
        }

        $this->view->assign('languages', $languages);
        $this->view->assign('transactions', $this->transactionRepository->findAll());
    }

    /**
     * Create checksum for transaction
     *
     * @param Transaction $transaction
     *
     * @return string
     */
    public function createChecksum(Transaction $transaction)
    {
        return md5($transaction->getUid() . $transaction->getAmountAsInt() . $transaction->getText() . $transaction->getDescription());
    }

    /**
     * Get transaction success uri
     *
     * @param Transaction $transaction
     *
     * @return string
     */
    public function getTransactionSuccessUri(Transaction $transaction)
    {
        if (empty($this->settings['transactionPid'])) {
            throw new Exception('Missing value for plugin.tx_twpayment.settings.transactionPid', 1606114370);
        }

        /** @var UriBuilder $uriBuilder */
        $uriBuilder = $this->objectManager->get(UriBuilder::class);
        $uri        = $uriBuilder
            ->setTargetPageUid($this->settings['transactionPid'])
            ->setCreateAbsoluteUri(true)
            ->uriFor(
                'charge',
                [
                    'transaction' => $transaction->getUid(),
                    'checksum'    => $this->createChecksum($transaction),
                ],
                'Transaction',
                'TwPayment',
                'Payment'
            );

        return $uri;
    }

    /**
     * Show action
     *
     * @param Transaction $transaction
     *
     * @return void
     */
    public function showAction(Transaction $transaction)
    {
        // Create a stripe checkout session
        Stripe::setApiKey($this->settings['secretKey']);


        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                [
                    'price_data' => [
                        'unit_amount'  => $transaction->getAmountAsInt(),
                        'currency'     => $transaction->getCurrency()->getIsoCodeA3(),
                        'product_data' => array_filter([
                            'name'        => $transaction->getDescription() ?: null,
                            'images'      => $transaction->getImage() ? [$transaction->getImage()] : null,
                            'description' => $transaction->getText() ?: null,
                        ]),
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->getTransactionSuccessUri($transaction),
            'cancel_url'           => GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'),
        ]);

        $this->view->assign('transaction', $transaction);
        $this->view->assign('locale', $GLOBALS['TSFE']->config['config']['language']);
        $this->view->assign('checkoutSession', $checkoutSession->getLastResponse()->json);
    }

    /**
     * Charge action
     *
     * @param Transaction $transaction
     * @param string      $checksum
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function chargeAction(Transaction $transaction, string $checksum)
    {
        $charged = false;
        try {
            // If this is a new transaction: Charge it
            if (!$transaction->getCharged()) {
                if ($checksum !== $this->createChecksum($transaction)) {
                    throw new \Exception('Wrong transaction checksum!', 1606115142);
                }
                $transaction->setCharged(new \DateTime('now'));
                $charged = true;
            }
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $this->view->assign('error', $body['error']);
            $transaction->setError($body['error']['message']);
        } catch (Exception $e) {
            $this->view->assign('error', $e);
            $transaction->setError($e->getMessage());
        }

        $this->transactionRepository->update($transaction);

        $this->view->assign('charged', $charged);
        $this->view->assign('transaction', $transaction);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $this->view->assign('currencies', $this->currencyRepository->findAll());
    }

    /**
     * action create
     *
     * @param Transaction $newTransaction
     *
     * @return void
     */
    public function createAction(Transaction $newTransaction)
    {
        $this->addFlashMessage('The object was created.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->transactionRepository->add($newTransaction);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param Transaction $transaction
     * @ignorevalidation $transaction
     *
     * @return void
     */
    public function editAction(Transaction $transaction)
    {
        $this->view->assignMultiple(array(
            'transaction' => $transaction,
            'currencies'  => $this->currencyRepository->findAll()
        ));
    }

    /**
     * action update
     *
     * @param Transaction $transaction
     *
     * @return void
     */
    public function updateAction(Transaction $transaction)
    {
        $this->addFlashMessage('The object was updated: ' . $transaction->getSender() . ' | ' . $transaction->getAmount() . ' ' . $transaction->getCurrency()
                                                                                                                                              ->getIsoCodeA3() . ' | ' . $transaction->getDescription(),
            '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->transactionRepository->update($transaction);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param Transaction $transaction
     *
     * @return void
     */
    public function deleteAction(Transaction $transaction)
    {
        $this->addFlashMessage('The object was deleted.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->transactionRepository->remove($transaction);
        $this->redirect('list');
    }

    /**
     * action hide
     *
     * @param Transaction $transaction
     *
     * @return void
     */
    public function hideAction(Transaction $transaction)
    {
        $this->addFlashMessage('The object was hidden.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $transaction->setHidden(true);
        $this->transactionRepository->update($transaction);
        $this->redirect('list');
    }

    /**
     * A template method for displaying custom error flash messages, or to
     * display no flash message at all on errors. Override this to customize
     * the flash message in your action controller.
     *
     * @return string The flash message or FALSE if no flash message should be set
     * @api
     */
    protected function getErrorFlashMessage()
    {
//        var_dump(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('LLL:EXT:tw_payment/esources/Private/Language/locallang.xlf:error.1458140774', 'tw_payment'));
        return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('error.1458140774', 'tw_payment');
    }
}
