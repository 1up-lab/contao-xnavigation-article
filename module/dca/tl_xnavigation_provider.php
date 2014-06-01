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


\Controller::loadLanguageFile('tl_article');

/**
 * Table tl_xnavigation_provider
 */
$GLOBALS['TL_DCA']['tl_xnavigation_provider']['metapalettes']['article'] = array
(
	'provider' => array('type', 'title'),
	'article'  => array('article_columns'),
);

$GLOBALS['TL_DCA']['tl_xnavigation_provider']['fields']['article_columns'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_xnavigation_provider']['article_columns'],
	'inputType'        => 'checkboxWizard',
	'options_callback' => \ContaoCommunityAlliance\Contao\Events\CreateOptions\CreateOptionsEventCallbackFactory::createCallback(
		\Bit3\Contao\XNavigation\Article\XNavigationArticleEvents::BUILD_ARTICLE_SECTIONS
	),
	'reference'        => &$GLOBALS['TL_LANG']['tl_article'],
	'eval'             => array(
		'mandatory' => true,
		'multiple'  => true,
	),
	'sql'              => "text NULL"
);
