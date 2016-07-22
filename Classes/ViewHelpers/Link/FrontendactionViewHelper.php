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
 * <a href="index.php?id=123&tx_myextension_plugin[action]=show&tx_myextension_plugin[controller]=Standard&cHash=xyz">action link</f:link.action>
 * (depending on the current page and your TS configuration)
 * </output>
 */
class FrontendactionViewHelper extends ActionViewHelper {
	/**
	 * TSFE initialization
	 *
	 * @var bool
	 */
	protected static $_initialized = false;
	/**
	 * @var \TYPO3\CMS\Extbase\Service\ExtensionService
	 * @inject
	 */
	protected $extensionService;

	/**
	 * @param string $action Target action
	 * @param array $arguments Arguments
	 * @param string $controller Target controller. If NULL current controllerName is used
	 * @param string $extensionName Target Extension Name (without "tx_" prefix and no underscores). If NULL the current extension name is used
	 * @param string $pluginName Target plugin. If empty, the current plugin name is used
	 * @param int $pageUid target page. See TypoLink destination
	 * @param int $pageType type of the target page. See typolink.parameter
	 * @param bool $noCache set this to disable caching for the target page. You should not need this.
	 * @param bool $noCacheHash set this to suppress the cHash query parameter created by TypoLink. You should not need this.
	 * @param string $section the anchor to be added to the URI
	 * @param string $format The requested format, e.g. ".html
	 * @param bool $linkAccessRestrictedPages If set, links pointing to access restricted pages will still link to the page even though the page cannot be accessed.
	 * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
	 * @param bool $absolute If set, the URI of the rendered link is absolute
	 * @param bool $addQueryString If set, the current query parameters will be kept in the URI
	 * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
	 * @param string $addQueryStringMethod Set which parameters will be kept. Only active if $addQueryString = TRUE
	 * @return string Rendered link
	 */
	public function render($action = NULL, array $arguments = array(), $controller = NULL, $extensionName = NULL, $pluginName = NULL, $pageUid = NULL, $pageType = 0, $noCache = FALSE, $noCacheHash = FALSE, $section = '', $format = '', $linkAccessRestrictedPages = FALSE, array $additionalParams = array(), $absolute = FALSE, $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array(), $addQueryStringMethod = NULL) {

		if (!self::$_initialized) {
			FrontendSimulator::simulateFrontendEnvironment($pageUid);
			$this->extensionService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Service\\ExtensionService');
		}
		
		$request = $this->controllerContext->getRequest();
		if ($action !== NULL) {
			$arguments['action'] = $action;
		}
		if ($controllerName !== NULL) {
			$arguments['controller'] = $controllerName;
		} else {
			$arguments['controller'] = $request->getControllerName();
		}
		if ($extensionName === NULL) {
			$extensionName = $request->getControllerExtensionName();
		}
		if ($pluginName === NULL) {
			$pluginName = $this->extensionService->getPluginNameByAction($extensionName, $arguments['controller'], $arguments['action']);
		}
		if ($pluginName === NULL) {
			$pluginName = $request->getPluginName();
		}
		$pluginNamespace = $this->extensionService->getPluginNamespace($extensionName, $pluginName);

		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uri = $uriBuilder->reset()
			->setTargetPageUid($pageUid)
			->setTargetPageType($pageType)
			->setNoCache($noCache)
			->setUseCacheHash(!$noCacheHash)
			->setSection($section)
			->setFormat($format)
			->setLinkAccessRestrictedPages($linkAccessRestrictedPages)
			->setArguments(array_merge($additionalParams, array($pluginNamespace => $arguments)))
			->setCreateAbsoluteUri($absolute)
			->setAddQueryString($addQueryString)
			->setArgumentsToBeExcludedFromQueryString($argumentsToBeExcludedFromQueryString)
			->setAddQueryStringMethod($addQueryStringMethod)
			->buildFrontendUri();
		$this->tag->addAttribute('href', $uri);
		$this->tag->setContent($this->renderChildren());
		$this->tag->forceClosingTag(TRUE);
		return $this->tag->render();
	}

}
