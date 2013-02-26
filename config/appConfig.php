<?php
/**
 * Application settings
 * 
 * Defines all application settings 
 * 
 * @package Sylar
 * @version 1.0
 * @since 15/feb/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team 
 */


// 																   Layout Config
//______________________________________________________________________________

/**
 * Application Html pages default title
 */
define('APP_HTML_TITLE', "A Sylar Example App");


/** Application default locale set */
define('APP_DEFAULT_LOCALE', 'en_EN'); 


/** 
 * Application default Character set 
 */
define('APP_DEFAULT_CHARSET', 'UTF-8'); 





// 														Sylar Framework Settings
//______________________________________________________________________________


/**
 * Application name
 * The root directory of application.
 * for example: http://localhost/sylarApp/
 * the Application Name is "sylarApp" but if you ar working on domain you can leave blank
 * the costant:  define('APPLICATION_NAME', "");
 * Remember the "/" at the end of the name!
 */	
define('SYLAR_APPLICATION_NAME', "sylar/");

/**
 * Sylar folder name
 * Directory name of sylar framework
 * Remember the "/" at the end of the name!
 */	
define('SYLAR_FOLDER_NAME', "sylar/");

/**
 * Application Web Root
 * The http root directory of Application
 */	
define('SYLAR_APPLICATION_ROOT_URL', 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].'/'.SYLAR_APPLICATION_NAME);

/**
 * Application FileSystem Root
 * The root directory of Application on the FileSystem of the server
 */	
define('SYLAR_APPLICATION_ROOT_FS', ''.$_SERVER["DOCUMENT_ROOT"].'/'.SYLAR_APPLICATION_NAME);

/**
 * Sylar Web Root
 * The http root directory of Sylar Framework
 */	
define('SYLAR_ROOT_URL', SYLAR_APPLICATION_ROOT_URL.SYLAR_FOLDER_NAME);

/**
 * Sylar FileSystem Root
 * The root directory of Sylar Framework on the FileSystem of the server
 */	
define('SYLAR_ROOT_FS', SYLAR_APPLICATION_ROOT_FS.SYLAR_FOLDER_NAME);

/**
 * Application Classes root dir
 * The root directory of Application classes repository
 */	
define('SYLAR_APPLICATION_CLASSES_ROOT_FS', SYLAR_APPLICATION_ROOT_FS."classes/");

/**
 * Database Connection Config 
 * Define all DB used in the application with Sylar and relative parameters.
 * Which one db is used by default from the list above 
 */	
$SYLAR_DB["develop"] = array('username' => 'sylar', 'password' => 'sylar', 'schema' => 'sylar', 'host'=> 'localhost', 'driver'=>'mysql', 'charset'=>'utf8');
$SYLAR_DB["test"] = array('username' => 'db_user', 'password' => 'db_pwd', 'schema' => 'db_name', 'host'=> 'localhost', 'driver'=>'mysql', 'charset'=>'utf8');
$SYLAR_DB["production"] = array('username' => 'db_user', 'password' => 'db_pwd', 'schema' => 'db_name', 'host'=> 'localhost', 'driver'=>'mysql', 'charset'=>'utf8');	

define('SYLAR_USED_DB', 'develop');





// 															Application Settings
//______________________________________________________________________________


/**
 * Application Javascript Repository
 * The URL root of repository
 */	
define('APP_JAVASCRIPT_URL_ROOT', SYLAR_APPLICATION_ROOT_URL.'javascript/');


/**
 * Layout Template Name
 * the name is the same of directory in layouts folder 
 */	
define('APP_LAYOUT_TEMPLATE', 'default');


/**
 * Application Css Repository
 * The URL root of repository
 */	
define('APP_LAYOUT_CSS_URL_ROOT', SYLAR_APPLICATION_ROOT_URL.'layouts/'.APP_LAYOUT_TEMPLATE.'/css/');


/**
 * Application Locale root on Filesystem
 * IT MUST BE DEFINED
 */	
define('APP_LOCALE_ROOT_FS', SYLAR_APPLICATION_ROOT_FS.'locale/');





// 												   Ok! load the Sylar Framework!
//______________________________________________________________________________
if (!include_once SYLAR_ROOT_FS.'sylar_loader.php'){
	echo "Wrong import of sylar_loader. Sylar Die.";
	exit;
}

 
?>
