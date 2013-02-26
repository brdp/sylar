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

import('sylar.common.security.Cookie');
import('sylar.presentation.html.HtmlPage');


try{
	$txt = "";
	
	// Cookie Test object
	$ck = new Sylar_Cookie();
	
	// Set a magic cookie that persist until the end of browser session
	$cookieKey = "Sylar_TEST_1";
	if($ck->exists($cookieKey)){
		$txt .= "<br><br><i>Magic Cookie exists</i>: <b>".$ck->get($cookieKey)."</b>";
	}else{
		$ck->set($cookieKey, rand(1, 9999999));
		$txt .= "<br><br><i>Magic Cookie does not exists. Created! </i> <b>".$ck->get($cookieKey)."</b>";
	}
	
	
	// Set a prefix for cookie name
	$ck->setKeyPrefix("Sylar___");
	
	// Set cookie that persist for 30 seconds
	$cookieKey = "TEST_2"; 
	if($ck->exists($cookieKey)){
		$txt .= "<br><br><i>Cookie exists with prefix Sylar___ and persists for 30 seconds then reload the page! Value</i>: <b>".$ck->get($cookieKey)."</b>";
	}else{
		$ck->set($cookieKey, rand(1, 9999999), time()+30);
		$txt .= "<br><br><i>Cookie does not exists. Created! </i> <b>".$ck->get($cookieKey)."</b>";
	}
	
	// Set a path on the server, the prefix is still set
	$ck->setPathOnServer("/");
	
	// Set a cookie that persist for 50 seconds in page contained in path /
	$cookieKey = "TEST_3";
	if($ck->exists($cookieKey)){
		$txt .= "<br><br><i>Cookie exists on server from path /  with prefix Sylar___ and it persists for 50 seconds then reload the page! Value</i>: <b>".$ck->get($cookieKey)."</b>";
	}else{
		$ck->set($cookieKey, rand(1, 9999999), time()+50);
		$txt .= "<br><br><i>Cookie does not exists. Created! </i> <b>".$ck->get($cookieKey)."</b>";
	}	
	
	// Set and remove a cookie
	$cookieKey = "TEST_4_TO_REMOVE";
	if($ck->exists($cookieKey)){
		$txt .= "<br><br><i>Cookie exists on server</i>: <b>".$ck->get($cookieKey)."</b> Now will be removed.";
		$ck->delete($cookieKey);
	}else{
		$ck->set($cookieKey, rand(1, 9999999));
		$txt .= "<br><br><i>Cookie does not exists. Created! </i> <b>".$ck->get($cookieKey)."</b>";
	}	

	
	
	// Show all cookies name and values
	$txt .= "<br><hr><br>";
	foreach ($_COOKIE as $k => $v) {
		$txt .= "<br>".$k." = ".$v;
	}
	
	
	// Link to next example page
	$txt .= "<br><br><br><br><a href='11.php'>Mail sender example &raquo;</a>";
	
	
	
	
	
	// Prepare Head and Body
	$oHH = new Sylar_HtmlHead("Giano Cookie Test page");		
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

