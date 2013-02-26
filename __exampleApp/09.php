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

/**
 * Example Sylar File
 * Some files that shows how sylar works
 * 
 * @package Sylar
 * @version 1.0
 * @since 02-2008
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */

#
# Include the bas Application settings
#
require_once '../config/appConfig.php';

import('sylar.common.locale.Language');
import('sylar.presentation.html.HtmlPage');


try{
	
	// Prepare Head and Body
	$oHH = new Sylar_HtmlHead("Giano Locale Test page");		
		$oHH->addMetaTag("text/html; charset=".APP_DEFAULT_CHARSET, null, "content-type");
		$oHH->addMetaTag("Brdp - Giano Solutions", "Author");
		$oHH->addMetaTag("Sylar, Example App", "Keywords");		
		$oHH->addMetaTag("width=1024", "viewport");
		$oHH->addMetaTag("no-cache", null, "pragma");
		
		$oHH->setAppCssUrlRoot(APP_LAYOUT_CSS_URL_ROOT);
		$oHH->addApplicationStyle("mainGiano.css");
		
		$oHH->setAppJsUrlRoot(APP_JAVASCRIPT_URL_ROOT);
		$oHH->addApplicationJavascript("mainGiano.js");

		
		
	// prepare Body	
	$oHB = new Sylar_HtmlBody();
	
	// try to switch locale
	$localeDef->switchToStandardSetting(APP_DEFAULT_LOCALE);
	// Prepare Language engine
	$oLang = new Sylar_Language($localeDef);
	
		// Load two dictionaries from sylar Dict
		$oLang->loadSylarDictionary("Main");
		$oLang->loadSylarDictionary("Example");
		
		// Set Locale Application repository root
		$oLang->setApplicationLocaleRootFs(APP_LOCALE_ROOT_FS);
		
		// Load an example dict file from App repository
		$oLang->loadApplicationDictionary("main");
	
		
		
	// Create a DIV
	$div = new Sylar_HtmlDiv("test");
	
		$txt  = "<br><br><i>Some Correct Test from Sylar Dict</i>: <u>".$oLang->provideText("Sylar_WorkFine")."</u>";
		$txt .= "<br><br><i>Incorrect Test example</i>: <u>".$oLang->provideText("Inexistent_lable_example")."</u>";
		$txt .= "<br><br><i>Some test from second Sylar Dict</i>: <u>".$oLang->provideText("Sylar_WorkFine2")."</u>";
		$txt .= "<br><br><i>Some text from an Application Dict</i>: <u>".$oLang->provideText("App_Desc")."</u>";
		$txt .= "<br><br><i>Dinamic text from an Application Dict with dinamic and multiple replace</i>: <u>".$oLang->provideText("App_Welcome", array(12, "Gianluca Giusti"))."</u>";
		
		$txt .= "<br><br><br><br><a href='10.php'>Cookie example &raquo;</a>";
		
		// add div content
		$div->appendContent($txt);
	
		// append div in the body
		$oHB->addDiv($div);
	
	
	
	// Then Push into the page Object
	$oHP = new Sylar_HtmlPage();
		$oHP->setPageHead($oHH);
		$oHP->setPageBody($oHB);
	
		// render Html Page 
		$oHP->show();	
	

} catch (ExceptionInSylar $ex){
	echo $ex->getMessage();	
}


?>		

