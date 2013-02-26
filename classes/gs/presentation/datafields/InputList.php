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
import('sylar.presentation.html.components.FormSelect');



/**
 * Implements the input field for email data
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class GS_InputList extends GS_DataField
{
	private $oSelect;
	
	function __construct($sId, $sLabel="Regione", $bRequired=false){	
		parent::__construct($sId, $bRequired);
		$this->setLabelContent($sLabel);
		
		
		$this->setSelect( new Sylar_FormSelect($this->getId(),$this->getId()) );
	}
	
	function __destruct(){
		// nothing to do at the moment
	}


	//								 				   Getter and Setter Methods
	//__________________________________________________________________________

	public function setSelect(Sylar_FormSelect $objSelect){
		$this->oSelect = $objSelect;
	}
	/** @return Sylar_FormSelect */
	public function getSelect(){
		return $this->oSelect;
	}

	
	//								$list 							  Public Methods
	//__________________________________________________________________________
		
	
	/**
	 * return the Htmldiv Object
	 * 
	 * @return void
	 */
	public function fillFromArray($aValueLabel, $sSelectedValue=null){
		$this->getSelect()->addOptionsInSelectFromArray($aValueLabel, $sSelectedValue);
	}
	
	public function fillFromBind(){
		
	}
	
	public function getField(){
		
		$this->prepareFormField();
		$this->pack();
				
		return $this->getMain();		
	}
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
	
	//								 							 Private Methods
	//__________________________________________________________________________

	private function prepareFormField($list)
	{
		$formField = new Sylar_FormSelect($this->getId(),$this->getId());
		$this->getSelect()->setClass("sylarFrmField_select");

		$this->setInputContent($this->getSelect()->getHtmlSource());
	}
}
?>
