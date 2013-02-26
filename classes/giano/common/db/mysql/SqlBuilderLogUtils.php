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
 
import('sylar.common.db.SqlStatement');

/**
 * Example Class Log Utils
 * 
 * An example class to use Db to extract data about logging in DB
 * 
 * @package Sylar
 * @version 1.0
 * @since 04/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class SqlBuilderLogUtils extends Sylar_SqlStatement{
	
 	function __construct($elemInPage=null){
		parent::__construct();
		
		if(!is_null($elemInPage)){
			settype($elemInPage, "integer");
			$this->setLimitElements($elemInPage);
		}else{
			$this->setLimitElements(30);
		}
	}
	function __destruct(){
		// nothing to do at the moment
	}

	/**
	 * Example Method
	 *
	 * @param $numOfEvents $numOfEvents
	 * @return string
	 */
	public function extractLastEvents($count=false, $limitFrom=0){
				
		// You can apply all formatting to generate sql query
		if($count){
			return "SELECT count(*) as TOT FROM SYLAR_event_log "; 
		}else{
			return "SELECT event_id, level_desc, event_desc FROM SYLAR_event_log ORDER BY event_id ASC LIMIT {$limitFrom}, {$this->getLimitElements()}";
		}
	}
	
}

 
 
 
 
?>