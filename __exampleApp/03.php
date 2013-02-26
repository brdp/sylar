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
    <p>Test exception</p>
    
	<a href='04.php'>TEST DataContainer &raquo;</a><br><br>   
    
    <textarea style='width: 100%; height: 500px;'>
<?php
		import('sylar.common.system.SylarUtils');
		import('sylar.common.security.Session');
		import('sylar.common.db.mysql.MysqlDriver');
		
		echo "\nTest Session Value: ";
		$session = new Sylar_Session();
		if($session->isUserLogged()){
			echo "User Logged!";
			echo "\nlogged as: ".$session->getSessionParam("name")." ".$session->getSessionParam("surname")." [".$session->getSessionParam("username")."]";
			echo "\nUneque ID: ".$session->getUniqueID()." another: ".$session->getUniqueID();
		}else{
			echo "User not logged.";
		}
		
		
		
		echo "\n\nWrong DB connection... ";
		try{
			$db = new Sylar_MysqlDriver(new Sylar_DataBaseConfiguration("SylarDefaultDb", array() ));
			$db->connect();
		}catch (ExceptionInSylar $ex){
			echo "\n".$ex->getMessage();
		}
		
		
		echo "\n\nother DB connection...";
		try{
			$db2 = new Sylar_MysqlDriver(new Sylar_DataBaseConfiguration("SylarDefaultDb", array() ));
			$db2->connect();
		}catch (ExceptionInSylar $ex){
			echo "\n".$ex->getMessage();
		}
		
		
		echo "\n\nNow... Togheter! the exception on the first connection error stop the execution of the block code... but it continue after catch statment!!!";
		try{
			$db3 = new Sylar_MysqlDriver(new Sylar_DataBaseConfiguration("SylarDefaultDb", array() ));
			$db3->connect();
			
			$db4 = new Sylar_MysqlDriver(new Sylar_DataBaseConfiguration("SylarDefaultDb", array() ));
			$db4->connect();
			
		}catch (ExceptionInSylar $ex){
			echo "\n".$ex->getMessage();
		}
		
		echo "\n\nContinues after catch... etc... etc...";
		
	
				
		
			echo "\n\n\n-----------------------";
			echo "\nSylar included Files:\n";
			Sylar_SylarUtils::showIncludedFiles();		
			echo "\n\nSylar Defined Costants:\n";
			Sylar_SylarUtils::showDefinedCostant();
		
			
		?>
	</textarea>
	
	
	
    </body>
</html>