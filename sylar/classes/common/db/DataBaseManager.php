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


import('sylar.common.db.DataBaseConfiguration');


/**
 * DataBases manager
 * This class manage all databases supported by Sylar
 * 
 * @package Sylar
 * @version 1.0
 * @since 18/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_DataBaseManager{
	
	/** List of available DB Driver */
	private $aSupportedDbList;

	
	function __construct(){
		$this->fillDbList();
	}
	function __destruct() {
		# nothing to do
	}
	
	
	/**
	 * Check for installed driver
	 * It controls if the request driver is avaiable in Sylar Framework
	 *
	 * @param string $sDriverName the driver name
	 * @return boolean
	 */
	public function driverIsInstalled($sDriverName){
		try{
			if(!is_array($this->aSupportedDbList) || !array_key_exists($sDriverName, $this->aSupportedDbList)){
				throw new ExceptionInSylar("Request DataBase Driver ".$sDriverName." did not exist in Sylar.", 1 );
			}
			return true;
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Return the Db Object 
	 * It return the DataBase Driver Interfaces Type with the right implementation.
	 * The implementation dipends on Driver defined in the Configuration
	 *
	 * @return Sylar_DataBaseDriver
	 * @param Sylar_DataBaseConfiguration $oDbConfig
	 */
	public function driverDispatcher(Sylar_DataBaseConfiguration $oDbConfig){
		try{
			if($oDbConfig->checkConfiguration()){
				
				// DataBase Driver Dinamic Loading 
				//
				switch ($oDbConfig->getDriver()){
										
					case "mysql":
						import("sylar.common.db.mysql.MysqlDriver");
						return new Sylar_MysqlDriver();
					break;
					
					case "oracle":
						import("sylar.common.db.mysql.OracleDriver");
						// TODO Oracle and other Db Driver
					break;
				}
				
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}	
	
	
	
	/**
	 * Get Specified Db Class Path
	 * It return the specified DataBase Driver classpath path for use it in the 
	 * import function. It return something like: 
	 * 		sylar.common.db.mysql
	 * 		sylar.common.db.oracle
	 * It depend on Driver defined in the configuration
	 *
	 * @return string
	 * @param Sylar_DataBaseConfiguration $oDbConfig
	 */
	public function getDriverClassPath(Sylar_DataBaseConfiguration $oDbConfig){
		try{
			if($oDbConfig->checkConfiguration()){
				return "sylar.common.db.".$oDbConfig->getDriver();
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}		
	
	
	
	/**
	 * Default Db Config
	 * It return the object with the default Database configuration, if doesn't exists return null
	 *
	 * @return Sylar_DataBaseConfiguration
	 */
	public static function getDefaultDbConfiguration(){
		
		//
		// Take it from sylar_loader.php
		//
		global $SYLAR_DEFAULT_DB_CONFIG;

		try{
			if($SYLAR_DEFAULT_DB_CONFIG){
				return $SYLAR_DEFAULT_DB_CONFIG;
			}else{
				throw new ExceptionInSylar("No default Db configuration defined for Sylar.", 1 );
			}	
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}	
	}
	

	/**
	 * Fill the Database List
	 * Fill the list of Sylar supported database.
	 * In the future this method will be able to load the list from a configuration file.
	 *
	 * @return void
	 */
	private function fillDbList(){
		$this->aSupportedDbList['mysql'] = new Sylar_DataBaseManagerItem("MySQL", "mysql", "5", "MySQL Generic Driver for 5.* version");
		$this->aSupportedDbList['oracle'] = new Sylar_DataBaseManagerItem("Oracle 9i", "oracle", "9i", "Oracle Generic Driver for 9.i version");
	}
	
}
 
 


/**
 * Tit File
 * 
 * Desc File
 * 
 * @package Sylar
 * @version 1.0
 * @since 18/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_DataBaseManagerItem{
	private $sName;
	private $sDriver;
	private $sVersion;
	private $sDescription;
	
	function __construct($sName, $sDriver, $sVersion, $sDescription=null){
		$this->setName($sName);	
		$this->setDriver($sDriver);
		$this->setVersion($sVersion);
		$this->setDescription($sDescription);
	}
	function __destruct() {
		# nothing to do
	}
	
	
	// Setter and Getter 
	
	public function setName($sName){
		$this->sName = $sName;
	}
	public function setDriver($sDrive){
		$this->sDriver = $sDrive;
	}
	public function setVersion($sVersion){
		$this->sVersion = $sVersion;
	}
	public function setDescription($sDescription){
		$this->sDescription = $sDescription;
	}
	
	
	public function getName(){
		return $this->sName;
	}
	public function getDriver(){
		return $this->sDriver;
	}
	public function getVersion(){
		return $this->sVersion;
	}
	public function getDescription(){
		return $this->sDescription;
	}
	
	
}

?>