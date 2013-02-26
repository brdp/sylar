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
 * Html DIV
 * 
 * Manage html tag <DIV>, its attributes and content
 * 
 * <div id="globalheader" name="globalheader" class="header" style="width:100%;">
 * 
 * @package Sylar
 * @version 1.0
 * @since 31/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_HtmlDiv extends Sylar_Html{
	private $sId;
	private $sName;
	private $sClass;
	private $sStyle;
	private $sContent;
	
	/**
	 * Constructor
	 *
	 * @param string $sId Div ID in Sylar and in HTML tag. If not setted Sylar generate it
	 * @param string $nName Name o html tag
	 * @param string $sClass css class for tag div
	 * @param string $sStyle style attribute for tag Div
	 */
	function __construct($sId=null, $sName=null, $sClass=null, $sStyle=null){
		
		parent::__construct();
		
		if(is_null($sId)){
			$this->setId( uniqid('SylarId_', true) );
		}else{
			$this->setId( $sId );
		}
		
		$this->setName($sName);
		$this->setClass($sClass);
		$this->setStyle($sStyle);
	}
	
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	
	//								 						   Setter and Getter
	//__________________________________________________________________________
	
	
	public function setId($sId){
		$this->sId=$sId;
	}
	public function getId(){
		return $this->sId;
	}
	
	public function setName($sName){
		$this->sName=$sName;
	}
	public function getName(){
		return $this->sName;
	}
	
	public function setClass($sClass){
		$this->sClass=$sClass;
	}
	public function getClass(){
		return $this->sClass;
	}
	
	public function setStyle($sStyle){
		$this->sStyle=$sStyle;
	}
	public function getStyle(){
		return $this->sStyle;
	}
	
	public function setContent($sContent){
		$this->sContent=$sContent;
	}
	public function getContent(){
		return $this->sContent;
	}
	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
	
	
	/**
	 * Append text into DIV 
	 *
	 * @deprecated 
	 * @see new push methods example pushString, pushDiv ecc...
	 * 
	 * @return void
	 * 
	 * @param string $sContent Text to append
	 * @param boolean $bNewLine 
	 */
	public function appendContent($sContent, $bNewLine=false){
		$newLine = "";
		if($bNewLine){ $newLine = "\n";}
		
		$this->setContent($this->getContent().$newLine.$sContent);
	}
	
	
	/**
	 * Append  a String in this object htmlSource
	 * 
	 * @return void
	 * 
	 * @param string $sHtmlCode Text to append
	 * @param boolean $bNewLine 
	 */
	public function pushString($sHtmlCode, $bNewLine=false){
		$newLine = "";
		if($bNewLine){ $newLine = "\n";}
		
		$this->setContent($this->getContent().$newLine.$sHtmlCode);
	}	
	
	
	
	
	/**
	 * Append and nest a Div in this div
	 *
	 * @return void
	 * @param Sylar_HtmlDiv $oDiv
	 * @param boolean $bNewLine 
	 */
	public function nestDiv(Sylar_HtmlDiv $oDiv,  $bNewLine=false){
				
		// merge the required js and css files
		$this->mergeRequiredAppCssFiles($oDiv->getRequiredAppCssFiles());
		$this->mergeRequiredAppJsFiles($oDiv->getRequiredAppJsFiles());
		$this->mergeRequiredSylarCssFiles($oDiv->getRequiredSylarCssFiles());
		$this->mergeRequiredSylarJsFiles($oDiv->getRequiredSylarJsFiles());
		
		$this->appendContent($oDiv->getHtmlSource(), $bNewLine);
		
		//TODO IMPORTANT Store the DOM as object not as string!
	}
	
	
	/**
	 * return the Html source
	 * it return html code of entire object
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
	 * @return void
	 */
	public function show(){
		echo $this->render();
	}
	
	
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
	
	
	/**
	 * Format Html Tag DIV
	 * It prepare the tag html <DIV> with all attributes and content.
	 * It return a string that contains the div html code
	 *
	 * @return string
	 * 
	 * @param string $sContent
	 */
	protected function render($sContent=null){
		if(!is_null($sContent)){
			$this->setContent($sContent);
		}	

		$aAttributes = array(	"id"=>$this->getId(),
								"name"=>$this->getName(), 
								"class"=>$this->getClass(), 
								"style"=>$this->getStyle()
							);

		$sTag = parent::fillTagAttributes("div", $aAttributes);
		
		$sTag .= $this->getContent();
		$sTag .= "</div>";
		
		return $sTag;
	}
}
 
 
 
?>