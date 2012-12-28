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

class Column{
	
	
	public $db;
	public $content;
	public $raw;//raw query
	
	//@{column} is content value to change
	/**
	 * @param $name - column in database
	 * @param $content - content like img src="@id/folder"
	 * @param search - if is searched column
	 * @param $nodb - if true $db param is not in database and is only used for column header
	 */
	function __construct($name,$content=false,$search=false,$sort=true,$nodb=false,$raw=false)
	{
		$this->orginal_name=$this->parse($name,false);//name used by user and sql
		$this->db=$name;//this is parsed by parseDb and have only column name without as and dots
		$this->content=$content;
		$this->nodb=$nodb;
		$this->sort=$sort;
		$this->raw=$raw;
		
		$this->search=$search?$search:Search::$COMPARISION_LIKE;
		
	}
	
	static function createByParam(\SimpleList\Column\Param $param)
	{
		$obj=new Column($param->name,$param->content,$param->search,$param->sort,$param->nodb,$param->raw);
		return $obj; 
	}
	
	
	public function parseDb()
	{
		$this->db=$this->parse($this->db);
	}
	
	
	private function getOrginalName($name)
	{
		$pos_as=strpos($name,'as');
		
		if ($pos_as===false)
		return $this->parse($name);
		else
			return $this->parse(substr($name,0,$pos_as),false);
	}
	
	/**
	 * removes dots and as words, gets only column names
	 */
	private function parse($column ,$dot=true)
	{
		$pos_as=strpos($column,'as');
		
		if ($pos_as===false)//no as in name
		{
			if ($dot)//remove table name before .
			{
				$pos_dot=strpos($column,'.');
				if ($pos_dot!==false)
				{
					//we have dot so we get only column without table name
					return substr($column, $pos_dot+1);
				}
			}	
		}else
			{
				//we have alias so we get only column without table name
				$alias=substr($column, $pos_as+3);
				
				if (SimpleList::$sort_by==$alias)
				{
					//we have this alias in sort so we change sort to orginal name
					SimpleList::$sort_by=substr($column, 0, $pos_as-1);
					SimpleList::$sort_by_alias=true;
				}
				
				return $alias;
				
			}
		
		return $column;
	}
	
	
	
	public function generateContent($row)
	{
		$name=$this->db;
		if (!$this->content){
				
			if ($row->$name)
			return $row->$name;
			else
				return __(Simplelist::getParam()->bundle.'::'.Simplelist::getParam()->lang_filename.'.null');//if no value
			
			}		
					
		$content=$this->content;
		
		$content=Parser::parse($content,$row);
		
		if (!$content)
		return $row->$name;
		
		return $content;
		
	}
	
}