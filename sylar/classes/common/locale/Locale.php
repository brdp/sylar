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

import('sylar.common.system.ConfigBox');


/**
 * Locale Management
 * 
 * @todo At the moment is used only for the language, in the future must be 
 * implemented and extended to all other locale parameters
 * 
 * 
 * @package Sylar
 * @version 1.0
 * @since 07/apr/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_Locale{
	// Locale Configuration object
	private $oConfig;
			
	// File system root of locale for Application files
	private $sApplicationLocaleRootFs;
	
	
	function __construct(Sylar_LocaleConfiguration $oConfig=null){
		if(!is_null($oConfig)){
			$this->setConfig($oConfig);
		}
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	
	
	//								 						   Setter and Getter
	//__________________________________________________________________________
	
	
	/**
	 * @return void
	 * @param Sylar_LocaleConfiguration $oConfig
	 */
	public function setConfig(Sylar_LocaleConfiguration $oConfig){
		$this->oConfig = $oConfig;
	}
	
	
	/**
	 * @return Sylar_LocaleConfiguration
	 */
	public function getConfig(){
		return $this->oConfig;
	}
	
	
	/**
	 * @return void
	 * @param string $sApplicationLocaleRootFs
	 */
	public function setApplicationLocaleRootFs($sApplicationLocaleRootFs){
		$this->sApplicationLocaleRootFs=$sApplicationLocaleRootFs;
	}
	/** 
	 * @return string 
	 */
	public function getApplicationLocaleRootFs(){
		return $this->sApplicationLocaleRootFs;
	}
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
	
	// TODO To be done
	
}












/**
 * Locale Configuration
 * 
 * It contains all settings about locale. Language, character set, Time, etc...
 * 
 * @package Sylar
 * @version 1.0
 * @since 07/apr/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_LocaleConfiguration{
	
	// Language (example it_IT, en_GB, etc...)
	private $sLang;
	
	// Character set
	private $sCharSet;
	
	// Time Zone GMT +:
	private $iTimeZoneOffsetGMT;
	
	// Currency €, $, £, etc...
	// TODO keep attention to symbols like '$'!!!
	private $sCurrency;
	
	// A list of common and standard preconfigured Locale
	private $aStandardSettings;
	
	// The key selected for the automatic config
	private $sStandardSettingKey;

	
	
	

	
	function __construct($sStandardSettingsKey=null){
		
		// if not set then gets the default
		if(is_null($sStandardSettingsKey)){
			$sStandardSettingsKey = Sylar_ConfigBox::getDefaultLocaleKey();
		}
		// prepare array
		$this->aStandardSettings = array();
		$this->loadStandardSettingsList();
		
		// Set configuration
		$this->configureFromStandardSettings($sStandardSettingsKey);
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	
	
	//								 						   Setter and Getter
	//__________________________________________________________________________
	
	
	/**
	 * @return void
	 * @param string $sLang
	 */
	public function setLanguage($sLang){
		$this->sLang = $sLang;
	}
	/** 
	 * @return string 
	 */
	public function getLanguage(){
		return $this->sLang;
	}
	
	/**
	 * @return void
	 * @param string $sCharSet
	 */
	public function setCharSet($sCharSet){
		$this->sCharSet = $sCharSet;
	}
	/** 
	 * @return string 
	 */
	public function getCharSet(){
		return $this->sCharSet;
	}
	
	
	/**
	 * @return void
	 * @param int $iTimeZoneOffsetGMT
	 */
	public function setTimeZoneOffset($iTimeZoneOffsetGMT){
		$this->iTimeZoneOffsetGMT = $iTimeZoneOffsetGMT;
	}
	/** 
	 * @return int 
	 */
	public function getTimeZoneOffset(){
		return $this->iTimeZoneOffsetGMT;
	}	
	

	/**
	 * @return void
	 * @param string $sKey
	 */
	public function setStandardSettingKey($sStandardSettingKey){
		$this->sStandardSettingKey = $sStandardSettingKey;
	}
	/** 
	 * @return string 
	 */
	public function getStandardSettingKey(){
		return $this->sStandardSettingKey;
	}

	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________

	/**
	 * Verify if configuration is defined
	 * return true if all is ok, false otherwise
	 * 
	 * @return boolean
	 */
	public function check(){
		try{
			if(is_null( $this->getLanguage() )){
				throw new ExceptionInSylar("Bad Locale Configuration. Language is null", 10001 );
			}
			
			if(is_null( $this->getCharSet() )){
				throw new ExceptionInSylar("Bad Locale Configuration. CharSet is null", 10002 );
			}
			
			if(is_null( $this->getTimeZoneOffset() )){
				throw new ExceptionInSylar("Bad Locale Configuration. Time Zone Offset is null", 10003 );
			}
			
			// TODO to implements currency
			
			
			
			// if all is ok return true
			return true;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	function switchToStandardSetting($sStandardSettingsKey){
		try{
			// if not set then gets the default
			if(is_null($sStandardSettingsKey)){
				// all remain the same
				throw new ExceptionInSylar("No StandardSettingsKey provided. Configuration not modified", 10009 );
			}
			
			// Set configuration
			$this->configureFromStandardSettings($sStandardSettingsKey);
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________
	
	
	/**
	 * Load defined standard configuration in the array
	 * in the future it can take the list in different way... 
	 * DB, external config file, ecc...
	 * 
	 * @return void
	 */
	private function loadStandardSettingsList(){
		$this->setStandardSettings("it_IT", array("Lang"=>"it_IT", "CharSet"=>"UTF-8", "TimeZoneOffset"=>"+1", "Currency"=>"€"));
		$this->setStandardSettings("en_EN", array("Lang"=>"en_EN", "CharSet"=>"UTF-8", "TimeZoneOffset"=>"0", "Currency"=>"£"));
		$this->setStandardSettings("en_US", array("Lang"=>"en_US", "CharSet"=>"UTF-8", "TimeZoneOffset"=>"-8", "Currency"=>"$"));
	}
	
	
	/**
	 * set a specified array of settings with specified key
	 *
	 * @return void
	 * @param string $sKey the key of array settings
	 * @param array $aSettings settings array
	 */
	private function setStandardSettings($sKey, $aSettings){
		$this->aStandardSettings[$sKey] = $aSettings;
	}
	
	
	/**
	 * get the configuration array with specified key
	 *
	 * @see configureFromStandardSettings
	 *  
	 * @return array
	 * @param string $sKey 
	 */
	private function getStandardSettings($sKey){
		try{
			if(!array_key_exists($sKey, $this->aStandardSettings)){
				throw new ExceptionInSylar("The key of standard locale configuration does not exists. Key: ".$sKey, 10004 );
			}else{
				return $this->aStandardSettings[$sKey];
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Load standard configuration
	 * Load configuration from a specified list
	 *
	 * @return void
	 * @param string $sKey is like: it_IT, en_US, ecc...
	 */
	private function configureFromStandardSettings($sKey){
		try{
			if(is_null($sKey)){
				throw new ExceptionInSylar("The key of standard locale configuration is null", 10005 );
			}
			
			if( is_array($this->getStandardSettings($sKey)) ){
				
				// Set the key selected
				$this->setStandardSettingKey($sKey);
				
				//Set the config parameters
				$aSetting = $this->getStandardSettings($sKey);					
					$this->setLanguage( $aSetting["Lang"] );
					$this->setCharSet( $aSetting["CharSet"] );
					$this->setTimeZoneOffset( $aSetting["TimeZoneOffset"] );
					
					// TODO to implement Currency data
			}
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
		
	}

} 
 
 
 
?>