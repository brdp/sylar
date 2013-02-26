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


import("sylar.common.locale.Locale");
import("sylar.common.system.ConfigBox");

/**
 * Class to manage the languages and translations 
 * 
 * @see Sylar_Locale
 * @see Sylar_LocaleConfiguration
 * 
 * @package Sylar
 * @version 1.0
 * @since 21/feb/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team 
 */
 
class Sylar_Language extends Sylar_Locale{
	
	// Locale Configuration object
	private $oConfig;
	
	// Array that contains the translations
	private $aDictionary;
	
	
	
	/**
	 * @return void
	 * @param Sylar_LocaleConfiguration $oConfig
	 */
	function __construct(Sylar_LocaleConfiguration $oConfig){
		parent::__construct($oConfig);
		
		// prepare dictionary
		$this->formatDict();
	}
	
	
	function __destruct(){
		unset($this->aDictionary);
	}


	
	
	//								 						   Setter and Getter
	//__________________________________________________________________________	
	
	
	public function setDictionary($aDictionary){
		$this->aDictionary = $aDictionary;
	}
	
	public function getDictionary(){
		return $this->aDictionary;
	}
	
	public function setConfig(Sylar_LocaleConfiguration $oConfig){
		parent::setConfig($oConfig);
	}
	
	public function getConfig(){
		return parent::getConfig();	
	}	
	
	/**
	 * @return void
	 * @param string $sApplicationLocaleRootFs
	 */
	public function setApplicationLocaleRootFs($sApplicationLocaleRootFs){
		parent::setApplicationLocaleRootFs($sApplicationLocaleRootFs);
	}
	
	/**
	 * @return string
	 */
	public function getApplicationLocaleRootFs(){
		return parent::getApplicationLocaleRootFs();	
	}
	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
	
	
	/**
	 * It load a specified Sylar dictionary file
	 * It load dictionaries from Sylar standard directory
	 * 
	 * @param string $sDictName Dictionary file name without the extension (must be a .php file)
	 * @param boolean $bFlagAppend
	 */
	public function loadSylarDictionary($sDictName, $bFlagAppend=true){
		try{
			// Define right path
			$dictPath = Sylar_ConfigBox::getLocaleFsRoot().$this->getConfig()->getLanguage()."/lang/".$sDictName.".php";
			
			// call generic import Dict
			$this->loadDictionary($dictPath, $bFlagAppend);
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	public function loadApplicationDictionary($sDictName, $bFlagAppend=true){
		try{
			if($this->getApplicationLocaleRootFs()==null){
				throw new ExceptionInSylar("Application Locale Root on Filesystem is not defined or not visible from the object Language", 10007 );
			}
			
			// Define right path
			$dictPath = $this->getApplicationLocaleRootFs().$this->getConfig()->getLanguage()."/lang/".$sDictName.".php";
			
			// call generic import Dict
			$this->loadDictionary($dictPath, $bFlagAppend);
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}

	
	/**
	 * It returns the content of a file
	 * the file has .tpl extension 
	 *
	 * @return string
	 * @param string $sFileName name file without extension 
	 */
	public function getStaticTextFromFile($sFileName){
		try{
			if($this->getApplicationLocaleRootFs()==null){
				throw new ExceptionInSylar("Application Locale Root on Filesystem is not defined or not visible from the object Language", 10007 );
			}
			
			// Define right path
			$dictPath = $this->getApplicationLocaleRootFs().$this->getConfig()->getLanguage()."/static/".$sFileName.".tpl";
			
			if(file_exists($dictPath)){
				$result = file_get_contents($dictPath);
			}else{
				throw new ExceptionInSylar("Application static locale file does not exists. Required file: {$dictPath}", 10024 );
			}
			
			return $result;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}	
	
	
	/**
	 * It returns the translation string associated to label in the dictionary array
	 * A generic error message is showed if the label doesn't exists in the dictionary
	 * 
	 * @see loadDictionary
	 * 
	 * @param string $sLabel
	 * @return string with translations
	 */
	public function provideText($sLabel, $aReplaceList=null){
		try{
			$result = $this->extractText($sLabel);
			
			if($result==null){
				$result = "Translate not avaiable.";
				if(Sylar_ConfigBox::isSylarInDebugMode()){
					$result .= " [Label: ".$sLabel."]";
				}
	
				// the end
				return $result;
			}
			
			if(!is_null($aReplaceList)){
				if(!is_array($aReplaceList)){			
					throw new ExceptionInSylar("Language encode error! Provided replace array is not an array", 10008 );
				}
				
				// Replace in Text from array
				$result = vsprintf($result, $aReplaceList);
			
			}
			
			return $result;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	
	
	
	
	//															  Private Method
	//__________________________________________________________________________
	
	
	/**
	 * Format the dictionary container and prepare it to contain the translations list
	 * 
	 * @return void
	 */
	private function formatDict(){
		unset($this->aDictionary);
		$this->aDictionary=array();
	}
	
	
	/**
	 * Extract the string of translation from dictionary and return it. 
	 * Return null if the label doesn't exists.
	 *
	 * @param string $sLabel
	 * @return string
	 */
	private function extractText($sLabel){
		if(array_key_exists($sLabel, $this->getDictionary())){
			// TODO use get 
			return $this->aDictionary[$sLabel];
		}else{
			return null;
		}
	}
	
	
	/**
	 * Load Dictionary Array from disk.
	 *
	 * @param string $sDictPath
	 * @param boolean $bFlagAppend
	 */
	private function loadDictionary($sDictPath, $bFlagAppend=true){
		try{					
			// Load dict file from disk
			if(!file_exists($sDictPath)){
				throw new ExceptionInSylar("Dict file does not exists. File: ".$sDictPath, 10006 );
			}else{
				require($sDictPath);
			}
			
			
			// IMPORTANT!
			// in the file Dict $dictPath is defined the dict array his name is:
			// $aDict = array("Key"=>"Value", etc...) 
			
			
			// Append array
			if($bFlagAppend){	
				$this->setDictionary( array_merge( $this->getDictionary(), $aDict ) );
			
			// Overwrite array
			}else{	
				$this->formatDict();
				$this->setDictionary($aDict);				
			}
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
}
 
 
?>