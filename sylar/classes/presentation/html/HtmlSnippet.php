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
 * Html Code Snippet
 * 
 * Manage a portion of Html code with all required things like CSS, JS, ecc...
 * 
 * @package Sylar
 * @version 1.0
 * @since 7/aug/09
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_HtmlSnippet extends Sylar_Html{
	
	/* Html Code Snippet String */
	private $sHtmlCode = "";
	
	
	/**
	 * Constructor
	 */
	function __construct($sHtmlCode=null){
		
		parent::__construct();
		
		if(!is_null($sHtmlCode)){
			$this->setHtmlCode($sHtmlCode);
		}
		
	}
	
	function __destruct(){
		// nothing to do at the moment
	}
		
	//								 						   Setter and Getter
	//__________________________________________________________________________
	

	/**
	 * @return string
	 */
	public function getHtmlCode() {
		return $this->sHtmlCode;
	}
	
	/**
	 * @param string $sHtmlCode
	 */
	public function setHtmlCode($sHtmlCode) {
		$this->sHtmlCode = $sHtmlCode;
	}


	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
	
	
	/**
	 * Append simple Html code to Snippet
	 *
	 * @return void
	 * 
	 * @param string $sHtmlCode text to append
	 * @param boolean $bNewLine 
	 */
	public function pushString($sHtmlCode, $bNewLine=false){
		$newLine = "";
		if($bNewLine){ $newLine = "\n";}
		
		$this->setHtmlCode($this->getHtmlCode().$newLine.$sHtmlCode);
	}
	
	/**
	 * Append simple Html code to the end of the Snippet
	 *
	 * @return void
	 * 
	 * @param Sylar_HtmlDiv $oDiv Div to insert
	 * @param boolean $bNewLine 
	 */
	public function pushDiv(Sylar_HtmlDiv $oDiv, $bNewLine=false){
		$newLine = "";
		if($bNewLine){ $newLine = "\n";}
		
		// merge the required js and css files
		$this->mergeRequiredAppCssFiles($oDiv->getRequiredAppCssFiles());
		$this->mergeRequiredAppJsFiles($oDiv->getRequiredAppJsFiles());
		$this->mergeRequiredSylarCssFiles($oDiv->getRequiredSylarCssFiles());
		$this->mergeRequiredSylarJsFiles($oDiv->getRequiredSylarJsFiles());
		
		$this->setHtmlCode($this->getHtmlCode().$newLine.$oDiv->getHtmlSource());
		
		//TODO IMPORTANT Store the DOM as object not as string!
	}	
	

	
	/**
	 * Append simple Html code to the end of the Snippet
	 *
	 * @return void
	 * 
	 * @param Sylar_HtmlSnippet $sHtmlCode Html object to append
	 * @param boolean $bNewLine 
	 */
	public function pushHtml(Sylar_HtmlSnippet $oHtml, $bNewLine=false){
		$newLine = "";
		if($bNewLine){ $newLine = "\n";}
		
		// merge the required js and css files
		$this->mergeRequiredAppCssFiles($oHtml->getRequiredAppCssFiles());
		$this->mergeRequiredAppJsFiles($oHtml->getRequiredAppJsFiles());
		$this->mergeRequiredSylarCssFiles($oHtml->getRequiredSylarCssFiles());
		$this->mergeRequiredSylarJsFiles($oHtml->getRequiredSylarJsFiles());
		
		$this->setHtmlCode($this->getHtmlCode().$newLine.$oHtml->getHtmlSource());
		
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