<?php

/**
 * xNavigation - Highly extendable and flexible navigation module for the Contao Open Source CMS
 *
 * Copyright (C) 2013 bit3 UG <http://bit3.de>
 *
 * @package    xNavigation
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @link       http://www.themeplus.de
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\Contao\XNavigation\Article;

use Bit3\Contao\XNavigation\Event\EvaluateRootEvent;
use Bit3\Contao\XNavigation\Twig\TwigExtension;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class XNavigationArticleEvents
 */
class XNavigationArticleEvents
{
	/**
	 * The BUILD_ARTICLE_SECTIONS event occurs to create an options list of article sections.
	 *
	 * The event listener method receives a ContaoCommunityAlliance\Contao\Events\CreateOptions\CreateOptionsEvent instance.
	 *
	 * @var string
	 *
	 * @api
	 */
	const BUILD_ARTICLE_SECTIONS = 'xnavigation-content.build-article-sections';
}
