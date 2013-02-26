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



import('sylar.common.locale.Locale');
import('sylar.common.locale.Language');


/**
 * Main Format Class
 * 
 * Main Class for formatting output in Sylar. 
 * Every classes used to format page and html must extend this class
 * 
 * @package Sylar
 * @version 1.0
 * @since 05/mar/08
 * 
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_Format{
	
	private $localeConf;
		
	function __construct(Sylar_LocaleConfiguration $localeConf=null){
		
		if(is_null($localeConf)){
			/** 
			 * system locale
			 * an objet to use as default sylar Locale Config
			 * 
			 * @see sylar.php
			 * 
			 */
			$localeConf = new Sylar_LocaleConfiguration(Sylar_ConfigBox::getDefaultLocaleKey());
		}
		
		// try to switch to application locale, if isn't set use sylar locale
		if(is_null(APP_DEFAULT_LOCALE)){
			$localeConf->switchToStandardSetting(Sylar_ConfigBox::getDefaultLocaleKey());
		}else{
			$localeConf->switchToStandardSetting(APP_DEFAULT_LOCALE);
		}
		
		$this->setLocaleConfig($localeConf);
		
		// it prepare the language object
		$this->initializeLanguage();
		
		// Load Standard Sylar Dictionary
		$this->loadSylarDictionary("Main");
		$this->loadSylarDictionary("Error");
		
	}
	function __destruct(){
		// nothing to do at the moment
	}
	
	
	
	
	//								 						   Setter and Getter
	//__________________________________________________________________________
	
	
	public function setLocaleConfig(Sylar_LocaleConfiguration $localeConf){
		$this->localeConf = $localeConf;
	}
	public function getLocaleConfig(){
		return $this->localeConf;
	}	
	
	/**
	 * @return void
	 * @param Sylar_Language $oLang
	 */
	public function setLangObj(Sylar_Language $oLang){
		$this->oLang=$oLang;
	}
	/**
	 * @return Sylar_Language
	 */
	public function getLangObj(){
		return $this->oLang;
	}

	
	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
	
	

	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
	
	
	/**
	 * Return the code of locale in witch will be translated the page
	 *
	 * @return string
	 */
	protected function getLocale(){
		return $this->getLocaleConfig()->getStandardSettingKey();
	}
		
	
	/**
	 * Wrapper for provideText
	 *
	 * @see Sylar_Language
	 * 
	 * @return string
	 * @param string $sKey
	 * @param array $aReplace
	 */
	protected function translate($sLabel, $aReplaceList=null){
		return $this->getLangObj()->provideText($sLabel, $aReplaceList);
	}
	

	/**
	 * Wrapper for loadApplicationDictionary
	 *
	 * @see Sylar_Language
	 * 
	 * @return void
	 * @param string $sDictName
	 * @param boolean $bFlagAppend
	 */
	protected function loadDictionary($sDictName, $bFlagAppend=true){
		$this->getLangObj()->loadApplicationDictionary($sDictName, $sDictName);
	}
	

	/**
	 * Wrapper for loadSylarDictionary
	 *
	 * @see Sylar_Language
	 * 
	 * @return void
	 * @param string $sDictName
	 * @param boolean $bFlagAppend
	 */
	protected function loadSylarDictionary($sDictName, $bFlagAppend=true){
		$this->getLangObj()->loadSylarDictionary($sDictName, $sDictName);
	}	
	
	
	
	//								 						     Private Methods
	//__________________________________________________________________________
	
	
	
	
	/**
	 * It prepare the object language for the default use in the application
	 * 
	 * @return void
	 * @see Sylar_Language
	 */
	private function initializeLanguage(){
		try{
			// Prepare Language engine
			$this->setLangObj( new Sylar_Language($this->getLocaleConfig()) );
			// Set Locale Application repository root
			if(is_null(APP_LOCALE_ROOT_FS)){
				throw new ExceptionInSylar('Application dictionary folder not defined.', 10025);
			}
			$this->getLangObj()->setApplicationLocaleRootFs(APP_LOCALE_ROOT_FS);		
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}	
	
	
	

}
 
 
 
?>