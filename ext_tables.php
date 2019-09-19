<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Tollwerk.' . $_EXTKEY,
    'Payment',
    'Payment transaction'
);

if (TYPO3_MODE === 'BE') {   // hallo

    /**
     * Registers a Backend Module
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Tollwerk.' . $_EXTKEY,
        'web',     // Make module a submodule of 'web'
        'payment',    // Submodule key
        '',                        // Position
        array(
            'Transaction' => 'list, new, create, edit, update, delete, hide',

        ),
        array(
            'access' => 'user,group',
            'icon' => 'EXT:' . $_EXTKEY . '/ext_icon.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_payment.xlf',
        )
    );

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript',
    'tollwerk Payment Plugins');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_twpayment_domain_model_transaction',
    'EXT:tw_payment/Resources/Private/Language/locallang_csh_tx_twpayment_domain_model_transaction.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_twpayment_domain_model_transaction');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_twpayment_domain_model_currency',
    'EXT:tw_payment/Resources/Private/Language/locallang_csh_tx_twpayment_domain_model_currency.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_twpayment_domain_model_currency');
