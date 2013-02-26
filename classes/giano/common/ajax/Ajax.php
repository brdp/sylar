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
 
// Controls that the file is always included
if( count(get_included_files())<=1 ){ echo "Wrong Call."; exit; }
// Don't remove!
 

import('sylar.common.ajax.Ajax');


/**
 * Application extension Ajax base class
 * 
 * @package Sylar
 * @version 1.0
 * @since 28/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 class App_Ajax extends Sylar_Ajax {
 
 	
 	/**
	 * Constructor
	 *
	 * @return void
	 * @param boolean $bReferrerCheckActive 
	 */
	function __construct($bReferrerCheckActive=true){
		parent::__construct();
		
		if($bReferrerCheckActive){
			$this->validateReferrer();
		}
		
	}

	
	function __destruct() {
		# nothing to do
	}
	

	
	
	
	
	//								 				   Getter and Setter Methods
	//__________________________________________________________________________		
	
 	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________	


	
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________	
	
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________	
	
	
 	
 }
 
 
 
?>