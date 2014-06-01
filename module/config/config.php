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


/**
 * Event listener
 */
$GLOBALS['TL_EVENT_SUBSCRIBERS'][] = 'Bit3\Contao\XNavigation\Article\DefaultSubscriber';

/**
 * Provider
 */
$GLOBALS['XNAVIGATION_PROVIDER']['article'] = 'Bit3\Contao\XNavigation\Article\Provider\ArticleProvider';

/**
 * Conditions
 */
$GLOBALS['XNAVIGATION_CONDITION']['article_guests']    = 'Bit3\Contao\XNavigation\Article\Condition\ArticleGuestsCondition';
$GLOBALS['XNAVIGATION_CONDITION']['article_protected'] = 'Bit3\Contao\XNavigation\Article\Condition\ArticleProtectedCondition';
$GLOBALS['XNAVIGATION_CONDITION']['article_groups']    = 'Bit3\Contao\XNavigation\Article\Condition\ArticleGroupsCondition';
$GLOBALS['XNAVIGATION_CONDITION']['article_published'] = 'Bit3\Contao\XNavigation\Article\Condition\ArticlePublishedCondition';
