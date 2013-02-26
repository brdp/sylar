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
 

import('sylar.presentation.Format');
import('sylar.presentation.html.Html');
import('sylar.presentation.html.HtmlHead');
import('sylar.presentation.html.HtmlBody');


/**
 * Html Page Format
 * 
 * Desc File
 * 
 * @see Sylar_HtmlHead
 * @see Sylar_HtmlBody
 * 
 * @package Sylar
 * @version 1.0
 * @since 31/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_HtmlPage extends Sylar_Html{
	private $oPageHead;
	private $oPageBody;
	
	private $sPage;
	
	function __construct(){
		// nothing to do at the moment
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	//								 						   Setter and Getter
	//__________________________________________________________________________	
	
	
	public function setPageHead(Sylar_HtmlHead $oPgHead){
		$this->oPageHead = $oPgHead;
	}
	public function getPageHead(){
		return $this->oPageHead;
	}
	
	public function setPageBody(Sylar_HtmlBody $oPgBody){
		$this->oPageBody = $oPgBody;
	}
	public function getPageBody(){
		return $this->oPageBody;
	}
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
		

	
	/**
	 * return the Html source
	 * it return html code of entire page
	 * 
	 * @return string
	 */
	public function getHtmlSource(){
		return $this->render();
	}
	
	
	/**
	 * Display the page
	 * it prints the page on screen
	 * 
	 * @return void
	 */
	public function show(){
		echo $this->render();
	}
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
		
	
	/**
	 * Render Html <HTML> tag
	 * it push <body> and <head> tag in the page and prepare the html code of entire web page
	 * 
	 * @return string
	 */
	protected function render(){
		$sTagHtml = "<html>";
		
			if( is_object($this->getPageHead()) ){
				$sTagHtml .= $this->getPageHead()->getHtmlSource();
			}
			
			if( is_object($this->getPageBody()) ){
				$sTagHtml .= $this->getPageBody()->getHtmlSource();
			}
		
		$sTagHtml .= "\n</html>";
		
		return $sTagHtml;
	}	
	
}
 
 
 
?>