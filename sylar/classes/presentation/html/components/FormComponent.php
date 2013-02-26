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
 * Abstract Class for Html Form Component
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
 
import('sylar.presentation.html.Html');



/**
 * Abstract class for all form components tag.
 * 
 * From this extends: 
 * Sylar_FormInputText
 * Sylar_FormInputHidden
 * Sylar_FormInputPassword
 * Sylar_FormInputButton
 * Sylar_FormInputReset
 * Sylar_FormInputSubmit
 * Sylar_FormCheckbox
 * Sylar_FormRadio
 * Sylar_FormSelect
 * Sylar_FormTextarea
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
abstract class Sylar_FormComponent extends Sylar_Html{
	
	
	function __construct(){
		parent::__construct();
	}
	
	
	function __destruct(){
		// nothing to do at the moment
		parent::__destruct();
	}


	//								 				   Getter and Setter Methods
	//__________________________________________________________________________
	
	public function setId($sId){
		$this->setAttribute("id", $sId);
	}
	public function getId(){
		return $this->getAttribute("id");
	}
	
	public function setName($sName){
		$this->setAttribute("name", $sName);
	}	
	public function getName(){
		return $this->getAttribute("name");
	}
	
	public function setStyle($sStyle){
		$this->setAttribute("style", $sStyle);
	}
	public function getStyle(){
		return $this->getAttribute("style");
	}	
	
	public function setClass($sCssClass){
		$this->setAttribute("class", $sCssClass);
	}
	public function getClass(){
		return $this->getAttribute("class");
	}	

	public function setTitle($sTitle){
		$this->setAttribute("title", $sTitle);
	}
	public function getTitle(){
		return $this->getAttribute("title");
	}	
	
	/**
	 * Set Tag disabled if $bIsDisabled is true, enabled otherwise.
	 *
	 * @param boolean $bIsDisabled flag true, false
	 */
	public function setDisabled($bIsDisabled){
		if($bIsDisabled){
			$this->setAttributeWithoutName("disabled");
		}else{
			$this->removeAttributeWithoutName("disabled");
		}
	}
	public function getDisabled(){
		return $this->getAttributeWithoutName("disabled");
	}	
	
	
	/**
	 * Not use with tag: SELECT
	 * @param $sOnClick
	 * @param boolean $fUseJs used to add automatically javascript: code on event
	 */
	public function setOnClick($sOnClick, $bUseJs=true){
		if($bUseJs){
			$sOnClick = "javascript:{$sOnClick}";
		}
		$this->setAttribute("onclick", $sOnClick);
	}	
	public function getOnClick(){
		$this->getAttribute("onclick");
	}		
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
		

	/**
	 * return the Html source
	 * it return html code of entire object
	 * 
	 * @return string
	 */
	abstract public function getHtmlSource();
	
	
	/**
	 * Display the page
	 * it prints the object Html source on screen
	 * 
	 * @return void
	 */
	abstract public function show();
		
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________

	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________

	
	
}
 
 
?>