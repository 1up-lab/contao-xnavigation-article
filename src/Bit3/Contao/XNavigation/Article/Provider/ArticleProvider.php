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

namespace Bit3\Contao\XNavigation\Article\Provider;

use Bit3\FlexiTree\Event\CollectItemsEvent;
use Bit3\FlexiTree\Event\CreateItemEvent;
use Contao\PageModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ArticleProvider
 */
class ArticleProvider implements EventSubscriberInterface
{

	protected $columns;

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'create-item'   => 'createItem',
			'collect-items' => array('collectItems', 100),
		);
	}

	/**
	 * @return mixed
	 */
	public function getColumns()
	{
		return $this->columns;
	}

	/**
	 * @param mixed $columns
	 */
	public function setColumns($columns)
	{
		$this->columns = deserialize($columns, true);
		return $this;
	}

	public function collectItems(CollectItemsEvent $event)
	{
		$item = $event->getParentItem();

		if ($item->getType() == 'page') {
			if (empty($this->columns)) {
				return;
			}

			$columnWildcards = array_fill(0, count($this->columns), '?');
			$columnWildcards = implode(',', $columnWildcards);

			$t          = \ArticleModel::getTable();
			$arrColumns = array(
				"$t.pid=?",
				"$t.inColumn IN ($columnWildcards)",
			);

			if (!BE_USER_LOGGED_IN) {
				$time         = time();
				$arrColumns[] = "($t.start='' OR $t.start<$time) AND ($t.stop='' OR $t.stop>$time) AND $t.published=1";
			}

			$articles = \ArticleModel::findBy(
				$arrColumns,
				array_merge(array($item->getName()), $this->columns),
				array('order' => 'sorting')
			);

			if ($articles) {
				$factory = $event->getFactory();

				foreach ($articles as $article) {
					$factory->createItem('article', $article->id, $item);
				}
			}
		}
	}

	public function createItem(CreateItemEvent $event)
	{
		$item = $event->getItem();

		if ($item->getType() == 'article') {
			$article = \ArticleModel::findByPk($item->getName());

			if ($article) {
				$page = \PageModel::findByPk($article->pid);

				if ($page) {
					$cssID = deserialize($article->cssID, true);

					$item->setUri(
						\Frontend::generateFrontendUrl($page->row()) . '#' . (empty($cssID[0]) ? $article->alias : $cssID[0])
					);
					$item->setLabel($article->title);

					$item->setExtras($article->row());
				}
			}
		}
	}
}
