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


import('sylar.presentation.html.components.FormComponent');



/**
 * Implements the INPUT TYPE=CHECKBOX html tag
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_FormInputCheckbox extends Sylar_FormComponent{

	
	function __construct($sId=null, $sName=null, $Value=null, $bChecked=false){
		
		parent::__construct();
		
		$this->setAttribute("type", "checkbox");	
		
		if(!is_null($sId)){
			$this->setId($sId);
		}
		
		if(!is_null($sName)){
			$this->setName($sName);
		}
		
		if(!is_null($Value)){
			$this->setValue($Value);
		}
		
		if($bChecked){
			$this->setAttributeWithoutName("checked");
		}
	}
	
	
	function __destruct(){
		// nothing to do at the moment
	}


	//								 				   Getter and Setter Methods
	//__________________________________________________________________________

	
	public function setValue($sValue){
		$this->setAttribute("value", $sValue);
	}	
	public function getValue(){
		return $this->getAttribute("value");
	}	
		
	
	//								 							  Public Methods
	//__________________________________________________________________________
		
	
	
	/**
	 * return the Html source
	 * it return html code of entire object
	 * 
	 * implements the abstract method
	 * 
	 * @return string
	 */
	public function getHtmlSource(){
		return $this->render();
	}
	
	
	/**
	 * Display the page
	 * it prints the object Html source on screen
	 * 
	 * implements the abstract method
	 * 
	 * @return void
	 */
	public function show(){
		echo $this->render();
	}	
		
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
	
	
	/**
	 * Design Html INPUT tag
	 * Using parent method
	 * 
	 * @return string
	 * @see Sylar_Html::provideTagWithAttributes()
	 */
	protected function render(){	
		return parent::provideTagWithAttributes("input", true);
	}	
	
	
	
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________

	
	
}

 
 
 
 
?>