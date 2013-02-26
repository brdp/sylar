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
 

import('sylar.presentation.html.Html');



/**
 * Implements the FORM html tag
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_Form extends Sylar_Html{

	private $sContent;
	
	function __construct($sId=null, $sName=null, $sAction=null, $sMethod='get'){
		
		parent::__construct();

		$this->setContent("");
		
		if(!is_null($sId)){
			$this->setId($sId);
		}
		
		if(!is_null($sName)){
			$this->setName($sName);
		}

		if(!is_null($sAction)){
			$this->setAction($sAction);
		}
				
		$this->setMethod($sMethod);
			
	}
	
	
	function __destruct(){
		// nothing to do at the moment
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
		
	
	public function setContent($sContent){
		$this->sContent = $sContent;
	}	
	public function getContent(){
		return $this->sContent;
	}	
		
	
	public function setAction($sAction){
		$this->setAttribute("action", $sAction);
	}	
	public function getAction(){
		return $this->getAttribute("action");
	}	
		
	
	public function setMethod($sMethod){
		$this->setAttribute("method", $sMethod);
	}
	public function getMethod(){
		return $this->getAttribute("method");
	}
		
	
	/**
	 * Standard possible value are:
	 * ENCTYPE = "multipart/form-data" | "application/x-www-form-urlencoded" | "text/plain"
	 * default is application/x-www-form-urlencoded
	 *
	 * @param string $sEnctype multipart/form-data | application/x-www-form-urlencoded | text/plain
	 */
	public function setEnctype($sEnctype){
		$this->setAttribute("enctype", $sEnctype);
	}	
	public function getEnctype(){
		$this->getAttribute("enctype");
	}		
	
	
	/**
	 * Standard possible value as target are:
	 * 
	 * _blank: the target URL will open in a new window
     * _self: the target URL will open in the same frame as it was clicked
     * _parent: the target URL will open in the parent frameset
     * _top: the target URL will open in the full body of the window
     * name: a specified Window, frame o iframe name
	 * 
	 * @param string $sTarget _blank | _self | _parent | _top | Custom window, frame or iframe
	 */
	public function setTarget($sTarget){
		$this->setAttribute("target", $sTarget);
	}	
	public function getTarget(){
		$this->getAttribute("target");
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
	 * Open the html tag with alla defined attributes
	 *
	 * @return string
	 */
	public function openTag(){
		return parent::provideTagWithAttributes("form");
	}
	

	/**
	 * Close the html tag
	 *
	 * @return string
	 */	
	public function closeTag(){
		return "</form>";
	}
	
	
	/**
	 * Append html code to form contents
	 *
	 * @param string $sContent html code to insert into form tags
	 * @param boolean $bNewLine if is true add a new line before text
	 */	
	public function addHtmlContent($sContent, $bNewLine=false){
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

	
	
}

 
 
 
 
?>