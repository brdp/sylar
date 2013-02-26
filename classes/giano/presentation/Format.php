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
 

import('sylar.presentation.Format');
import('sylar.presentation.html.HtmlPage');
import('sylar.presentation.html.components.FormInputButton');


 
/**
 * Main Format Class for Application
 * 
 * Main Class for formatting output in your Application. 
 * Every classes used to format page and html in your application must extend this class
 * 
 * @package Sylar
 * @version 1.0
 * @since 05/mar/08
 * 
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class App_Format extends Sylar_Format{
	
	function __construct(Sylar_LocaleConfiguration $localeConf=null){
		parent::__construct($localeConf);
	}
	function __destruct(){
		// nothing to do at the moment
	}
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
	
	
	/**
	 * Return Head Tag
	 * 
	 *
	 * @return Sylar_HtmlHead
	 * @param string $sTitle
	 */
	public function provideStandardHtmlHead($sTitle=APP_HTML_TITLE){
		
		try {
			$oHH = new Sylar_HtmlHead($sTitle);	
			
			$oHH->addMetaTag("text/html; charset=".APP_DEFAULT_CHARSET, null, "content-type");
			$oHH->addMetaTag("Brdp - Giano Solutions", "Author");
			$oHH->addMetaTag("Sylar, Example App", "Keywords");		
			$oHH->addMetaTag("width=1024", "viewport");
			$oHH->addMetaTag("no-cache", null, "pragma");
			
			$oHH->setAppCssUrlRoot(APP_LAYOUT_CSS_URL_ROOT);
			$oHH->addApplicationStyle("mainGiano.css");
			
			$oHH->setAppJsUrlRoot(APP_JAVASCRIPT_URL_ROOT);
			$oHH->addApplicationJavascript("mainGiano.js");
			
			return $oHH;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	
	

	
	
	/**
	 * Returns a standard html error page
	 *
	 * @param int $errorCode
	 * @param string $errorMessage Messaggio descrizione errore per errori custom
	 * @param string $errorTitle Titolo per errori custom
	 * @return Sylar_HtmlPage
	 */
	public function provideErrorPage($errorCode, $errorMessage=null, $errorTitle=null){
		
		//$this->loadDictionary("Error");
		
		// Prepare Head and Body
		$oHH = $this->provideStandardHtmlHead($this->translate("sylar_Err_1"));	
		$oHH->addApplicationStyle("Error.css");
		
		
		
		// __________ RIGHT __________ 
	
		$div = new Sylar_HtmlDiv("sylar_div_ErrPage");
      	
		
		$div->nestDiv($this->widgetErrorMessage($errorCode, "sylar_div_ErrWidgt", $errorMessage, $errorTitle));
     

		
      	// prepare Body	
		$oHB = new Sylar_HtmlBody();
		
		
		// Push Div in Body page
		$oHB->addDiv($div);
		
		// Then Push into the page Object
		$oHP = new Sylar_HtmlPage();
			$oHP->setPageHead($oHH);
			$oHP->setPageBody($oHB);
		
			
		// render Html Page 
		return $oHP;		
	}		
	
	

	
	/**
	 * Returns a Div with errore title and message formatted
	 *
	 * @param int $errorCode
	 * @param string $errorMessage
	 * @return Sylar_HtmlDiv
	 */
	public function widgetErrorMessage($errorCode, $divName="sylar_ErrorWidgt", $errorMessage=null, $errorTitle=null){
				
		//$this->loadDictionary("Error");
		
		$inDiv = new Sylar_HtmlDiv($divName);
		
		//
		// For example you ca manage particoular error codes
		//
		switch ($errorCode) {
			case 20023:
				$tit = $this->translate("sylar_Err_20023_tit");
				$msg = $this->translate("sylar_Err_20023_msg");
				break;
			
			default:
				$tit = $this->translate("sylar_Err_GENERIC_tit");
				$msg = $this->translate("sylar_Err_GENERIC_msg");
				break;
		}
		
		//
		//  Or force a particoular message and title
		//
		if(!is_null($errorTitle)) { $tit=$errorTitle; }
		if(!is_null($errorMessage)) { $msg=$errorMessage; }
		
		
		
		$html = "<span class='sylar_Err_Title'>{$tit}</span>".
				"<br/><br/>{$msg}".
				"<br/><br/>[ {$this->translate("sylar_Err_4")} {$errorCode} ]";
		
		
		
		
		$oFormComponent = new Sylar_FormInputButton("nmGoBk", "nmGoBk", $this->translate("sylar_Err_3"));
		$oFormComponent->setOnClick("history.go(-1);");	
		$btn1 = $oFormComponent->getHtmlSource();
		
		$oFormComponent = new Sylar_FormInputButton("nmGo", "nmGo", $this->translate("sylar_Err_2"));
		$oFormComponent->setOnClick("alert('Go Home!');");			
		$btn2 = $oFormComponent->getHtmlSource();
		
		$html .= "<br><br><br>".$btn1." &nbsp;&nbsp;&nbsp;&nbsp; ".$btn2."";
		
		$inDiv->appendContent($html);
	
		
		return $inDiv;
	}		
	
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

}
 
 
?>