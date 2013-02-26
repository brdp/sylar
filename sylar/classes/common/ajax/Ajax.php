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
 
import('sylar.common.system.Logger');
import('sylar.common.system.ConfigBox');


/**
 * Ajax Server Side Class
 * 
 * @package Sylar
 * @version 1.0
 * @since 26/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 class Sylar_Ajax{
 	
 	private $aEnabledUri;
 	private $bReferrerCheckActive;
 	private $sUriReferrer;
 	
 	/**
	 * Constructor
	 *
	 * @return void
	 * @param boolean $bReferrerCheckActive 
	 */
	function __construct(){
		$this->aEnabledUri = array();	
		
		if( is_array($_SERVER) && array_key_exists('HTTP_REFERER', $_SERVER)){
			$this->setReferrerUri($_SERVER['HTTP_REFERER']);
		}		

		// Add server name to enabled list
		$this->addEnabledDomain($_SERVER["SERVER_NAME"]);		
		
	}

	
	function __destruct() {
		# nothing to do
	}
	

	
	
	
	
	//								 				   Getter and Setter Methods
	//__________________________________________________________________________		
	
 	public function setReferrerCheck($bReferrerCheckActive){
		$this->bReferrerCheckActive = $bReferrerCheckActive;
	}

 	public function getReferrerCheck(){
		return $this->bReferrerCheckActive;
	}		
	
	public function setReferrerCheckOn(){
		$this->setReferrerCheck(true);
	}
	
 	public function setReferrerCheckOff(){
		$this->setReferrerCheck(false);
	}	
		
	/**
	 * @return array
	 */
	public function getEnabledUri(){
		return $this->aEnabledUri;
	}
	
	/**
	 *  @return string
	 */
	public function getReferrerUri(){
		return $this->sUriReferrer;
	}
	public function setReferrerUri($sRefUri){
		$this->sUriReferrer = $sRefUri;
	}	
	
	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________	
	
	
	/**
	 * Controls if a domain is enabled to call ajax server pages
	 *
	 * @return boolean
	 */
	public function checkDomain(){
		if(in_array( $this->getDomainFromUri(), $this->getEnabledUri() )){
			return true;
		}
		return false;
	}
	
	
	/**
	 * Add a domain in enabled domain list
	 *
	 * @param string $sDomain
	 */
 	public function addEnabledDomain($sDomain){
		$this->aEnabledUri[] = $sDomain;
	}
	
	
	/**
	 * it stop execution if referrer is not enabled
	 *
	 * @return void
	 */
 	public function validateReferrer(){
		if(!$this->checkDomain()){
			$log = new Sylar_Logger();
			$log->logEvent( "Not valid Ajax Call! Referrer not enabled: ".$this->getReferrerUri(), "FATAL");
			exit;
		}
	}
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________	
	
	
	/**
	 * @todo to be done
	 *
	 * @return string
	 */
	private function getDomainFromUri(){
		$sAppo = $this->getReferrerUri();
		if(is_null($sAppo)){
			return null;
		}
		$aAppo = split("//",$sAppo);
		
		$aAppo = split("/",$aAppo[1]);
		$aAppo = split(":",$aAppo[0]);
		
		return $aAppo[0];
		
		//return $this->getReferrerUri();
	}
	
 	
 }
 
 
 
?>