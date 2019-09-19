<?php

return [
    'ctrl'      => [
        'title'         => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_currency',
        'label'         => 'currency',
        'tstamp'        => 'tstamp',
        'crdate'        => 'crdate',
        'cruser_id'     => 'cruser_id',
        'dividers2tabs' => true,

        'delete'        => 'deleted',
        'enablecolumns' => [],
        'searchFields'  => 'currency,',
        'iconfile'      => 'EXT:tw_payment/Resources/Public/Icons/tx_twpayment_domain_model_currency.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'currency',
    ],
    'types'     => [
        '1' => ['showitem' => 'currency, '],
    ],
    'palettes'  => [
        '1' => ['showitem' => ''],
    ],
    'columns'   => [

        'currency' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_currency.currency',
            'config'  => [
                'type'          => 'select',
                'foreign_table' => 'static_currencies',
                'itemsProcFunc' => 'SJBR\\StaticInfoTables\\Hook\\Backend\\Form\\FormDataProvider\\TcaSelectItemsProcessor->translateCurrenciesSelector',
                'minitems'      => 1,
                'maxitems'      => 1
            ],
        ],
    ],
];
