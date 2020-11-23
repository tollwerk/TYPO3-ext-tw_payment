<?php

namespace Tollwerk\TwPayment\Domain\Model;


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
 * Payment transaction
 */
class Transaction extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Payment sender
     *
     * @var string
     * @validate NotEmpty
     */
    protected $sender = '';

    /**
     * Payment amount
     *
     * @var int
     * @validate NotEmpty
     */
    protected $amount = 0;

    /**
     * Transaction description
     *
     * @var string
     * @validate NotEmpty
     */
    protected $description = '';

    /**
     * Long text
     *
     * @var string
     */
    protected $text = '';

    /**
     * @var string
     */
    protected $image = '';

    /**
     * Use as template
     *
     * @var bool
     */
    protected $template = false;

    /**
     * Payment token
     *
     * @var string
     */
    protected $token = '';

    /**
     * Payment token creation date
     *
     * @var int
     */
    protected $created = null;

    /**
     * Transaction creation date
     *
     * @var \DateTime
     */
    protected $crdate = null;

    /**
     * Error message
     *
     * @var string
     */
    protected $error = '';

    /**
     * Payment charge date
     *
     * @var \DateTime
     */
    protected $charged = null;

    /**
     * currency
     *
     * @var \Tollwerk\TwPayment\Domain\Model\Currency
     */
    protected $currency = null;

    /**
     * IP address
     *
     * @var string
     */
    protected $ip = null;

    /**
     * Hidden state
     *
     * @var boolean
     */
    protected $hidden = null;

    /**
     * Returns the sender
     *
     * @return string $sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Sets the sender
     *
     * @param string $sender
     *
     * @return void
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * Returns the amount
     *
     * @return int $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Returns the amount
     *
     * @return int $amount
     */
    public function getAmountAsInt()
    {
        return $this->amount * 100;
    }

    /**
     * Sets the amount
     *
     * @param int $amount
     *
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }



    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Returns the template
     *
     * @return bool $template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets the template
     *
     * @param bool $template
     *
     * @return void
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Returns the boolean state of template
     *
     * @return bool
     */
    public function isTemplate()
    {
        return $this->template;
    }

    /**
     * Returns the token
     *
     * @return string $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets the token
     *
     * @param string $token
     *
     * @return void
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Returns the created
     *
     * @return int $created
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * Sets the created
     *
     * @param int $created
     *
     * @return void
     */
    public function setCreated(int $created)
    {
        $this->created = $created;
    }

    /**
     * Returns the error
     *
     * @return string $error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Sets the error
     *
     * @param string $error
     *
     * @return void
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * Returns the charged
     *
     * @return \DateTime $charged
     */
    public function getCharged()
    {
        return $this->charged;
    }

    /**
     * Sets the charged
     *
     * @param \DateTime $charged
     *
     * @return void
     */
    public function setCharged(\DateTime $charged)
    {
        $this->charged = $charged;
    }

    /**
     * Returns the currency
     *
     * @return \Tollwerk\TwPayment\Domain\Model\Currency $currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets the currency
     *
     * @param \Tollwerk\TwPayment\Domain\Model\Currency $currency
     *
     * @return void
     */
    public function setCurrency(\Tollwerk\TwPayment\Domain\Model\Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param \DateTime $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Return the IP address
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set the IP address
     *
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Return the hidden state
     *
     * @return boolean Transaction is hidden
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Hide / unhide the transaction
     *
     * @param boolean $hidden Hide / unhide
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
}
