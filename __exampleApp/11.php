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

import('sylar.common.communication.Mail');
import('sylar.presentation.html.HtmlPage');


try{
	$txt = "";

	// New mail in HTML
	$ml = new Sylar_Mail("html", "sender@sylarexample.org");	
	
	// List of Recipients
	$ml->setSend_To( array("Mike"=>"Recipient_1@sylarexample.org", "John"=>"Recipient_2@sylarexample.org") );

	// List of Cc Recipients
	$ml->setSend_CC( array("Mike"=>"Recipient_CC_1@sylarexample.org") );

	// List of Bcc Recipients
	$ml->setSend_BCC( array("Mike"=>"Recipient_BCC_1@sylarexample.org", "John"=>"Recipient_BCC_2@sylarexample.org") );

	// email HTML Body
	$mailBody = 	"<html><body>".
					"<i>Hello</i> this is my first <b>mail</b> with sylar Framework".
					"<br><br><hr><br><br>".
					"<table border='2'><tr><td>Cell 1</td><td>Cell 2</td></tr></table>".
					"</body></html>";

	$mailObject = "My first HTML Mail with Sylar";
	
	// uncomment when email address in the lists are real
	//
	// $ml->send($mailObject, $mailBody, APP_DEFAULT_CHARSET);
	
	
	// test to validate email address method. Modify the address to test the method
	$email = "m.green@sylarexample.org";
	
	if($ml->validateAddress($email)){
		$txt .= "<br><br>{$email} is OK!";	
	}else{
		$txt .= "<br><br>{$email} is NOT a valid email address!";
	}
	
	// Link to next example page
	$txt .= "<br><br><br><br><a href='12.php'>Form example &raquo;</a>";
	
	
	
	
	
	// Prepare Head and Body
	$oHH = new Sylar_HtmlHead("Giano Email Test");		
		$oHH->addMetaTag("text/html; charset=".APP_DEFAULT_CHARSET, null, "content-type");

		
	// prepare Body	
	$oHB = new Sylar_HtmlBody();

	
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

