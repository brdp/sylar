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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>

    <body>
    <p>Test Connessione al DB e LOG</p>

   	<a href='02.php'>TEST Session &raquo;</a><br><br>   
    
    <textarea style='width: 100%; height: 500px;'>    
    <?php

		#
		# TEST Import Sylar Class
		#
		import('sylar.common.sylar.db.mysql.MysqlDriver');
		import('sylar.common.system.SylarUtils');
		import('sylar.common.security.Session');
		
		
		
		
		echo "\nTest Session Value: ";
		$session = new Sylar_Session();
		if($session->isUserLogged()){
			echo "User Logged!";
			echo "\nlogged as: ".$session->getSessionParam("name")." ".$session->getSessionParam("surname")." [".$session->getSessionParam("username")."]";
			echo "\nUneque ID: ".$session->getUniqueID()." another: ".$session->getUniqueID();
		}else{
			echo "User not logged.";
		}
		
		
		
		
		
		try{		
			$log = new Sylar_Logger();
			
			$db = new Sylar_MysqlDriver();
			
			echo "\n\nConnessione.....";
			
			$db->quoteString("asdasdasd");
			
			$db->connect();
			echo "OK!\n";
			
			$sql = "select * from SYLAR_event_log";
			
			$db->execQuery($sql);
				
			$Log->logEvent("speriamo bene", "VERBOSE");
			
			$db->execQuery($sql);

			$db->disconnect();
			
			if($db->resultRows() > 0){
				while($row=$db->fetchArrayByName()) {
					echo "\n";
					print_r( $row );
				}
			}else{
				echo "No rows found.";
			}
			
			echo "\nLOGGING\n\n";
			$Log->logEvent("Log Evento di prova", "VERBOSE");
			
		}catch (ExceptionInSylar $ex){
			echo "\n\n".__FILE__." Exception: ".$ex->getMessage();
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