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
import('sylar.common.system.ConfigBox');	
import('sylar.common.system.Logger');
import('sylar.common.data.DataContainer');
import('sylar.common.data.SimpleTableHeader');

/**
 * Sylar_SimpleTableRow
 * 
 * it define the structure and methods of a simple row of Sylar_SimpleTable container.
 * the row must be an array indexed whit same header. For example
 * 
 * 			Table name: test
 * 			TbHeader:
 * 			name		surname		phone		email
 * TbRow 0	Nik			Mallet		090909		nik@nik.ir	
 * TbRow 1	Bob			Bruk		0877689		bon@bob.com
 * TbRow ...
 * TbRow n	Tim			Ork			078	778		tim@tim.xx
 * 
 * Header info must be specified only one time and every row must be a Sylar_SimpleTableRow with an array 
 * 
 * @see Sylar_SimpleTable
 * 
 * @package Sylar
 * @version 1.0
 * @since 22/feb/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team 
 */
class Sylar_SimpleTableRow extends Sylar_DataContainer{
	private $arrayData;
	private $columns;
	
	/**
	 * Constructor
	 * reset data and set the number of columns defined
	 *
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
  	 * 
	 * @param array $arrayDataRow
	 * @param int $columns specify number of columns of the row, if false then it calculates it from dataArray
	 */
	function __construct($arrayDataRow, $columns=false){
		
		// If not specified it counts columns from data array
		if(!$columns){
			$columns = count($arrayDataRow);
		}
		
		$this->setColumns($columns);
		$this->resetArrayData();
		$this->fillRowData($arrayDataRow);
	}
	function __destruct(){
		// nothing to do at the moment
	}
	
	
	// Getter and Setter
	// --------------------------------
	public function setColumns($iColumns){
		$this->columns = $iColumns;
	}
	public function getColumns(){
		return $this->columns;
	}
	
	
	
	
	// Public methods
	// --------------------------------
		
	
	/**
	 * Get data from Row
	 * Return the array that contains data
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @todo to be done
	 * 
	 * @return array
	 */
	public function getData(){
		return $this->arrayData;
	}
	
	
	/**
	 * Check data
	 * Return tru if row contains data, false otherwise
	 * 
	 * @since 03/2008
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return boolean
	 */
	public function hasData(){
		if($this->isRowDataSet() && $this->getColumns()>0){			
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 * fill data into the row
	 * it also compares the lenght of array with the number of column declared into the table, if needed.
	 * return true if all is ok, false on error
	 *
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return boolean
	 * @param array $arrayDataRow
	 */
	public function fillRowData($arrayDataRow){
		try{
			
			if(!$this->isRowDataSet()){
				throw new ExceptionInSylar("The array provided to fill TableRow is not an array. [Sylar_SimpleTableRow::fillRowData]");
			}
			
			if($this->isColumnsNumControlEnabled() && $this->getColumns()!=count($arrayDataRow)){
				throw new ExceptionInSylar("The number of columns in array is different from TableRow columns. [Sylar_SimpleTableRow::fillRowData]");
			}
			
			// If we are here is all ok!
			$this->arrayData = $arrayDataRow;
			
			return true;
		
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * it returns the value at column $columnId of the TableRow
	 *
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @param int $columnId
	 * @return mixed
	 */
	public function getColumnValue($columnId){
		try{
			if(!$this->isRowDataSet()){
				throw new ExceptionInSylar("The TableRow is not Set. [Sylar_SimpleTableRow::getColumnValue]");
			}
			
			if(!array_key_exists($columnId, $this->arrayData) ){
				throw new ExceptionInSylar("The number of columns ".$columnId." does not exists. [Sylar_SimpleTableRow::fillRowData]");
			}
					
			return $this->arrayData[$columnId];
		
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	
	
	// Private Methods
	// --------------------------------
	
	/**
	 * reset data container
	 * If is set destroy and reset the data container array
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return void
	 */
	private function resetArrayData(){
		if(isset($this->arrayData)){
			unset($this->arrayData);
		}
		$this->arrayData = array();
	}
	
	
	/**
	 * Check Columns control
	 * It verify if the control on columns number is on return true, false otherwise.
	 *
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return boolean
	 */
	private function isColumnsNumControlEnabled(){
		if(!$this->getColumns()){
			return false;
		}
		return true;
	}
	
	
	/**
	 * Check data container
	 * it verify that the container of data is set correctly and return true,  return false otherwise
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return boolean
	 */
	private function isRowDataSet(){
		if(!is_array($this->arrayData)){
			return false;	
		}
		return true;
	}
	
	
} 
 
 
?>