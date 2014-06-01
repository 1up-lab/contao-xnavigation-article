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

use Bit3\Contao\XNavigation\Event\CreateDefaultConditionEvent;
use Bit3\Contao\XNavigation\Event\EvaluateRootEvent;
use Bit3\Contao\XNavigation\Model\ConditionModel;
use Bit3\Contao\XNavigation\Twig\TwigExtension;
use Bit3\Contao\XNavigation\XNavigationEvents;
use ContaoCommunityAlliance\Contao\Events\CreateOptions\CreateOptionsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DefaultSubscriber
 */
class DefaultSubscriber implements EventSubscriberInterface
{
	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			XNavigationEvents::CREATE_DEFAULT_CONDITION      => 'createDefaultCondition',
			XNavigationArticleEvents::BUILD_ARTICLE_SECTIONS => 'buildArticleSections',
		);
	}

	public function createDefaultCondition(CreateDefaultConditionEvent $event)
	{
		$root          = new ConditionModel();
		$root->pid     = $event->getCondition()->id;
		$root->sorting = 128;
		$root->type    = 'and';
		$root->save();

		// article type
		$condition                          = new ConditionModel();
		$condition->pid                     = $root->id;
		$condition->sorting                 = 128;
		$condition->type                    = 'item_type';
		$condition->item_type_accepted_type = 'article';
		$condition->save();

		// article published
		$condition          = new ConditionModel();
		$condition->pid     = $root->id;
		$condition->sorting = 256;
		$condition->type    = 'article_published';
		$condition->save();

		// login status
		$or          = new ConditionModel();
		$or->pid     = $root->id;
		$or->sorting = 512;
		$or->type    = 'or';
		$or->save();

		{
			// unprotected articles
			$and          = new ConditionModel();
			$and->pid     = $or->id;
			$and->sorting = 128;
			$and->type    = 'and';
			$and->save();

			{
				// login status -> not protected
				$condition                                            = new ConditionModel();
				$condition->pid                                       = $and->id;
				$condition->sorting                                   = 128;
				$condition->type                                      = 'article_protected';
				$condition->article_members_accepted_protected_status = '';
				$condition->save();

				// login status -> not logged in
				$condition                                     = new ConditionModel();
				$condition->pid                                = $and->id;
				$condition->sorting                            = 256;
				$condition->type                               = 'member_login';
				$condition->member_login_accepted_login_status = 'logged_out';
				$condition->save();

				// login status -> article guests only
				$condition                                        = new ConditionModel();
				$condition->pid                                   = $and->id;
				$condition->sorting                               = 512;
				$condition->type                                  = 'article_guests';
				$condition->article_guests_accepted_guests_status = '';
				$condition->save();
			}
		}

		{
			// protected articles
			$and          = new ConditionModel();
			$and->pid     = $or->id;
			$and->sorting = 256;
			$and->type    = 'and';
			$and->save();

			{
				// login status -> protected
				$condition                                            = new ConditionModel();
				$condition->pid                                       = $and->id;
				$condition->sorting                                   = 128;
				$condition->type                                      = 'article_protected';
				$condition->article_members_accepted_protected_status = '';
				$condition->save();

				// login status -> article groups
				$condition          = new ConditionModel();
				$condition->pid     = $and->id;
				$condition->sorting = 256;
				$condition->type    = 'article_groups';
				$condition->save();
			}
		}
	}

	public function buildArticleSections(CreateOptionsEvent $event)
	{
		$options = $event->getOptions();

		$sections           = $options->getArrayCopy();
		$sections['header'] = 'header';
		$sections['left']   = 'left';
		$sections['right']  = 'right';
		$sections['main']   = 'main';
		$sections['footer'] = 'footer';

		$layouts = \LayoutModel::findBy(array('sections!=?'), array(''));

		if ($layouts) {
			foreach ($layouts as $layout) {
				$temp = trimsplit(',', $layout->sections);

				foreach ($temp as $section) {
					if (!in_array($section, $sections)) {
						$sections[$section] = $section;
					}
				}
			}
		}

		$options->exchangeArray($sections);
	}

	/**
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @SuppressWarnings(PHPMD.CamelCaseVariableName)
	 * @return \PageModel
	 */
	protected function getCurrentPage()
	{
		return $GLOBALS['objPage'];
	}
}
