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



import('sylar.common.system.ExceptionInSylar');
import('sylar.common.db.mysql.MysqlDriver');
import('sylar.common.data.SimpleTable');

/**
 * Bind SimpleTable to DBTable
 * 
 * 
 * @package Sylar
 * @version 1.0
 * @since 04/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */ 
class Sylar_BindSimpleTable extends Sylar_MysqlDriver{
	
 	function __construct(Sylar_DataBaseConfiguration $dbConfiguration=null){
		parent::__construct($dbConfiguration);
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	/**
	 * Exec Select and fill SimpleTable
	 * Exec the query on db and fill data results in the SimpleTable Object param.
	 * Return filled SimpleTable, on error return false 
	 *
	 * @since 03-2008
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return boolean
	 * @param Sylar_SimpleTable &$sTable the SimpleTable object to fill with data extracted from db by $query
	 * @param string $query sql query to execute on db
	 * @param boolean $empyResult flag to remove data from resultset of DataBase Quesry. Default is true
	 */
	public function selectToTable(Sylar_SimpleTable &$sTable, $query, $empyResult=true){
		try{
			$this->execSmartQuery($query);
			for($i=0; $i<$this->resultRows(); $i++){
				$sTable->addSimpleTableRow(new Sylar_SimpleTableRow($this->fetchArrayByNum()));
			}
			
			// reset Result if needed
			if($empyResult){
				$this->resetResults();
			}			
			return true;
			
		}catch (ExceptionInSylar $ex){
			// send out the exception
			throw $ex;
		}
	}
	
}
 
 
 
?>