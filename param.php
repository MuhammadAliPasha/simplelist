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
 
namespace SimpleList;
use Config;

class Param{
	
	
	public $sort=false;
	public $default_sort_col=false;
	public $default_sort_type=false;
	
	public $search_cols=array();
	public $query;
	public $per_page=20;
	public $columns=array();
	public $table_class;
	public $bundle;
	public $buttons;
	public $lang_filename;
	public $span_class;
	public $td_class;
	public $url_appends=array();//parameters to append to url
	
	
	public $extended_columns=array();//columns not existing on list but existing in query
	
	public $search_class;
	
	public function __construct()
	{
		$this->table_class=Config::get('simplelist::simplelist.table_class');
		$this->td_class=Config::get('simplelist::simplelist.td_class');
		$this->span_class=Config::get('simplelist::simplelist.span_class');
		$this->lang_filename=Config::get('simplelist::simplelist.lang_filename');
		$this->search_class=Config::get('simplelist::simplelist.search_class');
		$this->per_page=Config::get('simplelist::simplelist.per_page');
	}
	
	public function findColumnComparission($column)
	{
		foreach ($this->columns as $i => $col) 
		{
			if ( $col instanceof \Simplelist\Column)
			{
				if ($col->db==$column)
				return $col->search;
			}else
				if ($col==$column)
				return Search::$COMPARISION_LIKE;
		}
		
		return false;
	}
	
	
}