<?php
namespace Tollwerk\TwPayment\ViewHelpers\Form;

    /*                                                                        *
     * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
     *                                                                        *
     * It is free software; you can redistribute it and/or modify it under    *
     * the terms of the GNU Lesser General Public License, either version 3   *
     *  of the License, or (at your option) any later version.                *
     *                                                                        *
     * The TYPO3 project - inspiring people to share!                         *
     *                                                                        */
use TYPO3\CMS\Fluid\ViewHelpers\Form\TextfieldViewHelper;

/**
 * View Helper which creates a text field (<input type="text">).
 *
 * = Examples =
 *
 * <code title="Example">
 * <f:form.textfield name="myTextBox" value="default value" />
 * </code>
 * <output>
 * <input type="text" name="myTextBox" value="default value" />
 * </output>
 *
 * @api
 */
class NumberfieldViewHelper extends TextfieldViewHelper
{
    /**
     * Initialize the arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerTagAttribute('min', 'float', 'Specifies the minimum amount');
        $this->registerTagAttribute('step', 'float', 'Specifies the number increment');
    }

    /**
     * Renders the numberfield.
     *
     * @param bool $required If the field is required or not
     * @return string
     * @api
     */
    public function render($required = false)
    {
        return parent::render($required, 'number');
    }
}
