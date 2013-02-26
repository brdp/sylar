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
 * Implements the SELECT html tag
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_FormSelect extends Sylar_FormComponent{

	// the select options array
	private $aOptions; 
	
	function __construct($sId=null, $sName=null, $sSize=null, $bMultiple=false){

		parent::__construct();
		
		$this->aOptions = array();
		
		if(!is_null($sId)){
			$this->setId($sId);
		}
		
		if(!is_null($sName)){
			$this->setName($sName);
		}
		
		if(!is_null($sSize)){
			$this->setSize($sSize);
		}
		
		$this->setMultiple($bMultiple);
	}
	
	
	function __destruct(){
		// nothing to do at the moment
	}


	//								 				   Getter and Setter Methods
	//__________________________________________________________________________
		
	
	public function setSize($sSize){
		$this->setAttribute("size", $sSize);
	}
	public function getSize(){
		return $this->getAttribute("size");
	}
		

	public function setMultiple($bMultiple){
		if($bMultiple){
			$this->setAttributeWithoutName("multiple");
		}else{
			$this->removeAttributeWithoutName("multiple");
		}
	}	
	public function getMultiple(){
		$this->getAttributeWithoutName("multiple");
	}	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
		
	
	/**
	 * add an option in the select options list
	 *
	 * @param string $sLabel
	 * @param string $sValue
	 * @param boolean $bSelected
	 */
	public function addOptionInSelect($sLabel, $sValue, $bSelected=false){
		if(!is_null($sValue) && !is_null($sLabel)){
			$this->aOptions[] = array("value"=>$sValue, "label"=>$sLabel, "selected"=>$bSelected);
		}
	}
	
	
	/**
	 * Add some options in the select options list from an array
	 * <option value="$value">$label</option>
	 *
	 * @param array $aValueLabel array value - label
	 * @param string $sSelectedValue the key of selected items
	 */
	public function addOptionsInSelectFromArray($aValueLabel, $sSelectedValue=null){
		// SELECT options
		if(!is_null($aValueLabel) && is_array($aValueLabel)){
			foreach ($aValueLabel as $value => $label) {
				$this->addOptionInSelect( $label, $value, (($value==$sSelectedValue) ? true : false) );
			}
		}
	}	
	
	
	
	
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
	 * Design Html SELECT tag
	 * Using parent method
	 * 
	 * @return string
	 * @see Sylar_Html::provideTagWithAttributes()
	 */
	protected function render(){	
		$htmlTag = $this->openTag();
		
			// Select Options Loop
			if(!is_null($this->aOptions) && is_array($this->aOptions)){
				foreach ($this->aOptions as $aOption) {
					$htmlTag .= parent::fillTagAttributes("option", array("value"=>$aOption["value"]), (($aOption["selected"]) ? array("selected"=>"selected") : null) ).$aOption["label"]."</option>" ;
				}
			}
		
		$htmlTag .= $this->closeTag();
		
		return $htmlTag;
	}	
	
	
	
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________

	
	/**
	 * Open the html tag with alla defined attributes
	 *
	 * @return string
	 */
	private function openTag(){
		return parent::provideTagWithAttributes("select");
	}
	
	
	/**
	 * Close the html tag
	 *
	 * @return string
	 */	
	private function closeTag(){
		return "</select>";
	}	
	
}

 
 
 
 
?>