<?php

namespace Tollwerk\TwPayment\Tests\Unit\Domain\Model;

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
 * Test case for class \Tollwerk\TwPayment\Domain\Model\Transaction.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Joschi Kuphal <joschi@tollwerk.de>
 */
class TransactionTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Tollwerk\TwPayment\Domain\Model\Transaction
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Tollwerk\TwPayment\Domain\Model\Transaction();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getSenderReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getSender()
		);
	}

	/**
	 * @test
	 */
	public function setSenderForStringSetsSender()
	{
		$this->subject->setSender('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'sender',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAmountReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getAmount()
		);
	}

	/**
	 * @test
	 */
	public function setAmountForFloatSetsAmount()
	{
		$this->subject->setAmount(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'amount',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription()
	{
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTemplateReturnsInitialValueForBool()
	{
		$this->assertSame(
			FALSE,
			$this->subject->getTemplate()
		);
	}

	/**
	 * @test
	 */
	public function setTemplateForBoolSetsTemplate()
	{
		$this->subject->setTemplate(TRUE);

		$this->assertAttributeEquals(
			TRUE,
			'template',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTokenReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getToken()
		);
	}

	/**
	 * @test
	 */
	public function setTokenForStringSetsToken()
	{
		$this->subject->setToken('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'token',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCreatedReturnsInitialValueForDateTime()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getCreated()
		);
	}

	/**
	 * @test
	 */
	public function setCreatedForDateTimeSetsCreated()
	{
		$dateTimeFixture = new \DateTime();
		$this->subject->setCreated($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'created',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getErrorReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getError()
		);
	}

	/**
	 * @test
	 */
	public function setErrorForStringSetsError()
	{
		$this->subject->setError('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'error',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getChargedReturnsInitialValueForDateTime()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getCharged()
		);
	}

	/**
	 * @test
	 */
	public function setChargedForDateTimeSetsCharged()
	{
		$dateTimeFixture = new \DateTime();
		$this->subject->setCharged($dateTimeFixture);

		$this->assertAttributeEquals(
			$dateTimeFixture,
			'charged',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCurrencyReturnsInitialValueForCurrency()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getCurrency()
		);
	}

	/**
	 * @test
	 */
	public function setCurrencyForCurrencySetsCurrency()
	{
		$currencyFixture = new \Tollwerk\TwPayment\Domain\Model\Currency();
		$this->subject->setCurrency($currencyFixture);

		$this->assertAttributeEquals(
			$currencyFixture,
			'currency',
			$this->subject
		);
	}
}
