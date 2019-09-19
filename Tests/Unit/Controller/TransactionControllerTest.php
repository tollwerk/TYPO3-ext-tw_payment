<?php
namespace Tollwerk\TwPayment\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Joschi Kuphal <joschi@tollwerk.de>, tollwerk GmbH
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tollwerk\TwPayment\Controller\TransactionController.
 *
 * @author Joschi Kuphal <joschi@tollwerk.de>
 */
class TransactionControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \Tollwerk\TwPayment\Controller\TransactionController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('Tollwerk\\TwPayment\\Controller\\TransactionController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllTransactionsFromRepositoryAndAssignsThemToView()
	{

		$allTransactions = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$transactionRepository = $this->getMock('Tollwerk\\TwPayment\\Domain\\Repository\\TransactionRepository', array('findAll'), array(), '', FALSE);
		$transactionRepository->expects($this->once())->method('findAll')->will($this->returnValue($allTransactions));
		$this->inject($this->subject, 'transactionRepository', $transactionRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('transactions', $allTransactions);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenTransactionToView()
	{
		$transaction = new \Tollwerk\TwPayment\Domain\Model\Transaction();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('transaction', $transaction);

		$this->subject->showAction($transaction);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenTransactionToTransactionRepository()
	{
		$transaction = new \Tollwerk\TwPayment\Domain\Model\Transaction();

		$transactionRepository = $this->getMock('Tollwerk\\TwPayment\\Domain\\Repository\\TransactionRepository', array('add'), array(), '', FALSE);
		$transactionRepository->expects($this->once())->method('add')->with($transaction);
		$this->inject($this->subject, 'transactionRepository', $transactionRepository);

		$this->subject->createAction($transaction);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenTransactionToView()
	{
		$transaction = new \Tollwerk\TwPayment\Domain\Model\Transaction();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('transaction', $transaction);

		$this->subject->editAction($transaction);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenTransactionInTransactionRepository()
	{
		$transaction = new \Tollwerk\TwPayment\Domain\Model\Transaction();

		$transactionRepository = $this->getMock('Tollwerk\\TwPayment\\Domain\\Repository\\TransactionRepository', array('update'), array(), '', FALSE);
		$transactionRepository->expects($this->once())->method('update')->with($transaction);
		$this->inject($this->subject, 'transactionRepository', $transactionRepository);

		$this->subject->updateAction($transaction);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenTransactionFromTransactionRepository()
	{
		$transaction = new \Tollwerk\TwPayment\Domain\Model\Transaction();

		$transactionRepository = $this->getMock('Tollwerk\\TwPayment\\Domain\\Repository\\TransactionRepository', array('remove'), array(), '', FALSE);
		$transactionRepository->expects($this->once())->method('remove')->with($transaction);
		$this->inject($this->subject, 'transactionRepository', $transactionRepository);

		$this->subject->deleteAction($transaction);
	}
}
