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
 


import('sylar.common.db.DataBaseManager');




/**
 * Db Configuration
 * This class contains all informtation needed to connect to the database.
 * It's also used from DataBaseDriver to connect to Db.
 * 
 * @package Sylar
 * @version 1.0
 * @since 27/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 * 
 * @see Sylar_DataBaseDriver
 */
 class Sylar_DataBaseConfiguration{
 	private $sName;
 	private $sDriver;			// the same of Sylar_DataBaseManager
	private $sDescription;
	private $sCharSet;

	private $sHost;
	private $sSchema;
	private $sUsername;
	private $sPassword;
	
	function __construct($sName, $aConfig=null){
		$this->setName($sName);	
		
		if($aConfig){
			$this->fillConfigFromArray($aConfig);
		}
	}

	function __destruct() {
		# nothing to do
	}
	
	
	// Setter and Getter 
	
	public function setName($sName){
		$this->sName = $sName;
	}
 	public function setDriver($sDriver){
		$this->sDriver = $sDriver;
	}
	public function setDescription($sDescription){
		$this->sDescription = $sDescription;
	}
	public function setCharSet($sCS){
		$this->sCharSet = $sCS;
	}
 	public function setHost($sHost){
		$this->sHost = $sHost;
	}
 	public function setSchema($sSchema){
		$this->sSchema = $sSchema;
	}
 	public function setUsername($sUsername){
		$this->sUsername = $sUsername;
	}
 	public function setPassword($sPassword){
		$this->sPassword = $sPassword;
	}
	
	
	
	public function getName(){
		return $this->sName;
	}
 	public function getDriver(){
		return $this->sDriver;
	}
	public function getDescription(){
		return $this->sDescription;
	}
 	public function getCharSet(){
		return $this->sCharSet;
	}
  	public function getHost(){
		return $this->sHost;
	}
 	public function getSchema(){
		return $this->sSchema;
	}
 	public function getUsername(){
		return $this->sUsername;
	}
 	public function getPassword(){
		return $this->sPassword;
	}
	
	
	/**
	 * Fill configuration
	 * It fill all configuration data from an array with this field:
	 * 		host
	 * 		schema
	 * 		username
	 *		password
	 * 
	 * @return void
	 * @param array $aConfig
	 */
	public function fillConfigFromArray($aConfig){
		$this->setHost($aConfig["host"]); 
		$this->setSchema($aConfig["schema"]); 
		$this->setUsername($aConfig["username"]); 
		$this->setPassword($aConfig["password"]); 
		$this->setDriver($aConfig["driver"]);
		$this->setCharSet($aConfig["charset"]);
		
		// in the future manage the other information like SID in Oracle ecc... 
		// these informations depends on Driver Value
	}
	
	
	/**
	 * Check the Db Configuration
	 * It controls if the configuration is consistent.
	 * It doesn't test the connection, it only check the params.
	 *
	 * @return boolean
	 */
	public function checkConfiguration(){
		
		try{
			if(!$this->getHost() || strlen($this->getHost())==0 ){
				throw new ExceptionInSylar("Db Host undefined or empty", 1 );
			}
			if(!$this->getSchema() || strlen($this->getSchema())==0 ){
				throw new ExceptionInSylar("Db Schema undefined or empty", 1 );
			}
			if(!$this->getUsername() || strlen($this->getUsername())==0 ){
				throw new ExceptionInSylar("Db Username undefined or empty", 1 );
			}
			if(!$this->getPassword()){
				throw new ExceptionInSylar("Db Password Undefined", 1 );
			}
			if(!$this->getDriver() || strlen($this->getDriver()) ==0 ){
				throw new ExceptionInSylar("No Driver DB Defined", 1 );
			}
			
			// Verify if the driver exists in the framework
			//
			$dbManager = new Sylar_DataBaseManager(); 
			
			if( !$dbManager->driverIsInstalled($this->getDriver()) ){
				throw new ExceptionInSylar("Request Db Driver Not Installed in Sylar", 1 );
			}
		
			return true;
		
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
 }
 
 
 
 
?>