<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction',
		'label' => 'sender',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',

		),
		'searchFields' => 'sender,amount,description,template,token,created,error,charged,currency,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tw_payment') . 'Resources/Public/Icons/tx_twpayment_domain_model_transaction.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, sender, amount, description, template, token, created, error, charged, currency',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden;;1, sender, amount, description, template, token, created, error, charged, currency, '),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),

		'sender' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.sender',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'amount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.amount',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2,required'
			)
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.description',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'template' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.template',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'token' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.token',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'created' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.created',
			'config' => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'date',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'error' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.error',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
		'charged' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.charged',
			'config' => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'date',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'currency' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.currency',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_twpayment_domain_model_currency',
				'minitems' => 1,
				'maxitems' => 1
			),
		),
		
	),
);