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

import('sylar.presentation.html.HtmlPage');
import('sylar.presentation.html.components.Form');

import('sylar.presentation.html.components.FormInputText');
import('sylar.presentation.html.components.FormInputPassword');
import('sylar.presentation.html.components.FormInputHidden');
import('sylar.presentation.html.components.FormInputFile');
import('sylar.presentation.html.components.FormInputButton');
import('sylar.presentation.html.components.FormInputCheckbox');
import('sylar.presentation.html.components.FormInputRadio');
import('sylar.presentation.html.components.FormSelect');
import('sylar.presentation.html.components.FormTextarea');

import('sylar.presentation.html.components.FormInputReset');
import('sylar.presentation.html.components.FormInputSubmit');



try{
	$txt = "";
	
	$txt .= "<br> Some Simple Html Form Components example:";
	
	$txt .= "<br><br>";	
	
	
	$txt .= "<fieldset>
				<legend>Simple sample form</legend>";	
	
	
			// TEXT TAG
			$oForm = new Sylar_FormInputText("Test_1", "A", "TestValue_1");
			$oForm->setSize("30");
			$oForm->setMaxLen("10");
			$oForm->setClass("title");
			$oForm->setAttribute("onchange", "javascript:alert('changed');");
			
			//$oForm->removeAttribute("onclick");
			//$oForm->setReadOnly(true);
			
			$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();
		
			$txt .= "<br>";	
			

			// TEXT TAG
			$oForm = new Sylar_FormInputText("Test_1_1", "AA", "TestValue_1_1");
			$oForm->setSize("30");
			$oForm->setMaxLen("10");
			$oForm->setClass("text");
			
			//$oForm->removeAttribute("onclick");
			//$oForm->setReadOnly(true);
			
			$txt .= "\n<br><label for=\"Test_1_1\">{$oForm->getId()}</label><br>".$oForm->getHtmlSource();
		
			$txt .= "<br>";				
			
			
			// PASSWORD TAG
			$oForm = new Sylar_FormInputPassword("Test_2", "B", "TestValue_3");
			$oForm->setSize("30");
			$oForm->setMaxLen("5");
			$oForm->setClass("text");
			$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();				
	
	$txt .= "</fieldset>";
	
	$txt .= "<br>";	
	
	// HIDDEN TAG
	$oForm = new Sylar_FormInputHidden("Test_3", "C", "TestValue_3");
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();

	$txt .= "<br>";	
	
	// BUTTON
	$oForm = new Sylar_FormInputButton("Test_4", "D", "TestValue_4", "alert('Hello!')");	
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();

	$txt .= "<br>";	
	
	// CHECKBOX
	$oForm = new Sylar_FormInputCheckbox("Test_5", "E", "TestValue_5");	
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();
	$oForm = new Sylar_FormInputCheckbox("Test_6", "F", "TestValue_6", true);	
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();
	
	$txt .= "<br>";
		
	// RADIO
	$oForm = new Sylar_FormInputRadio("Test_7", "G", "TestValue_77");	
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();
	$oForm = new Sylar_FormInputRadio("Test_7", "G", "TestValue_78", true);	
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();
	
	$txt .= "<br>";
	
	// SELECT two example
	$oForm = new Sylar_FormSelect("Test_8", "F", "3", true);	
	$oForm->addOptionInSelect("UNO", "1");
	$oForm->addOptionInSelect("DUE", "2", true);
	$oForm->addOptionInSelect("TRE", "3");
	$oForm->setDisabled(true);
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();
	
	$txt .= "<br>";
	
	$oForm = new Sylar_FormSelect("Test_9", "G");	
	$oForm->addOptionsInSelectFromArray( array("A"=>"Letter A", "B"=>"Letter B", "C"=>"Letter C", "D"=>"Letter D", "E"=>"Letter E"), "C" );
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();

	
	// TEXTAREA
	$txt .= "<br>";

	$txtTextareaContent = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";
	
	$oForm = new Sylar_FormTextarea("Test_10", "H", $txtTextareaContent, "7", "40");	
	$oForm->setReadOnly(true);
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();
	
	
	// FILE Upload
	$txt .= "<br>";
	
	$oForm = new Sylar_FormInputFile("Test_11", "I", "40");
	$txt .= "\n<br>{$oForm->getId()} = ".$oForm->getHtmlSource();
	
	
	
	
	
	
	
	
	
	$txt .= "<br><br><hr><br>";
	
	// RESET
	$oForm = new Sylar_FormInputReset("Test_Reset", "Reset!", "alert('Reset!')");	
	$txt .= "\n{$oForm->getId()} = ".$oForm->getHtmlSource();	
	
	$txt .= "&nbsp;&nbsp;&nbsp;&nbsp;";
	
	// SUBMIT
	$oForm = new Sylar_FormInputSubmit("Test_Submit", "Submit!", "alert('Submit!')");	
	$txt .= "\n{$oForm->getId()} = ".$oForm->getHtmlSource();
	

	
	
	// NOW PUT all components in the HTML FORM!
	$oForm = new Sylar_Form("FormSylar", "Sylar_FormTest");	
	$oForm->addHtmlContent($txt, true);
	
	$txt = $oForm->getHtmlSource();	
	
	
	
	
	
	
	// Link to next example page
	$txt .= "\n\n<br><br><br><br><a href='13.php'>Next &raquo;</a>";
	
	// Prepare Head and Body
	$oHH = new Sylar_HtmlHead("Giano Form Test page");		
		$oHH->addMetaTag("text/html; charset=".APP_DEFAULT_CHARSET, null, "content-type");
		$oHH->addSylarStyle("Forms.css");

		
	// prepare Body	
	$oHB = new Sylar_HtmlBody();
	$oHB->setAttribute("style", "background: #FFFFDE;");

	
	// Create a DIV
	$div = new Sylar_HtmlDiv("test");
	
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

