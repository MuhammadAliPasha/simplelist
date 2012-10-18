<?php
/**
 * Part of the Simplelist bundle for Laravel.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Simplelist
 * @author     BossByte Maciej Sikora
 * @license    BSD License (3-clause)
 * @copyright  (c) 2012, BossByte Maciej Sikora
 * @link       http://www.bossbyte.com
 */
 
namespace SimpleList\Lib;

class Paginator extends \Paginator
{
	static function paginate(\Laravel\Database\Query $query, $per_page = 20, $columns = array('*'))
	{
		
		list($orderings, $query->orderings) = array($query->orderings, null);

		$total = $query->count(reset($columns));

		$page = \Laravel\Paginator::page($total, $per_page);

		$query->orderings = $orderings;

		$results = $query->for_page($page, $per_page)->get($columns);

		return Paginator::make($results, $total, $per_page);
	}
	
	public function links($adjacent = 3)
	{
		/* this part is from orginal method \Laravel\Paginator
		 * *********************************/
		if ($this->last <= 1) return '';
		if ($this->last < 7 + ($adjacent * 2))
		{
			$links = $this->range(1, $this->last);
		}
		else
		{
			$links = $this->slider($adjacent);
		}
		/***********************************/
		
		$content = $this->previous(__('simplelist::simplelist.prev')).' '.$links.' '.$this->next(__('simplelist::simplelist.next'));

		return '<div class="pagination"><ul>'.$content.'</ul></div>';
	}
	
	protected function range($start, $end)
	{
		$pages = array();

		// To generate the range of page links, we will iterate through each page
		// and, if the current page matches the page, we will generate a span,
		// otherwise we will generate a link for the page. The span elements
		// will be assigned the "current" CSS class for convenient styling.
		for ($page = $start; $page <= $end; $page++)
		{
			if ($this->page == $page)
			{
				$pages[] = '<li class="current">'.$page.'</li>';
			}
			else
			{
				$pages[] = '<li>'.$this->link($page, $page, null).'</li>';
			}
		}

		return implode(' ', $pages);
	}
	
	protected function element($element, $page, $text, $disabled)
	{
		$class = "{$element}_page";

		if (is_null($text))
		{
			$text = Lang::line("pagination.{$element}")->get($this->language);
		}

		// Each consumer of this method provides a "disabled" Closure which can
		// be used to determine if the element should be a span element or an
		// actual link. For example, if the current page is the first page,
		// the "first" element should be a span instead of a link.
		if ($disabled($this->page, $this->last))
		{
			return '<li class="'.$class.' disabled" >'.$text.'</li>';
		}
		else
		{
			return '<li>'.$this->link($page, $text, $class).'</li>';
		}
	}
	

}
