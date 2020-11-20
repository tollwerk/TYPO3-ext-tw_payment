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
use Tollwerk\TwPayment\Domain\Model\Transaction;
use Tollwerk\TwPayment\Domain\Repository\CurrencyRepository;
use Tollwerk\TwPayment\Domain\Repository\TransactionRepository;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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
     * Show action
     *
     * @param Transaction $transaction
     *
     * @return void
     */
    public function showAction(Transaction $transaction)
    {
        $this->view->assign('transaction', $transaction);
        $this->view->assign('locale', $GLOBALS['TSFE']->config['config']['language']);
    }

    /**
     * Charge action
     *
     * @param Transaction $transaction
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function chargeAction(Transaction $transaction)
    {

        $charged = false;

        // If this is a new transaction: Charge it
        if (!$transaction->getCharged()) {
            require_once(ExtensionManagementUtility::extPath('tw_payment', 'Resources/Private/Vendor/autoload.php'));
            $charged = true;

            \Stripe\Stripe::setApiKey($this->settings['secretKey']);

            try {
                $charge = \Stripe\Charge::create(array(
                    'amount'      => $transaction->getAmountAsInt(),
                    'currency'    => $transaction->getCurrency()->getIsoCodeA3(),
                    'source'      => $transaction->getToken(),
                    'description' => $transaction->getDescription(),
                ), array(
                    'idempotency_key' => md5($transaction->getUid()),
                ));

                if ($charge['paid']) {
                    $this->view->assign('charge', $charge);
                    $transaction->setCharged(new \DateTime('now'));
                }

            } catch (\Stripe\Error\Card $e) {
                // Since it's a decline, \Stripe\Error\Card will be caught
                $body = $e->getJsonBody();
                $this->view->assign('error', $body['error']);
                $transaction->setError($body['error']['message']);

//            } catch (\Stripe\Error\RateLimit $e) {
//                // Too many requests made to the API too quickly
//            } catch (\Stripe\Error\InvalidRequest $e) {
//                // Invalid parameters were supplied to Stripe's API
//            } catch (\Stripe\Error\Authentication $e) {
//                // Authentication with Stripe's API failed
//                // (maybe you changed API keys recently)
//            } catch (\Stripe\Error\ApiConnection $e) {
//                // Network communication with Stripe failed
//            } catch (\Stripe\Error\Base $e) {
//                // Display a very generic error to the user, and maybe send
//                // yourself an email

            } catch (Exception $e) {
                $this->view->assign('error', $e);
                $transaction->setError($e->getMessage());
            }

            $this->transactionRepository->update($transaction);
        }

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
        $this->addFlashMessage('The object was updated: '.$transaction->getSender().' | '.$transaction->getAmount().' '.$transaction->getCurrency()
                                                                                                                                    ->getIsoCodeA3().' | '.$transaction->getDescription(),
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
