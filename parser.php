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

class Parser{
	
	/**
	 * Functions parses content string like test/@id/asdas/@par and changes @values into
	 * values from $values array
	 * @param $content - String
	 * @param $values - Array('name'=>value)
	 * 
	 * @return String changed content, when no elements finded then false
	 */
	static function parse($content,$values)
	{
		preg_match_all("/\@([a-z_]+)/",$content,$matches);
		
		$columns=$matches[1];
		$matches=$matches[0];
		
		$size=count($matches);
		
		
		if ($size==0)
		return false;
		
		$i=0;
		while ($i<$size)
		{
			$name=$columns[$i];
			$content=str_replace($matches[$i], $values->$name, $content);
			$i++;
		}
		
		return $content;
	}
	
}