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
 

import('sylar.common.security.Session');


/**
 * Tit File
 * 
 * Desc File
 * 
 * @package Sylar
 * @version 1.0
 * @since 03/apr/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class App_LoginEngine{
	
	function __construct(){
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________	
	
	
	public function isUserLogged(){
		$session = new Sylar_Session();
		if($session->isUserLogged()){
			return true;
		}
		return false;
	}
	
	public function extractUserInfo(){
		$session = new Sylar_Session();
		if($session->isUserLogged()){
			return $session->getSessionParam("name")." ".$session->getSessionParam("surname");
		}
		return null;
	}
	
	public function performDummyLogin(){
		$session = new Sylar_Session();
		$session->login("brdp", "brdp");
	}
	
	public function performDummyLogout(){
		$session = new Sylar_Session();
		$session->logout();
	}
	
}
 
?>