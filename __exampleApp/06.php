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
	$oHd->setPageTitle("Sylar Ajax Table List");
	
	// In the head add some Meta tag
	$oHd->addMetaTag("text/html; charset=utf-8", null, "content-type");
	$oHd->addMetaTag("width=1024", "viewport");
	$oHd->addMetaTag("Brdp 4 Sylar", "Author");
	
	
	// in the head import some Js files...
	$oHd->addSylarJavascript("sylar.js");
	$oHd->addSylarJavascript("ajax.js");
	$oHd->addSylarJavascript("TableList.js");
	
	// in the head import CSS stylesheet files 
	$oHd->addSylarStyle("TableList.css");
	
	
	// And also Javascript Floating code
	$script = "
			
			sylar_InitTableList('TBL1', 'ListDiv1', '../do/do_TableList.php?tln=TBL1');
			sylar_InitTableList('TBL2', 'ListDiv2', '../do/do_TableList.php?tln=TBL2');

	";
	$oHd->addFloatingJsScript($script);
	
	
	// THE HEADER IS OK! Now prepare the Body
	

	// An example with all attributes
	$oDiv = new Sylar_HtmlDiv("ALERT");
	$msg = "<br>Remember! This is an example! Remember that you must always separe the presentation from the logic!";
	$msg .= "<a href='07.php'> Formatting &raquo;</a><br><br> ";
	$oDiv->setContent($msg);
	$oHb->addDiv($oDiv);
	
	
	
	// Add some DIV in The body with different tag and different tag collections
	$oDiv = new Sylar_HtmlDiv("ListDivControl");
	$oDiv->setContent("<br><input type='button' value='First List' onclick='javascript:sylar_ReloadTableList(\"TBL1\");'> <input type='button' value='Second List' onclick='javascript:sylar_ReloadTableList(\"TBL2\");'><br><br>");
	$oHb->addDiv($oDiv);
	
	
	// Add some DIV in The body with different tag and different tag collections
	$oDiv = new Sylar_HtmlDiv("ListDiv1");
	$oDiv->setContent("<br><br>Lista 1");
	$oHb->addDiv($oDiv);

	
	// Add some DIV in The body with different tag and different tag collections
	$oDiv = new Sylar_HtmlDiv("ListDiv2");
	$oDiv->setContent("<br><br>Lista 2");
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

