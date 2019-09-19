<?php

namespace Tollwerk\TwPayment\Utility;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Error\Http\ServiceUnavailableException;
use TYPO3\CMS\Core\TimeTracker\TimeTracker;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Page\PageRepository;

/***************************************************************
 *  Copyright notice
 *
 *  © 2016 Dipl.-Ing. Joschi Kuphal <joschi@tollwerk.de>, tollwerk® GmbH
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
 * Frontend simulator
 */
class FrontendSimulator
{
    /**
     * Frontend engine backup
     *
     * @var TypoScriptFrontendController
     */
    protected static $_tsfeBackup = null;
    /**
     * HTTP_HOST backup
     *
     * @var string
     */
    protected static $_httpHostBackup = null;

    /**
     * Instanciates a frontend engine
     *
     * @param \int $id Current page ID
     *
     * @return void
     * @throws ServiceUnavailableException
     */
    public static function simulateFrontendEnvironment($id)
    {
        self::$_tsfeBackup     = isset($GLOBALS['TSFE']) ? $GLOBALS['TSFE'] : null;
        self::$_httpHostBackup = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;

        // Initialize the tracker if necessary
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = new TimeTracker(false);
            $GLOBALS['TT']->start();
        }

        /** @var TypoScriptFrontendController $TSFE */
        $TSFE           = GeneralUtility::makeInstance(
            TypoScriptFrontendController::class,
            $GLOBALS['TYPO3_CONF_VARS'],
            $id,
            0
        );
        $TSFE->sys_page = GeneralUtility::makeInstance(PageRepository::class);
        $TSFE->sys_page->init(true);
        $TSFE->connectToDB();
        $TSFE->initFEuser();
        $TSFE->determineId();
        $TSFE->initTemplate();
        $TSFE->rootLine = $TSFE->sys_page->getRootLine($id, '');
        $TSFE->getConfigArray();

        // Calculate the absolute path prefix
        if (!empty($TSFE->config['config']['absRefPrefix'])) {
            $absRefPrefix       = trim($TSFE->config['config']['absRefPrefix']);
            $TSFE->absRefPrefix = ($absRefPrefix === 'auto') ? GeneralUtility::getIndpEnv(
                'TYPO3_SITE_PATH'
            ) : $absRefPrefix;
        } else {
            $TSFE->absRefPrefix = '';
        }
        // Tweak the HTTP host name
        $domain = BackendUtility::firstDomainRecord($TSFE->rootLine);
        if (!$domain) {
            $domain = array_key_exists('baseURL', $TSFE->config) ?
                parse_url($TSFE->config['baseURL'], PHP_URL_HOST) : '';
        }
        $_SERVER['HTTP_HOST'] = $domain;
    }

    /**
     * Resets the frontend engine
     */
    public static function resetFrontendEnvironment(): void
    {
        $GLOBALS['TSFE']      = self::$_tsfeBackup;
        $_SERVER['HTTP_HOST'] = self::$_httpHostBackup;
    }
}
