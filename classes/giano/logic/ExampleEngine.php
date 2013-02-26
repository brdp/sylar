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
 
// Controls that the file is always included
if( count(get_included_files())<=1 ){ echo "Wrong Call."; exit; }




import('sylar.common.db.mysql.MysqlDriver');
import('sylar.common.system.Logger');
import('sylar.common.data.SimpleTable');

import('sylar.common.db.mysql.data.BindSimpleTable');
import('sylar.presentation.TableList');

import('giano.common.db.mysql.SqlBuilderLogUtils');
import('giano.presentation.html.ExampleFormat');

/**
 * Example Engine 
 * 
 * @package Sylar
 * @version 1.0
 * @since 05/mar/08
 * 
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class App_ExampleEngine{

	function __construct(){
		
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	//								 				   Getter and setter Methods
	//__________________________________________________________________________
			

	
	
	//								 							  Public Methods
	//__________________________________________________________________________	

	
	
	
	
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________	

	
	
	/**
	 * Enter description here...
	 *
	 * @return Sylar_TableList
	 */
	protected function makeExampleRandomList($sTableId=null, $pg=null, $ordby=null, $orddir=null, $pgElem=10){
		
		try{
			
			if(is_null($pg) || $pg<0){ $pg=1; }
					
			// Create SimpleTable Object
			$simpleTb = new Sylar_SimpleTable("Log Info in HTML");		
			// Create table Header Container
			$simpleTbHd = new Sylar_SimpleTableHeader(3);
			
			$paging = new Sylar_Pagination();
			
			
			// Adding Column header descriptions
			$simpleTbHd->addColumn(new Sylar_SimpleTableHeaderColumn("C1", "Event ID", false));
			$simpleTbHd->addColumn(new Sylar_SimpleTableHeaderColumn("C2", "Level"));
			$simpleTbHd->addColumn(new Sylar_SimpleTableHeaderColumn("C3", "Event Description"));
		
			// insert header in table 					
			$simpleTb->setColumnsHeader($simpleTbHd);	
					
			// Prepare binding object
			$bindTb = new Sylar_BindSimpleTable();		
			
			// Create Sql builder object
			$sqlBuilder = new SqlBuilderLogUtils($pgElem);
			
			// Fetch total Rows from count query and set it in the object
			$bindTb->execSmartQuery($sqlBuilder->extractLastEvents(true));
			$sqlBuilder->setLimitElements(10);
			
			$totRow = $bindTb->readField(0,0);
			
			
			
			
			// get the Sql Query example to run on DB
			$sql = $sqlBuilder->extractLastEvents();		
			// Exec query and bind data in the SimpleTable
			$bindTb->selectToTable($simpleTb, $sql);
			
			// At the end format table in HTML with second formatter example method
			//echo $formatLog->makeHtmlLogList($simpleTb);
			
			$formatTable = new Sylar_TableList($sTableId);
			
			$formatTable->paginateFromRawData($totRow, $pg, 10);
			
			$formatTable->setSelectorType("checkbox");
			$formatTable->setTitle("Esempio lista Sylar");
			$formatTable->setSubTitle("Ora tutto sta a renderla dinamica. Speriamo bene! Ora tutto sta a renderla dinamica. Speriamo bene! Ora tutto sta a renderla dinamica. Speriamo bene!");
			$formatTable->setSimpleTable($simpleTb);
			$formatTable->addButton("123", "Export", "alert('Export!');");
			$formatTable->addButton("1234", "Delete", "alert('Delete!');");
			$formatTable->setSelectorVisibility(true);
			$formatTable->setColumnHeaderVisibility(true);
			$formatTable->setBottomControllerVisibility(true);
			$formatTable->setTopControllerVisibility(true);
			$formatTable->setPaginationVisibility(true);
			$formatTable->setButtonsVisibility(true);
			$formatTable->setOrderingVisibility(true);
			
			return $formatTable;

		}catch(ExceptionInSylar $ex){

			//TODO GESTIRE I VARI TIPI DI ERRORE
			throw $ex;

		}
	}
	
	
}
 
?>