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

import('sylar.presentation.html.HtmlSnippet');
import('gs.presentation.Format');
import('gs.presentation.datafields.InputEmail');




try{
	
	$frmt = new GS_Format();
	$html = new Sylar_HtmlSnippet();
	
	
	
	$a = array("a"=>"1", "b"=>"2", "c"=>"3",);
	$b = array("b"=>"4", "c"=>"5", "d"=>"6",);
	
	echo "<br>";
	print_r($a);
	echo "<br>";
	print_r($b);
	
	$x = array_merge($a, $b);
	echo "<br>";
	print_r($x);
	
	$y = array_merge($b, $a);
	echo "<br>";
	print_r($y);
	
	
	// Link to next example page
	$html->pushString( "\n\n<br><br><br><br><a href='14.php'>Next &raquo;</a>", true);
	

	$f = new GS_InputEmail("emailF", "e-mail");
	$txt .= "<br><br>".$f->getField()->getHtmlSource();	
	
	
	
	// Prepare Head and Body
	$oHH = $frmt->provideStandardHtmlHead("Giano Form Test page");		
		$oHH->addApplicationJavascript("GS_DataField.js");
		$oHH->addApplicationStyle("GS_DataField.css");
		
	// prepare Body	
	$oHB = new Sylar_HtmlBody();

	
	// Create a DIV
	$div = new Sylar_HtmlDiv("test");
	$div->setStyle("width:600px;");
	
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

