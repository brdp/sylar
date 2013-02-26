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


import('giano.presentation.Format');


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
 
class App_ExampleFormat extends App_Format{
	
	function __construct(Sylar_LocaleConfiguration $localeConf=null){
		parent::__construct($localeConf);
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
	
	
	public function makeLoginPage(){
		try{
			// Prepare Head and Body
			$oHH = parent::provideStandardHtmlHead("Giano Login Page");
			$oHB = new Sylar_HtmlBody();
			
			// Controls if user is Loggedin or not
			$engine = new App_LoginEngine();
			if($engine->isUserLogged()){
				// Prepare and push in Body the Logged Version
				$oHB->addDiv($this->makeLoggedInWidget());
				
				// Then Logout
				$engine->performDummyLogout();
				
			}else{				
				// Prepare and push in Body the NOT Logged Version
				$oHB->addDiv($this->makeLoggedOffWidget());
				
				// Then Login
				$engine->performDummyLogin();
			}
			
			//
			// If you want you can Add Other Content and other CSS and JS etc... in the page
			//
			
			// Then Return the page Object
			$oHP = new Sylar_HtmlPage();
			
			$oHP->setPageHead($oHH);
			$oHP->setPageBody($oHB);
			
			// Return the page
			return $oHP;
			
		} catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	
	

	
}
 
 
?>