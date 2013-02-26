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

try{
	
	// Define the needed object: Page, Head and Body
	//
	$oHp = new Sylar_HtmlPage();
	$oHd = new Sylar_HtmlHead();
	$oHb = new Sylar_HtmlBody();
	
	// In the head set Page title
	$oHd->setPageTitle("Sylar Formatting Page Example!");
	
	// In the head add some Meta tag
	$oHd->addMetaTag("text/html; charset=utf-8", null, "content-type");
	$oHd->addMetaTag("width=1024", "viewport");
	$oHd->addMetaTag("Brdp 4 Sylar", "Author");
	
	// in the head import some Js files...
	$oHd->addSylarJavascript("test.js");
	
	// in the head import CSS stylesheet files 
	$oHd->addSylarStyle("test.css");
	
	// We can add in header also floating style in css
	$style = "
	#billboard { width: 981px; margin: 0 auto; overflow: hidden; position: relative; }
	#autoboard { width: 981px; margin: 0 auto; }
";
	$oHd->addFloatingStyle($style);
	
	// And also Javascript Floating code
	$script = "
	alert('Floating Script OK!');
	var fr = \"fr\";
	// etc etc ...
";
	$oHd->addFloatingJsScript($script);
	
	// THE HEADER IS OK! Now prepare the Body
	
	
	// Add some DIV in The body with different tag and different tag collections
	$oDiv = new Sylar_HtmlDiv();
	$oDiv->setContent("DIV..... 1");
	$oHb->addDiv($oDiv);
	
	$oDiv = new Sylar_HtmlDiv("My_ID");
	$oDiv->setContent("DIV..... 2");
	$oHb->addDiv($oDiv);
	
	$oDiv = new Sylar_HtmlDiv(null, "My_Name");
	$oDiv->setContent("DIV..... 3");
	$oHb->addDiv($oDiv);
	
	$oDiv = new Sylar_HtmlDiv(null, null, "My_Classe_CSS");
	$oDiv->setContent("DIV..... 4");
	$oHb->addDiv($oDiv);
	
	$oDiv = new Sylar_HtmlDiv(null, null, null, "My_Style");
	$oDiv->setContent("DIV..... 5");
	$oHb->addDiv($oDiv);
	
	// An example with all attributes
	$oDiv = new Sylar_HtmlDiv("My_ID", "My_Name", "My_Class", "My_Style");
	$oDiv->setContent("DIV..... 6");
	$oHb->addDiv($oDiv);
	
	// An example of nested div
	$oDiv_1 = new Sylar_HtmlDiv();
	$oDiv_1->setContent("Nested DIV.....1");
	
	$oDiv_2 = new Sylar_HtmlDiv();
	$oDiv_2->setContent("Nested DIV.....2");
	$oDiv_2->nestDiv($oDiv_1);

	$oDiv_3 = new Sylar_HtmlDiv();
	$oDiv_3->setContent("Nested DIV.....3");	
	$oDiv_3->nestDiv($oDiv_2);
	
	$oHb->addDiv($oDiv_3);
	
	
	
	// An example with all attributes
	$oDiv = new Sylar_HtmlDiv("ALERT");
	$msg = "<br>Remember! This is an example! Remember that you must always separe the presentation from the logic!";
	$msg .= "<br><br><a href='08.php'> Presentation and Logic &raquo;</a>";
	$oDiv->setContent($msg);
	$oHb->addDiv($oDiv);
	
	
	// also the BODY IS OK! NOW PUSH  ALL IN THE PAGE.
	
	// Add head and body in the page
	$oHp->setPageHead($oHd);
	$oHp->setPageBody($oHb);
	
	// Then Render the HTML Page.
	$oHp->show();

} catch (ExceptionInSylar $ex){
	echo $ex->getMessage();	
}


//Load in your browser and look at the source!

?>		

