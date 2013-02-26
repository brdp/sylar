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


/** Include the class ConfigBox */
import('sylar.common.system.ConfigBox');	
import('sylar.common.system.Logger');


/**
 * ReDefine a custom exception class for Sylar system
 * 
 * @todo To be done!
 * 
 * @package Sylar
 * @version 1.0
 * @since 12-2004
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team 
 */
class ExceptionInSylar extends Exception{
	
    /**
     * Redefine the exception so message isn't optional
     */
    public function __construct($message, $code=0) {
        #
        # Custom cose
        #
        //TODO to be done
    	$message = "[SylarException n: ".$code."] ".$message;
    	
        // make sure everything is assigned properly
        parent::__construct($message, $code);
    }

    /**
     * format the exception description for storage in Log
     *
     * @todo to be done
     * 
     * @return string
     */
    public function getMessageForLog(){
    	$msg = parent::getMessage();
    	
    	$msg .= "Stack:\n ";
    	//$aStakTrace = parent::getTrace();
    	foreach (parent::getTrace() as $sItem) {
    		foreach ($sItem as $k=>$v){
    			$msg .= $k." = ".$v."\n";
    		}
    		$msg .= "\n\n";
    	}
    	 
    	
    	return $msg;
    }
    
    
    /**
     * it logs directly the exceptions with Logger
     */
    public function logException(){
    	//TODO To be done
    }
    
    /**
     * custom string representation of object
     */
    public function __toString() {
        return "[Sylar Exception toString: \n";
        
        //TODO To be done
    }

    
}
 
 
 
 
?>