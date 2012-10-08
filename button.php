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

class Button{
	
	
	public $element;
	public $class;
	public $action;
	public $action_attr;
	public $name;
	
	function __construct()
	{
		
		$this->class=Config::get('simplelist::simplelist.button_class');
		$this->element=Config::get('simplelist::simplelist.button_element');
		$this->action_attr=Config::get('simplelist::simplelist.button_action_attr');
	}
	
	
	function generateAction($row)
	{
		$val=Parser::parse($this->action, $row);
		return $val?$val:$this->action;
	}
	
}