<?php

return [
    'ctrl'      => [
        'title'         => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction',
        'label'         => 'sender',
        'tstamp'        => 'tstamp',
        'crdate'        => 'crdate',
        'cruser_id'     => 'cruser_id',
        'delete'        => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',

        ],
        'searchFields'  => 'sender,amount,description,template,token,created,error,charged,currency,',
        'iconfile'      => 'EXT:tw_payment/Resources/Public/Icons/tx_twpayment_domain_model_transaction.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, sender, amount, description, imageUri, template, token, created, error, charged, currency',
    ],
    'types'     => [
        '1' => ['showitem' => 'hidden;;1, sender, amount, description, imageUri, template, token, created, error, charged, currency, '],
    ],
    'palettes'  => [
        '1' => ['showitem' => ''],
    ],
    'columns'   => [

        'hidden' => [
            'exclude' => 1,
            'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config'  => [
                'type' => 'check',
            ],
        ],

        'sender'      => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.sender',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'amount'      => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.amount',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2,required'
            ]
        ],
        'description' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.description',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'text' => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.text',
            'config'  => [
                'type' => 'text',
                'eval' => 'trim',
            ],
        ],
        'image'      => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.image',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'template'    => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.template',
            'config'  => [
                'type'    => 'check',
                'default' => 0
            ]
        ],
        'token'       => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.token',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'created'     => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.created',
            'config'  => [
                'type'     => 'input',
                'size'     => 7,
                'eval'     => 'date',
                'checkbox' => 1,
                'default'  => time()
            ],
        ],
        'error'       => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.error',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'charged'     => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.charged',
            'config'  => [
                'type'     => 'input',
                'size'     => 7,
                'eval'     => 'date',
                'checkbox' => 1,
                'default'  => time()
            ],
        ],
        'currency'    => [
            'exclude' => 0,
            'label'   => 'LLL:EXT:tw_payment/Resources/Private/Language/locallang_db.xlf:tx_twpayment_domain_model_transaction.currency',
            'config'  => [
                'type'          => 'select',
                'foreign_table' => 'tx_twpayment_domain_model_currency',
                'minitems'      => 1,
                'maxitems'      => 1
            ],
        ],

    ],
];
