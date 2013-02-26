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
 * Example Sylar File
 * Some files that shows how sylar works
 * 
 * @package Sylar
 * @version 1.0
 * @since 02-2008
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */

#
# Include the bas Application settings
#
require_once '../config/appConfig.php';
?>		

<html>
<head>

</head>

    <body>
    <p>Test User Session</p>
    
	<a href='03.php'>TEST Exception &raquo;</a><br><br>
    
    <textarea style='width: 100%; height: 500px;'>
<?php
	    	echo "\nRELOAD THE PAGE!!!\n";	
	    
			#
			# TEST Import Sylar Class
			#
			import('sylar.common.security.Session');
			import('sylar.common.system.SylarUtils');
			
			try{
				$session = new Sylar_Session();
				
				echo "\nSID: ".session_id();
				
				if($session->isUserLogged()){
					echo "\nlogged as: ".$session->getSessionParam("name")." ".$session->getSessionParam("surname")." [".$session->getSessionParam("username")."]";
					
					echo "\nUneque ID: ".$session->getUniqueID()." another: ".$session->getUniqueID();
					
					echo "\n\nIs User in Group 1? ".(($session->isUserMemberOfGroupId(1)) ? "Si!" : "No!");
					echo "\nIs User in Group 11998? ".(($session->isUserMemberOfGroupId(11998)) ? "Si!" : "No!");
					
					echo "\n\nHas User Permission ID 1? ".(($session->hasUserPermissionId(1)) ? "Si!" : "No!");
					echo "\nHas User Permission ID 18999? ".(($session->hasUserPermissionId(18999)) ? "Si!" : "No!");
					
					echo "\n\nHas User Permission Code 'sylar_user_add'? ".(($session->hasUserPermissionCode('sylar_user_add')) ? "Si!" : "No!");
					echo "\nHas User Permission Code 'sylar_user_add_NOTEXISTS'? ".(($session->hasUserPermissionCode('sylar_user_add_NOTEXISTS')) ? "Si!" : "No!");
									
					echo "\n\n".$session->getSessionStatusDump();
					
					echo "\n\nNow, perform Logout...";
					$session->logout();
				}else{
					echo "\nNot logged, now perform login for brdp... ";
					echo "\n\n".$session->getSessionStatusDump();
					$session->login("brdp", "brdp");
				}	
			}catch (ExceptionInSylar $ex){
				echo "\n".$ex->getMessage();
			}		
			
			
			
			echo "\n\n\n-----------------------";
			echo "\nSylar included Files:\n";
			Sylar_SylarUtils::showIncludedFiles();		
			echo "\n\nSylar Defined Costants:\n";
			Sylar_SylarUtils::showDefinedCostant();
		
			
		?>

	</textarea>
	
	
	
	
    </body>
</html>