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
 
// Controls that the file is always included. Classes Must be included!
if( count(get_included_files())<=1 ){ echo "Wrong Call. Sylar Exit!"; exit; }
// Don't remove!

import('sylar.common.system.Logger');
import('sylar.common.system.ConfigBox');	

/**
 * Cookie
 * 
 * Class to use cookie
 * 
 * @package Sylar
 * @version 1.0
 * @since 18/apr/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_Cookie{
	
	/** 
	 * web server path where the cookie is valid
	 * @var string 
	 */
	private $sPathOnServer;
	
	/** 
	 * Eventually prefix for cookie name 
	 * @var string
	 */
	private $sKeyPrefix;
	
	/** 
	 * expiration time for cookie
	 * @var int 
	 */
	private $iExpireTime;
	
	/** 
	 * Domain for example .giano-solutions.com
	 * @var string 
	 */
	private $sDomain;
	
	/**
	 * Class constructor
	 *
	 * @return void
	 * 
	 * @param string $domain
	 * @param string $directory
	 * @param string $keyPrefix
	 */
	function __construct($domain=null, $directory=null, $keyPrefix=null){
		
		// set eventually Key Prefix
		if(!is_null($keyPrefix))
			$this->setKeyPrefix($keyPrefix);
			
		// set an eventually directory
		if(!is_null($directory))
			$this->setPathOnServer($directory);	
			
		// set an eventually domain
		if(!is_null($domain))
			$this->setDomain($domain);
			
	}

	
	function __destruct() {
		# nothing to do
	}

	
	
	
	
	
	//								 				   Getter and Setter Methods
	//__________________________________________________________________________		
	
	
	/**
	 * @param string $sPathOnServer
	 * @return void
	 */	
	public function setPathOnServer($sPathOnServer){
		$this->sPathOnServer = $sPathOnServer;
	}
	
	/**
	 * @return string
	 */
	public function getPathOnServer(){
		return $this->sPathOnServer;
	} 
	
	
	/**
	 * @param string $sKeyPrefix
	 * @return void
	 */
	public function setKeyPrefix($sKeyPrefix){
		$this->sKeyPrefix = $sKeyPrefix;
	}
	
	/**
	 * @return string
	 */
	public function getKeyPrefix(){
		return $this->sKeyPrefix;
	}

	
	/**
	 * @param int $iExpireTime
	 * @return void
	 */
	public function setExpireTime($iExpireTime){
		$this->iExpireTime = $iExpireTime;
	}
	
	/**
	 * @return int
	 */
	public function getExpireTime(){
		return $this->iExpireTime;
	}

	
	/**
	 * @param string $sDomain
	 * @return void
	 */
	public function setDomain($sDomain){
		$this->sDomain = $sDomain;
	}
	
	/**
	 * @return string
	 */
	public function getDomain(){
		return $this->sDomain;
	}	
	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________	
		
	
	/**
	 * Set and create cookie
	 * It set cookie with all parameters managed by this object.
	 *
	 * @param string $sKey
	 * @param mixed $values
	 * @param int $expireTime
	 * @param boolean $fIngorePrefix if true ignore eventually key prefix
	 * @return boolean
	 */
	// bool setcookie  ( string $name  [, string $value  [, int $expire  [, string $path  [, string $domain  [, bool $secure  [, bool $httponly  ]]]]]] )
	public function set($sKey, $values, $expireTime=null, $fIngorePrefix=false){
		
		try{				
			if( setcookie ($this->prepareKey($sKey, $fIngorePrefix), $values, $this->prepareExpireTime($expireTime), $this->getPathOnServer(), $this->getDomain()) ){
				return true;
			}else{
				throw new ExceptionInSylar("Error! Cookie not set", 10013 );				
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Get cookie value
	 * It returns the value of specified cookie
	 *
	 * @param string $sKey
	 * @param boolean $fIngorePrefix if true ignore eventually key prefix
	 * @return mixed
	 */
	public function get($sKey, $fIngorePrefix=false){
		if(array_key_exists($this->prepareKey($sKey, $fIngorePrefix), $_COOKIE) ){
			return $_COOKIE[$this->prepareKey($sKey, $fIngorePrefix)];
		}else{
			return null;
		}
	}
	
	
	/**
	 * Check if cookie exists
	 * return true if the cookie exists, false otherwise
	 *
	 * @param string $sKey
	 * @param boolean $fIngorePrefix if true ignore eventually key prefix
	 * @return boolean
	 */
	public function exists($sKey, $fIngorePrefix=false){
		if(array_key_exists($this->prepareKey($sKey, $fIngorePrefix), $_COOKIE) ){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 * Delete specified cookie
	 *
	 * @return void
	 * @param string $sKey
	 * @param boolean $fIngorePrefix if true ignore eventually key prefix
	 */
	public function delete($sKey, $fIngorePrefix=false){
		$this->set($sKey, "", -1, $fIngorePrefix);
	}
	
	
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________	

	
	/**
	 * Control and prepare the key of cookie
	 * it also manage key name prefix
	 *
	 * @param string $sKey
	 * @param boolean $fIngorePrefix if true ignore eventually key prefix
	 * @return string
	 */
	private function prepareKey($sKey, $fIngorePrefix=false){
		if(!$fIngorePrefix && !is_null($this->getKeyPrefix()) ){
			return $this->getKeyPrefix().$sKey;
		}else{
			return $sKey;
		}
	}
	
	
	/**
	 * Return expire time
	 * it also manage default expiration time
	 *
	 * @param int $expireTime
	 * @return int
	 */
	private function prepareExpireTime($expireTime){
		if(!is_null($expireTime)){
			return $expireTime;
		}else{
			if(!is_null($this->getExpireTime())){
				return $this->getExpireTime();
			}else{
				// Return 0 as default that corresponds to magic cookie
				return 0;
			}
		}
	}
	
	
} 
 
 
 
?>