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


/**
 * Configuration Box
 * 
 * A class that conteins all Sylar Configuration values read from config and settings file.
 * 
 * @package Sylar
 * @version 1.0
 * @since 16/feb/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team 
 */ 
class Sylar_ConfigBox{
	
	function __construct(){
		# nothing to do
	}
	function __destruct() {
		# nothing to do
	}

	
	/**
	 * Return the Sylar default Charset set in the config file 
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
 	 * @see sylar.php
 	 * 
	 * @return string
	 */
	public static function getDefaultCharset(){
		return SYLAR_DEFAULT_CHARSET;
	}
	
	
	/**
	 * Return the Sylar default locale
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
 	 * @see sylar.php
 	 * 
	 * @return string
	 */
	public static function getDefaultLocaleKey(){
		return SYLAR_DEFAULT_LOCALE;
	}
	
	
	/**
	 * Level of logger
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public static function getLogLevel(){
		return SYLAR_LOG_LEVEL;
	}
	
	
	/**
	 * return the name of the PHP session
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public static function getSessionName(){
		return SYLAR_SESSION_NAME;
	}
	
	
	/**
	 * return the path of locale folder
	 * 
	 * @since apr/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public static function getLocaleFsRoot(){
		return SYLAR_ROOT_FS."locale/";
	}
	
	
	/**
	 * return the path root of Sylar javascript files
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public static function getSylarJsUrlPath(){
		return SYLAR_ROOT_URL."javascript/";
	}


	/**
	 * return the path root of Sylar css files
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public static function getSylarCssUrlPath(){
		return Sylar_ConfigBox::getSylarDefaultLayoutUrlPath()."css/";
	}
	
	
	/**
	 * return the path root of Sylar images and icons files
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public static function getSylarImgUrlPath(){
		return Sylar_ConfigBox::getSylarDefaultLayoutUrlPath()."img/";
	}	
	
	
	
	/**
	 * return the path root of Sylar layout templates collaction
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	private static function getSylarDefaultLayoutUrlPath(){
		return SYLAR_ROOT_URL."layouts/".SYLAR_DEFAULT_LAYOUTNAME."/";
	}	
	
	
	/**
	 * return the name of the default layout template set in Sylar
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public static function getSylarDefaultLayout(){
		return SYLAR_DEFAULT_LAYOUTNAME;
	}
		
	
	
	
	
	
	/**
	 * Debugmode
	 * Return true if Sylar is in debug mode, false otherwise
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return boolean
	 * 
	 * @see SYLAR_DEBUG_MODE
	 */
	public static function isSylarInDebugMode(){
		if(SYLAR_DEBUG_MODE){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Chek if a session is enable and required.
	 * return true if a session is ON, false otherwise.
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return boolean
	 */
	public static function isSessionEnabled(){
		if(SYLAR_SESSION_NAME){
			return true;
		}else{
			return false;
		}
	}

	
}
 
 
 
?>