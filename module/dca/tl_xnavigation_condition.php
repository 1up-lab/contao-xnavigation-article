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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_xnavigation_condition']['metapalettes']['article_guests']    = array
(
	'condition' => array('type', 'title'),
	'settings'  => array('article_guests_accepted_guests_status', 'invert'),
);
$GLOBALS['TL_DCA']['tl_xnavigation_condition']['metapalettes']['article_protected'] = array
(
	'condition' => array('type', 'title'),
	'settings'  => array('article_members_accepted_protected_status', 'invert'),
);
$GLOBALS['TL_DCA']['tl_xnavigation_condition']['metapalettes']['article_groups']    = array
(
	'condition' => array('type', 'title'),
	'settings'  => array('invert'),
);
$GLOBALS['TL_DCA']['tl_xnavigation_condition']['metapalettes']['article_published'] = array
(
	'condition' => array('type', 'title'),
	'settings'  => array('invert'),
);

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_xnavigation_condition']['fields']['article_guests_accepted_guests_status']     = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['article_guests_accepted_guests_status'],
	'inputType' => 'select',
	'options'   => array('', '1'),
	'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['article_guests_accepted_guests_statuses'],
	'eval'      => array(
		'tl_class' => 'w50',
	),
	'sql'       => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_xnavigation_condition']['fields']['article_members_accepted_protected_status'] = array
(
	'label'     => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['article_members_accepted_protected_status'],
	'inputType' => 'select',
	'options'   => array('', '1'),
	'reference' => &$GLOBALS['TL_LANG']['tl_xnavigation_condition']['article_members_accepted_protected_statuses'],
	'eval'      => array(
		'tl_class' => 'w50',
	),
	'sql'       => "char(1) NOT NULL default ''"
);
