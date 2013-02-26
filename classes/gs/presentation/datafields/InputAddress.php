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




import('gs.presentation.datafields.DataField');
import('sylar.presentation.html.components.FormInputText');


/**
 * Implements the input field for valute data
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class GS_InputAddress extends GS_DataField{
	
	function __construct($sId, $sLabel="Address: ", $bRequired=false){	
		parent::__construct($sId, $bRequired);
		
		$this->setLabelContent($sLabel);
		
	}
	
	
	function __destruct(){
		// nothing to do at the moment
	}
		
	//								 				   Getter and Setter Methods
	//__________________________________________________________________________
	

	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
		
	
	/**
	 * return the Htmldiv Object
	 * 
	 * @return Sylar_HtmlDiv
	 */
	public function getField(){
		
		
		
		$this->prepareFormField();
		$this->pack();
				
		return $this->getMain();
	}
	
	
	
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
	
	
		
	
	
	
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________

	
	private function prepareFormField(){
		// Prefix
		$formF1 = new Sylar_FormInputText("p_".$this->getId(), "p_".$this->getId());
		$formF1->setClass("sylarFrmField_address");
		$formF1->setMaxLen(100);
		$formF1->setSize(20);
		
		$formF1->setAttribute("onchange", "javascript:fieldAddressValidate('{$formF1->getId()}');");
				
		$inputSource = $formF1->getHtmlSource();
		$this->setInputContent($inputSource);
		
	}
	
	
	
	
}

 
 
 
 
?>