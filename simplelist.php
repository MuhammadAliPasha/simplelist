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
use SimpleList\Lib\Paginator;
use View;
use Input;
/**
 * Class provides complex listing for Db rows with:
 * - search over many columns
 * - sorting every column
 * - pagination
 * - action buttons
 * - column value flexibility
 */
class SimpleList{
	
	static $sorttypes=array('desc','asc');
	static $param=false;
	
	
	static function getParam()
	{
		return static::$param;
	}
	/**
	 * generates view with rows, buttons and columns
	 */
	static function generate(Param $param)
	{
		$rows=static::make($param);
		return View::make('simplelist::list')->with('rows',$rows)->with('param',$param);
	}
	
	/**
	 * It returns only generated rows. It can be used to different view
	 * @param {Param} $param
	 */
	static function make(Param $param)
	{
		
		static::$param=$param;//set Param
		
		if (count($param->columns)==0)
		throw new Exception ('No columns defined!');
		
		$colarr=self::_columnsParse($param->columns);
		
		$param->dbcolumns=array_merge($colarr['db'],$param->extended_columns);//merge extended columns with normal columns
		$param->columns=$colarr['norm'];
		
		if ($param->search_cols)
		{
			$param->search=new Search($param->search_cols,$param);
			$param->search->run();
		}
		
		if (Input::get('sort'))
		{
			//is sorted
			$param->sorted_type=(Input::get('sorttype')==self::$sorttypes[0])?self::$sorttypes[0]:self::$sorttypes[1];
			
			if (in_array(Input::get('sort'), $param->dbcolumns) && in_array($param->sorted_type,self::$sorttypes))
			$param->query->order_by(Input::get('sort'),$param->sorted_type);
			
			$param->sorted_type=($param->sorted_type==self::$sorttypes[0])?self::$sorttypes[1]:self::$sorttypes[0];
			$param->sorted_now=Input::get('sort');
		}else
			{
				 $param->sorted_type=self::$sorttypes[0];
			     $param->sorted_now=false;
				 
				 //default sort set
				 if ($param->default_sort_col && $param->default_sort_type)
				 $param->query->order_by($param->default_sort_col,$param->default_sort_type);
				 
			}

		$rows = Paginator::paginate($param->query,$param->per_page,$param->dbcolumns);
		self::setUrlAppends($param, $rows);
		
		return $rows;
	}
	
	/**
	 * parsing array to url
	 */
	static function _parseToUrl($appends)
	{
		$url="";
		foreach ($appends as $key => $value) {
			$url.='&'.$key.'='.$value;
		}
		
		return $url;
	}
	
	/**
	 * it sets current URI to sort and search urls
	 */
	static function setUrlAppends($param,$rows)
	{
		$sort_append=static::_parseToUrl($param->url_appends);
		$append=$param->url_appends;
		if ($param->sorted_now)
		{
			$append=array_merge($append,array('sort' => $param->sorted_now,'sorttype'=>Input::get('sorttype')));
		}
		
		if (isset($param->search) && $param->search->column)
		{
			$append=array_merge($append,array('s_column' => $param->search->column,'s_value'=>$param->search->value));
			$sort_append.='&s_column='.$param->search->column.'&s_value='.$param->search->value;
		}
		
		$rows->appends($append);
		$param->sort_append=$sort_append;
	}
	
	/**
	 * parses column for only column names without tables and dots
	 */
	static function _columnsParse($columns)
	{
		$size=count($columns);
		$dbcolumns=array();
		$norcolumns=array();
		for ($i=0; $i<$size; $i++)
		{
			if (is_string($columns[$i]))
			{
				$dbcolumns[]=$columns[$i];
					$col=new Column($columns[$i]);
					$col->parseDb();//remove table names and dots
					$norcolumns[$col->db]=$col;
			}else
				{	
					if (!$columns[$i]->nodb)
					{
						$dbcolumns[]=$columns[$i]->db;
						$columns[$i]->parseDb();//remove table names and dots
					}
					
					$norcolumns[$columns[$i]->db]=$columns[$i];
				}
		}
		
		return array('db'=>$dbcolumns,'norm'=>$norcolumns);
	}
}
