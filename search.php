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
use Input;
use View;

class Search{
	
	private $columns;
	private $label;
	private $param;
	
	public $column;
	public $value;
	
	static $COMPARISION_EQUAL="=";
	static $COMPARISION_LIKE="LIKE";
	static $COMPARISION_LESS="<";
	static $COMPARISION_MORE=">";
	static $COMPARISION_MORE_EQUAL=">=";
	static $COMPARISION_LESS_EQUAL="<=";
	
	function __construct($columns,$param){
		
		$this->columns=$columns;
		$this->param=$param;
	}
	
	function render(){
		return View::make('simplelist::search')->with('columns',$this->columns)
		->with('s_column',Input::get('s_column'))
		->with('s_value',Input::get('s_value'))
		->with('param',$this->param);
	}
	/**
	 * add where to query
	 */
	function run(){
		
		$column=Input::get('s_column');
		
		if (is_array($this->columns)){
			
			if (!in_array($column,$this->columns))
			return;

		}else{
			
			if ($column!=$this->columns)
			return;
		
		}
		
		$value=Input::get('s_value');
		
		if (!$column || !$value)
		return;
		
		$this->column=$column;
		$this->value=$value;
		
		
		
		$comp=$this->param->findColumnComparission($column);
		
		if (!$comp)
		$comp=self::$COMPARISION_LIKE;
		
		if ($comp==self::$COMPARISION_LIKE)
		return $this->param->query->where($column, $comp, '%'.$value.'%');

		return $this->param->query->where($column, $comp, $value);
	}
	
	/*
	//check column is alias 
	private function isAlias($column)
	{
		return (strpos($column,'as')!==false);
	}
	
	//gets name of column before aliases
	private function getOrginalName($column)
	{
			$pos_as=strpos($column,'as');
			return substr($column, 0, $pos_as);
	}
	
	public function getParsedName($column){
		
		foreach ($this->param->columns as $col)
		{
			if ($col->orginal_name==$column)
			{
				return $col->db;
			}
		}
		
		return $column;
	}
	*/
}