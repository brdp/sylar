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
import('sylar.presentation.html.HtmlDiv');

 
/**
 * Html Body Element
 * 
 * This object containes DIV object that will compose the Html page.
 * Css and Style will care about layout
 * 
 * @package Sylar
 * @version 1.0
 * @since 31/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_HtmlBody extends Sylar_Html{
	// An array of Sylar_Html Derivated Objects
	private $aHtmlObjectArchive;
	
	function __construct(){
		// Inizialize the array
		$this->aHtmlObjectArchive = array();
	}
	function __destruct(){
		// nothing to do at the moment
	}


	
	
	
	
	//								 						   Setter and Getter
	//__________________________________________________________________________
		

	public function setOnLoad($sAttribute){
		$this->setAttribute("onload", $sAttribute);
	}
	public function getOnLoad(){
		return $this->getAttribute("onload");
	}	
	
	public function setOnUnload($sAttribute){
		$this->setAttribute("onunload", $sAttribute);
	}
	public function getOnUnload(){
		return $this->getAttribute("onunload");
	}		
	
	
	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
		
	
	/**
	 * Add a Div to Body
	 * 
	 * @see Sylar_HtmlDiv
	 * 
	 * @deprecated 
	 * @see new push methods example pushDiv etc...
	 * 
	 * @return void
	 * @param Sylar_HtmlDiv $oDiv the object with Div information and content
	 */
	public function addDiv(Sylar_HtmlDiv $oDiv){
		if($oDiv != null){
			$this->aHtmlObjectArchive[] = $oDiv;
		}
	}
	
	
	/**
	 * Append a Div to the list of objects in Body
	 * 
	 * @see Sylar_HtmlDiv
	 * 
	 * @return void
	 * @param Sylar_HtmlDiv $oDiv the object with Div information and content
	 */
	public function pushDiv(Sylar_HtmlDiv $oDiv){
		if($oDiv != null){
			$this->aHtmlObjectArchive[] = $oDiv;
			
			// merge the required js and css files
			$this->mergeRequiredAppCssFiles($oDiv->getRequiredAppCssFiles());
			$this->mergeRequiredAppJsFiles($oDiv->getRequiredAppJsFiles());
			$this->mergeRequiredSylarCssFiles($oDiv->getRequiredSylarCssFiles());
			$this->mergeRequiredSylarJsFiles($oDiv->getRequiredSylarJsFiles());
		
		}
	}	
	
	
	
	/**
	 * Append a HtmlSnippet to the list of objects in Body
	 * 
	 * @see Sylar_HtmlSnippet
	 * 
	 * @return void
	 * @param Sylar_HtmlDiv $oDiv the object with Div information and content
	 */
	public function pushHtml(Sylar_HtmlSnippet  $oHtml){
		if($oHtml != null){
			$this->aHtmlObjectArchive[] = $oHtml;
			
			// merge the required js and css files
			$this->mergeRequiredAppCssFiles($oHtml->getRequiredAppCssFiles());
			$this->mergeRequiredAppJsFiles($oHtml->getRequiredAppJsFiles());
			$this->mergeRequiredSylarCssFiles($oHtml->getRequiredSylarCssFiles());
			$this->mergeRequiredSylarJsFiles($oHtml->getRequiredSylarJsFiles());
		
		}
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
	 * Design Html BODY tag
	 * it push all div in the body and prepare html code
	 * 
	 * @return string
	 */
	protected function render(){
		$sTagHtml = "\n".parent::provideTagWithAttributes("body")."\n";
		
			// Floating Style in the page <style> #classname: etc... </style>
			foreach ($this->aHtmlObjectArchive as $val) {
				$sTagHtml .= "\n\t".$val->getHtmlSource();
			}
		
		$sTagHtml .= "\n</body>";
		
		return $sTagHtml;
	}	
}
 
 
 
?>