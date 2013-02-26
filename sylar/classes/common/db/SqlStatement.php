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
 * Sql Statement
 * The common Sql statement tools for manage SQL command. Every Database 
 * classes extends this to specify special command and actions
 * 
 * @package Sylar
 * @version 1.0
 * @since 16/feb/08
 * 
 * @todo   To be done
 * 
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */ 
 Class Sylar_SqlStatement{

 	/** number of element to limit */
 	private $limitElements;
 	
 	private $orderBy;
 	private $orderDir="ASC";
	


 	
 	
  	function __construct(){
	}
	function __destruct(){
		// nothing to do at the moment
	}
		
	
	
	
	//								 				   Getter and setter Methods
	//__________________________________________________________________________		
	
 	public function getLimitElements() {
		return $this->limitElements;
	}
	
	public function getOrderBy() {
		return $this->orderBy;
	}
	
	public function getOrderDir() {
		return $this->orderDir;
	}
	
	public function setLimitElements($limitElements) {
		$this->limitElements = $limitElements;
	}
	
	public function setOrderBy($orderBy) {
		$this->orderBy = $orderBy;
	}
	
	public function setOrderDir($orderDir) {
		$this->orderDir = $orderDir;
	}
	
	

	
	//								 							  Public Methods
	//__________________________________________________________________________	
	
	
	
	
	
	
	
	

	
	
	//								 						   Protected Methods
	//__________________________________________________________________________	
	


	
	
	

	
	
	//								 						     Private Methods
	//__________________________________________________________________________
		
	
	
	
	
	
 }
 
 
?>