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


/**
 * SimpleTableHeader
 * It is the header of the table. It contains informations about:
 * 
 * @see Sylar_SimpleTable
 * @see Sylar_SimpleTableHeaderColumn
 * 
 * @package Sylar
 * @version 1.0
 * @since 03/2008
 * 
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team 
 */
class Sylar_SimpleTableHeader{
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
	function __construct($columns=false){
		
		// If not specified set columns to 0 and refresh every add
		if(!$columns){
			$columns = 0;
		}
		
		$this->reset();
		$this->setColumns($columns);
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
	
	/**
	 * Return the list of the columns defined in the header
	 *
	 * @see Sylar_SimpleTableHeaderColumn
	 * 
	 * @return array that contains object Sylar_SimpleTableHeaderColumn
	 */
	private function getColumnsList(){
		return $this->arrayData;
	}
	
	
	
	
	// Public methods
	// --------------------------------
	
	
	/**
	 * add a column to Table header object
	 *
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
 	 * @see Sylar_SimpleTableHeaderColumn
 	 * 
	 * @param Sylar_SimpleTableHeaderColumn $columnBean
	 * @return boolean
	 */
	public function addColumn(Sylar_SimpleTableHeaderColumn $columnBean){
		
		//TODO Controls on Column before insert
		$this->arrayData[] = $columnBean;
		$this->setColumns(count($this->getColumnsList()));
	}
	
	
	/**
	 * it return Column number $columnId
	 *
	 * @see Sylar_SimpleTableHeaderColumn
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @param int $columnId
	 * @return Sylar_SimpleTableHeaderColumn
	 */
	public function getColumnById($columnId){
		
		//TODO Controls on lenght of array and column number		
		return $this->arrayData[$columnId];
	}
	
	
	/**
	 * Check if header has columns
	 * verify if the table header has at least one column. Return false if there are no column.
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return boolean
	 */ 
	public function hasColumns(){
		if($this->getColumns()>0){
			return true;
		}else{
			return false;
		}
	}
	
	
	// Private Methods
	// --------------------------------
	
	/**
	 * reset header
	 * If is set destroy and reset the header information
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return void
	 */
	private function reset(){
		if(isset($this->arrayData)){
			unset($this->arrayData);
		}
		$this->arrayData = array();
		$this->setColumns(0);
	}
	
	
	/**
	 * Check if Column exists
	 * verify if a specified column num exists in the table header
	 *
	 * @param int $columnNum
	 * @return boolean
	 */ 
	private function columnExists($columnNum){
		try{
			if(!$this->hasColumns()){
				throw new ExceptionInSylar("Header has no columns. [Sylar_SimpleTable::columnExists]");
			}
			
			if( !array_key_exists($columnNum, $this->getColumnsList()) ){
				throw new ExceptionInSylar("Column number does not exists in table header (Request Column: ".$columnNum." Header Columns Tot: ".count($this->getColumnsList())."). [Sylar_SimpleTable::columnExists]");
			}
			return true;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}	
	
	
} 
 







/**
 * Header Single Column
 * It is information about a single column header. It contains informations about:
 * Column name
 * Column code
 * Column type
 * Column format type
 * Column description 
 * 
 * @see Sylar_SimpleTableHeader
 * 
 * @package Sylar
 * @version 1.0
 * @since 03/2008
 * 
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team 
 */
class Sylar_SimpleTableHeaderColumn{
	
	/**Unique code for column for example 'user_id' may be the same sql column name from query */
	private $columnCode;
	/** type of data contained in the column, for example: int, string, etc... */
	private $columnType;
	/** How the data must be format in the column. For example: valute, tel, mobile, email, web */
	private $columnFormatType;
	/** It's the name showed on the table header */
	private $columnName;
	/** The description ov column that may be displayed on tooltip for example */
	private $columnDesc;
	/** The column is hidden and not show in html rendering */
	private $fVisible;



	function __construct($columnCode, $columnName=null, $fVisible=true){
		
		if(!$columnCode){
			//TODO Exception ! Code must be set!
			
		}else{
			$this->setColumnCode($columnCode);
		}
		
		if(!is_null($columnName)){
			$this->setColumnName($columnName);			
		}
		
		$this->setColumnVisible($fVisible);
		
	}
	function __destruct(){
		// nothing to do at the moment
	}
	
	
	
	// Getter and Setter
	// --------------------------------
	public function setColumnCode($columnCode){
		$this->columnCode = $columnCode;
	}
	public function getColumnCode(){
		return $this->columnCode;
	}
	
	public function setColumnType($columnType){
		$this->columnType = $columnType;
	}
	public function getColumnType(){
		return $this->columnType;
	}
	
	public function setColumnFormatType($columnFormatType){
		$this->columnFormatType = $columnFormatType;
	}
	public function getColumnFormatType(){
		return $this->columnFormatType;
	}
	
	public function setColumnName($columnName){
		$this->columnName = $columnName;
	}
	public function getColumnName(){
		return $this->columnName;
	}
	
	public function setColumnDesc($columnDesc){
		$this->columnDesc = $columnDesc;
	}
	public function getColumnDesc(){
		return $this->columnDesc;
	}

	public function setColumnVisible($fVisible){
		$this->fHidden = $fVisible;
	}
	public function getColumnVisible(){
		return $this->fHidden;
	}	
	

	
	// Public methods
	// --------------------------------
	
	
}


 
?>