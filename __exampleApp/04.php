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
    <p>Test DataContainer</p>
    
	<a href='05.php'>TEST Db to SimpleTable &raquo;</a><br><br>   
    
    <textarea style='width: 100%; height: 500px;'>
<?php

import('sylar.common.system.SylarUtils');
import('sylar.common.system.Logger');
import('sylar.common.data.SimpleTable');
import('sylar.common.data.SimpleTableRow');


	try{

		$simpleTb = new Sylar_SimpleTable("pippo");
		
		// Create table Header Container
		$simpleTbHd = new Sylar_SimpleTableHeader(3);
		
		// Adding Column header descriptions
		$col = new Sylar_SimpleTableHeaderColumn("event_id");
		$col->setColumnName("EVENT ID");
		$col->setColumnType("int");
		$col->setColumnDesc("the unique id of the event");
		$simpleTbHd->addColumn($col);
		
		$col = new Sylar_SimpleTableHeaderColumn("name");
		$col->setColumnName("Name");
		$col->setColumnType("string");
		$col->setColumnDesc("the name of the user");
		$simpleTbHd->addColumn($col);
		
		$col = new Sylar_SimpleTableHeaderColumn("permissions");
		$col->setColumnName("Permissions");
		$col->setColumnType("string");
		$col->setColumnDesc("the user's permissions");
		$simpleTbHd->addColumn($col);

		
		$simpleTb->setColumnsHeader($simpleTbHd);
		  					
		  					
		for($i= 0; $i<10; $i++){
			
				$riga = new Sylar_SimpleTableRow( array($i, 'pippo_'.$i, '1,23,'.$i), 3);
				$simpleTb->addSimpleTableRow($riga);
			
				$appoA = $riga->getData();
		}
	
		echo "\nNew Simple Table created, name: ".$simpleTb->getTableTitle()." and Table Id: ".$simpleTb->getTableId();
		
		echo "\nTable Rows: ".$simpleTb->getRows();
		
		
		echo "\nRow: 7 Column 1: ".$simpleTb->getRow(7)->getColumnValue(1);
		
		
		echo "\nRow n.6 is: ".$simpleTb->getRow(7)->getData();
		echo "\nArray of row number 6: \n";
		print_r($simpleTb->getRow(6)->getData());

		
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