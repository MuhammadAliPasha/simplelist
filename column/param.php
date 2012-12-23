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
 
namespace SimpleList\Column;
use Config;

class Param{
	
	/**
	 * @var database column or name from language array
	 */
	public $name;
	/**
	 * @var content like <a href="/@id/test/@par" - it is parsing and in @ tags it adds columns values
	 */
	public $content=false;
	/**
	 * if column is searched
	 */
	public $search=false;
	/**
	 * if column is sorted
	 */
	public $sort=true;
	/**
	 * if $name value is database column name if nodb=true then $db is not database column
	 */
	public $nodb=false;
	
	/**
	 * raw query
	 */
	public $raw=false;
	
	
}