<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_currency',
		'label' => 'currency',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(

		),
		'searchFields' => 'currency,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tw_payment') . 'Resources/Public/Icons/tx_twpayment_domain_model_currency.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'currency',
	),
	'types' => array(
		'1' => array('showitem' => 'currency, '),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'currency' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_currency.currency',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'static_currencies',
				'minitems' => 1,
				'maxitems' => 1
			),
		),
		
	),
);