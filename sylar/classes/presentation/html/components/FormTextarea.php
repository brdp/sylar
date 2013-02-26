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
 * Implements the TEXTAREA html tag
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_FormTextarea extends Sylar_FormComponent{

	private $sContent;
	
	function __construct($sId=null, $sName=null, $sContent=null, $sRows=null, $sCols=null){
		
		parent::__construct();
		
		
		if(!is_null($sId)){
			$this->setId($sId);
		}
		
		if(!is_null($sName)){
			$this->setName($sName);
		}
		
		if(!is_null($sContent)){
			$this->setContent($sContent);
		}else{
			$this->setContent("");
		}
		
		if(!is_null($sCols)){
			$this->setCols($sCols);
		}
		
		if(!is_null($sRows)){
			$this->setRows($sRows);
		}		
	}
	
	
	function __destruct(){
		// nothing to do at the moment
	}


	//								 				   Getter and Setter Methods
	//__________________________________________________________________________

	
	public function setContent($sContent){
		$this->sContent = $sContent;
	}	
	public function getContent(){
		return $this->sContent;
	}	
		
	
	public function setCols($sCols){
		$this->setAttribute("cols", $sCols);
	}
	public function getCols(){
		return $this->getAttribute("cols");
	}
		

	public function setRows($sRows){
		$this->setAttribute("rows", $sRows);
	}	
	public function getRows(){
		$this->getAttribute("rows");
	}	
	
	
	
	/**
	 * Set RedOnly on or off
	 * @param boolean $fReadOnly
	 */
	public function setReadOnly($fReadOnly){
		if($fReadOnly){
			$this->setAttributeWithoutName("readonly", "readonly");
		}else{
			$this->removeAttributeWithoutName("readonly");
		}
	}
	public function getReadOnly(){
		return $this->getAttributeWithoutName("readonly");
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
		
	
	/**
	 * Append text to textarea contents
	 *
	 * @param string $sContent 
	 * @param boolean $bNewLine if is true add a new line before text
	 */
	public function addContent($sContent, $bNewLine=false){
		$this->setContent( $this->getContent().(($bNewLine) ? "\n" : "").$sContent );
	}
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
	
	
	/**
	 * Design Html tag
	 * Using parent method
	 * 
	 * @return string
	 * @see Sylar_Html::provideTagWithAttributes()
	 */
	protected function render(){	
		return $this->openTag().$this->getContent().$this->closeTag();
	}	
	
	
	
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________


	/**
	 * Open the html tag with alla defined attributes
	 *
	 * @return string
	 */	
	private function openTag(){
		return parent::provideTagWithAttributes("textarea");
	}
	
	
	/**
	 * Close the html tag
	 *
	 * @return string
	 */	
	private function closeTag(){
		return "</textarea>";
	}	
	
}

 
 
 
 
?>