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
    <p>Db bind SimpleTable</p>
    
	<a href='06.php'> &raquo;</a><br><br>   
    

<?php

// Sylar Import
import('sylar.common.system.SylarUtils');
import('sylar.common.data.SimpleTable');
import('sylar.common.db.mysql.data.BindSimpleTable');

// Application Import
import('app.giano.db.mysql.SqlBuilderLogUtils');
import('app.giano.presentation.FormatLogList');

	try{
		
		echo "Binding data from DB in table SYLAR_event_log 30 random rows in HTML <br><br>Start Example:<br><br>";

		// Create SimpleTable Object
		$simpleTb = new Sylar_SimpleTable("Log Info in HTML");		
		// Create table Header Container
		$simpleTbHd = new Sylar_SimpleTableHeader(3);
		
		// Adding Column header descriptions
		$simpleTbHd->addColumn(new Sylar_SimpleTableHeaderColumn("event_id"));
		$simpleTbHd->addColumn(new Sylar_SimpleTableHeaderColumn("level"));
		$simpleTbHd->addColumn(new Sylar_SimpleTableHeaderColumn("event_desc"));
	
		// insert header in table 					
		$simpleTb->setColumnsHeader($simpleTbHd);	
				
		// Prepare binding object
		$bindTb = new Sylar_BindSimpleTable();		
		// Initialize Formatter object
		$formatLog = new FormatLogList();		
		// Create Sql builder object
		$sqlBuilder = new SqlBuilderLogUtils();
		
		// get the Sql Query example to run on DB
		$sql = $sqlBuilder->extractLastEvents(30);		
		// Exec query and bind data in the SimpleTable
		$bindTb->selectToTable($simpleTb, $sql);
		
		// At the end format table in HTML with second formatter example method
		echo $formatLog->makeHtmlLogList($simpleTb);
		
		
		echo "<br><br>The end of example<br><br>";
		
		
	}catch (ExceptionInSylar $ex){
		echo "\n".$ex->getMessage();
	}

	
?>


<textarea style='width: 100%; height:150px;'>
<?php
echo "Sylar included Files:\n";
Sylar_SylarUtils::showIncludedFiles();		
echo "\n\nSylar Defined Costants:\n";
Sylar_SylarUtils::showDefinedCostant();		
?>
</textarea>
	
	
	
    </body>
</html>