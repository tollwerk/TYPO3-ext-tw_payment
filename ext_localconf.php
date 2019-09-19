<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Tollwerk.' . $_EXTKEY,
    'Payment',
    array(
        'Transaction' => 'show,charge',

    ),
    // non-cacheable actions
    array(
        'Transaction' => 'show,charge',
    )
);
