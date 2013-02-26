<?php
/*
 * This file is part of Sylar.
 *
 * Sylar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Sylar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Sylar.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @copyright Copyright Sylar Development Team
 * @license http://www.gnu.org/licenses/ GNU Public License V2.0
 * @see https://launchpad.net/sylar/
 * @see http://www.giano-solutions.com
 */


// Controls that the file is always included. Classes Must be included!
if( count(get_included_files())<=1 ){ echo "Wrong Call. Sylar Exit!"; exit; }
// Don't remove!



/**
 * Utility for Sylar
 * 
 * Class that collect the utility to control Sylar systems
 * 
 * @package Sylar
 * @version 1.0
 * @since 16/feb/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_SylarUtils{
	
	/**
	 * Show all sylar costant. All costant that starts with SYLAR_
	 * 
	 * @since 02-2008
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return void
	 */
	public static function showDefinedCostant(){
		foreach (get_defined_constants() as $key => $value ){
			if(substr_count($key, "SYLAR_") > 0 )
				echo "\n".$key." = ".$value;
		}
	}
	
	
	/**
	 * Show all included and required files
	 * 
	 * @since 02-2008
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return void
	 */
	public static function showIncludedFiles(){
		foreach (get_included_files() as $key => $value ){
				echo "\n".$key." = ".$value;
		}
	}
}
 

 
 
?>