<?php

namespace Tollwerk\TwPayment\ViewHelpers\Link;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

use Tollwerk\TwPayment\Utility\FrontendSimulator;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Service\ExtensionService;
use TYPO3\CMS\Fluid\ViewHelpers\Link\ActionViewHelper;

/**
 * A view helper for creating links to extbase actions.
 *
 * = Examples =
 *
 * <code title="link to the show-action of the current controller">
 * <f:link.action action="show">action link</f:link.action>
 * </code>
 * <output>
 * <a
 * href="index.php?id=123&tx_myextension_plugin[action]=show&tx_myextension_plugin[controller]=Standard&cHash=xyz">action
 * link</f:link.action>
 * (depending on the current page and your TS configuration)
 * </output>
 */
class FrontendactionViewHelper extends ActionViewHelper
{
    /**
     * TSFE initialization
     *
     * @var bool
     */
    protected static $_initialized = false;
    /**
     * Extension service
     *
     * @var ExtensionService
     */
    protected $extensionService;

    /**
     * Inject the extension service
     *
     * @param ExtensionService $extensionService
     */
    public function injectExtensionService(ExtensionService $extensionService): void
    {
        $this->extensionService = $extensionService;
    }

    /**
     *
     * @return string Rendered link
     * @throws \TYPO3\CMS\Core\Error\Http\ServiceUnavailableException
     * @throws \TYPO3\CMS\Extbase\Exception
     */
    public function render()
    {
        $action                               = $this->arguments['action'];
        $arguments                            = $this->arguments['arguments'];
        $controller                           = $this->arguments['controller'];
        $extensionName                        = $this->arguments['extensionName'];
        $pluginName                           = $this->arguments['pluginName'];
        $pageUid                              = (int)$this->arguments['pageUid'] ?: null;
        $pageType                             = (int)$this->arguments['pageType'];
        $noCache                              = (bool)$this->arguments['noCache'];
        $noCacheHash                          = (bool)$this->arguments['noCacheHash'];
        $section                              = (string)$this->arguments['section'];
        $format                               = (string)$this->arguments['format'];
        $linkAccessRestrictedPages            = (bool)$this->arguments['linkAccessRestrictedPages'];
        $additionalParams                     = (array)$this->arguments['additionalParams'];
        $absolute                             = (bool)$this->arguments['absolute'];
        $addQueryString                       = (bool)$this->arguments['addQueryString'];
        $argumentsToBeExcludedFromQueryString = (array)$this->arguments['argumentsToBeExcludedFromQueryString'];
        $addQueryStringMethod                 = $this->arguments['addQueryStringMethod'];

        if (!self::$_initialized) {
            FrontendSimulator::simulateFrontendEnvironment($pageUid);
            $this->extensionService = GeneralUtility::makeInstance(ExtensionService::class);
        }

        /** @var ControllerContext $controllerContext */
        $controllerContext = $this->renderingContext->getControllerContext();
        $request           = $controllerContext->getRequest();
        if ($action !== null) {
            $arguments['action'] = $action;
        }
        if ($controller !== null) {
            $arguments['controller'] = $controller;
        } else {
            $arguments['controller'] = $request->getControllerName();
        }
        if ($extensionName === null) {
            $extensionName = $request->getControllerExtensionName();
        }
        if ($pluginName === null) {
            $pluginName = $this->extensionService->getPluginNameByAction(
                $extensionName,
                $arguments['controller'],
                $arguments['action']
            );
        }
        if ($pluginName === null) {
            $pluginName = $request->getPluginName();
        }
        /** @var UriBuilder $uriBuilder */
        $pluginNamespace = $this->extensionService->getPluginNamespace($extensionName, $pluginName);
        $uriBuilder      = $controllerContext->getUriBuilder();
        $uri             = $uriBuilder->reset()
                                      ->setTargetPageUid($pageUid)
                                      ->setTargetPageType($pageType)
                                      ->setNoCache($noCache)
                                      ->setUseCacheHash(!$noCacheHash)
                                      ->setSection($section)
                                      ->setFormat($format)
                                      ->setLinkAccessRestrictedPages($linkAccessRestrictedPages)
                                      ->setArguments(array_merge($additionalParams,
                                          array($pluginNamespace => $arguments)))
                                      ->setCreateAbsoluteUri($absolute)
                                      ->setAddQueryString($addQueryString)
                                      ->setArgumentsToBeExcludedFromQueryString($argumentsToBeExcludedFromQueryString)
                                      ->setAddQueryStringMethod($addQueryStringMethod)
                                      ->buildFrontendUri();
        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }

}
