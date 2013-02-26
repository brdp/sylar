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
 * Sylar - Framework Base Settings
 * Contains framework settings, constants and init instructions
 *
 * @package Sylar
 * @version 1.0
 * @since 02-2008
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */

#
# Controls that the file is always included
#
if( count(get_included_files())<=1 ){
	echo "Wrong Call. Sylar Die.";
	exit;
}

define('SYLAR_VERSION','0.3.6');



/**
 * System Constant
 * Costanti Necessarie al funzionamento di Sylar e dell'applicazione
 * Vengono definite nel file di configurazione dell'applicazione che utilizza il framework.
 * 
 * @see appConfig.php
 * 
 *	define('SYLAR_APPLICATION_NAME', "sylarExampleApp/");		
 *	define('SYLAR_FOLDER_NAME', "sylar/");		
 *	define('SYLAR_APPLICATION_ROOT_URL', 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].'/'.SYLAR_APPLICATION_NAME);		
 *	define('SYLAR_APPLICATION_ROOT_FS', ''.$_SERVER["DOCUMENT_ROOT"].'/'.SYLAR_APPLICATION_NAME);		
 *	define('SYLAR_ROOT_URL', SYLAR_APPLICATION_ROOT_URL.SYLAR_FOLDER_NAME);		
 *	define('SYLAR_ROOT_FS', SYLAR_APPLICATION_ROOT_FS.SYLAR_FOLDER_NAME);
 */


/**
 * Database Connection Config 
 * Define all DB used in the application with Sylar and relative parameters.
 * Which one db is used by default from the list above 
 * 
 * @see appConfig.php
 * 
 * Usually is defined in the application config file
 */	
//$SYLAR_DB["develop"] = array('username' => 'sylar', 'password' => 'sylar', 'schema' => 'sylarExampleDB', 'host'=> 'localhost', 'driver'=>'mysql');
//$SYLAR_DB["test"] = array('username' => 'db_user', 'password' => 'db_pwd', 'schema' => 'db_name', 'host'=> 'localhost', 'driver'=>'mysql');
//$SYLAR_DB["production"] = array('username' => 'db_user', 'password' => 'db_pwd', 'schema' => 'db_name', 'host'=> 'localhost', 'driver'=>'mysql');	

//define('SYLAR_USED_DB', 'develop');


/** Switch Sylar in Debug mode */
define('SYLAR_DEBUG_MODE', true); 


/** Sylar default locale set */
define('SYLAR_DEFAULT_LOCALE', 'en_EN'); 


/** Sylar default Character set */
define('SYLAR_DEFAULT_CHARSET', 'UTF-8'); 


/** Sylar default layout template name */
define('SYLAR_DEFAULT_LAYOUTNAME', 'default'); 


/** 
 * Set the level of event log
 * It can be one of them:
 * - DEBUG
 * - VERBOSE
 * - NORMAL
 * - WARNING
 * - FATAL
 * - NO_LOG
 */
define('SYLAR_LOG_LEVEL', 'VERBOSE');


/**
 * Set the PHP Session Name
 * Is the name that PHP set on server to storage information in session
 * 
 * if you don't need a web session set it to false like:
 * define('SYLAR_SESSION_NAME', false);
 */
define('SYLAR_SESSION_NAME', 'SYLAR_SESSION');


/**
 * Sylar Settings folder
 * Define the path of Sylar folder that contains settings files.
 */	
define('SYLAR_SETTINGS_FS', SYLAR_ROOT_FS.'settings/');


/**
 * Root Classes
 * The root of class directory and files
 */	
define('SYLAR_CLASSES_ROOT_FS', SYLAR_ROOT_FS.'classes/');



?>
