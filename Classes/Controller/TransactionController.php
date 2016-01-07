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

/**
 * TransactionController
 */
class TransactionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * transactionRepository
     *
     * @var \Tollwerk\TwPayment\Domain\Repository\TransactionRepository
     * @inject
     */
    protected $transactionRepository = NULL;
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $transactions = $this->transactionRepository->findAll();
        $this->view->assign('transactions', $transactions);
    }
    
    /**
     * action show
     *
     * @param \Tollwerk\TwPayment\Domain\Model\Transaction $transaction
     * @return void
     */
    public function showAction(\Tollwerk\TwPayment\Domain\Model\Transaction $transaction)
    {
        $this->view->assign('transaction', $transaction);
    }
    
    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        
    }
    
    /**
     * action create
     *
     * @param \Tollwerk\TwPayment\Domain\Model\Transaction $newTransaction
     * @return void
     */
    public function createAction(\Tollwerk\TwPayment\Domain\Model\Transaction $newTransaction)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->transactionRepository->add($newTransaction);
        $this->redirect('list');
    }
    
    /**
     * action edit
     *
     * @param \Tollwerk\TwPayment\Domain\Model\Transaction $transaction
     * @ignorevalidation $transaction
     * @return void
     */
    public function editAction(\Tollwerk\TwPayment\Domain\Model\Transaction $transaction)
    {
        $this->view->assign('transaction', $transaction);
    }
    
    /**
     * action update
     *
     * @param \Tollwerk\TwPayment\Domain\Model\Transaction $transaction
     * @return void
     */
    public function updateAction(\Tollwerk\TwPayment\Domain\Model\Transaction $transaction)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->transactionRepository->update($transaction);
        $this->redirect('list');
    }
    
    /**
     * action delete
     *
     * @param \Tollwerk\TwPayment\Domain\Model\Transaction $transaction
     * @return void
     */
    public function deleteAction(\Tollwerk\TwPayment\Domain\Model\Transaction $transaction)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->transactionRepository->remove($transaction);
        $this->redirect('list');
    }

}