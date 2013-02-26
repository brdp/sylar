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
 * Sylar - Framework Loader
 * Load the Sylar Framework base settings
 *
 * @package Sylar
 * @version 1.0
 * @since 02-2008
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */

#
# Controls that this file is only and always included
#
if( count(get_included_files())<=1 ){
	echo "Wrong Call. Sylar Die.";
	exit;
}


/**
 * Sylar Settings
 * Load the configuration of Sylar Framework
 * 
 * SYLAR_ROOT_FS must be defined for example in the application config file
 */
include_once SYLAR_ROOT_FS.'settings/sylar.php';


/** Imports */
import('sylar.common.system.ConfigBox');	
import('sylar.common.system.Logger');
import('sylar.common.system.ExceptionInSylar');
import('sylar.common.db.DataBaseConfiguration');
import('sylar.common.locale.Locale');



//															  Sylar Loader Start
//______________________________________________________________________________

try{	
	/**
	 * Default Db Configuration
	 * the default configuration for the sylar db
	 */
	$SYLAR_DEFAULT_DB_CONFIG = new Sylar_DataBaseConfiguration("SylarDefaultDb", $SYLAR_DB[SYLAR_USED_DB]);
	
	
	
	/**
	 * Make session starts if needed
	 */
	if(Sylar_ConfigBox::isSessionEnabled()){
		
		if (!isset($_SESSION[Sylar_ConfigBox::getSessionName()])){
	
	        session_start();
	
	        #
	        # Sylar use an Hash to store session information
	        #
	        if (!isset($_SESSION[Sylar_ConfigBox::getSessionName()])){
	           	$_SESSION[Sylar_ConfigBox::getSessionName()] = array();
			}
		}
		
		#
		# Sylar Include Session manage in the applications
		#
		import('sylar.common.security.Session');
	}
	
	
	
	
	
	
	/** 
	 * system object for logger
	 * an objet to use in the application
	 */
	$Log = new Sylar_Logger();
	
	
	/** 
	 * system locale
	 * an objet to use as default sylar Locale Config
	 * 
	 * @see sylar.php
	 * 
	 */
	$localeDef = new Sylar_LocaleConfiguration( Sylar_ConfigBox::getDefaultLocaleKey() );
	
	

}catch (ExceptionInSylar $ex){
	echo "Error in Sylar Loader! Check the system configuration.";
	
	// Show details only if debug mode is active
	if(Sylar_ConfigBox::isSylarInDebugMode()){
		echo "\n</br>\n</br>[DEBUG MODE: ON] Errore Desc: \n</br>";
		echo $ex->getMessage();		
	}
	exit;
}






//																	   Functions
//______________________________________________________________________________
	
/**
 * import() function
 * This function includes php codes from other scripts (libraryes) to current environment
 * Folders separator is dot character '.' and base path (SYLAR_CLASSES_ROOT_FS) 
 *
 * If $fileClass starts whith ~ it includes the classes from application defined 
 * in SYLAR_APPLICATION_CLASSES_ROOT_FS
 *
 * @package Sylar
 * @version 1.0
 * @since 02/2008
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Giano Solutions Srl
 * 
 * @param string $fileClass the path of class separated by "." example: db.mysql.driver
 */
function import($fileClass){
	$sOrigRequest = $fileClass;
	
	// Class name is the same of the filename whitout the extension
	//
	$className = explode(".", $fileClass);
	
	
	switch ($className[0]) {
		
		// import a sylar Class using the prefix sylar 
		// import('sylar.common.base.db.mysql...');
		case "sylar":
			$fileClass = str_replace("sylar.", "", $fileClass);
			$fileClass = str_replace('.', '/', $fileClass);
			$fileClass = SYLAR_CLASSES_ROOT_FS.$fileClass;
			break;	
		
		
		
		// import a application Class using the prefix app 
		// import('app.presentation.user...');
		// equivalent to ~.presentation.user	
		case "app":
			$fileClass = str_replace("app.", "", $fileClass);
			$fileClass = str_replace('.', '/', $fileClass);
			$fileClass = SYLAR_APPLICATION_CLASSES_ROOT_FS.$fileClass;
			break;		

		// Old Command ~. is equal to app.
		case "~":
			$fileClass = str_replace("~.", "", $fileClass);
			$fileClass = str_replace('.', '/', $fileClass);
			$fileClass = SYLAR_APPLICATION_CLASSES_ROOT_FS.$fileClass;
			break;				
			
		// Default import is the application class path
		default:
			$fileClass = str_replace('.', '/', $fileClass);
			$fileClass = SYLAR_APPLICATION_CLASSES_ROOT_FS.$fileClass;
			break;
	}
	
	
	// add the file extension to the path
	//
	$fileClass .= ".php";

	// Verify and include the php file
	//
	if(!include_once $fileClass){
		// Class not found! Manage error
		//
		echo "import() error! Sylar Die. \n(".$sOrigRequest.")";
		exit;
	}
}


?>