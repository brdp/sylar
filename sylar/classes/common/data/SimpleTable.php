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
import('sylar.common.data.SimpleTableRow');

/**
 * SimpleData
 * It's a standard Table. A simple table with some information about data contained
 * It's used to swap data with databases by DataBase classes
 * 
 * the row must be an array indexed whit same header. For example
 * 
 * Table name: test
 * 			
 * TbHeader:	name		surname		phone		email
 * TbRow 0		Nik			Mallet		090909		nik@nik.ir	
 * TbRow 1		Bob			Bruk		0877689		bon@bob.com
 * TbRow ...
 * TbRow n		Tim			Ork			078	778		tim@tim.xx
 * 
 * Header info must be specified only one time and every row must be a Sylar_SimpleTableRow with an array 
 * 
 * @see Sylar_SimpleTableRow
 * @see Sylar_SimpleTableHeader
 * @see Sylar_SimpleTableHeaderColumn
 * 
 * @package Sylar
 * @version 1.0
 * @since 22/feb/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_SimpleTable extends Sylar_DataContainer{
	private $id;
	private $title;
	private $description;
	private $tbColumns;
	private $flagRowControl;
	
	/** Sylar_SimpleTableHeader that containes all informations about header, columns, ecc... */
	private $columnsHeader;
	
	/** the array that contains the rows as object Sylar_SimpleTableRow */
	private $arrayData;
	
	/**
	 * Constructor
	 * it sets the main params of object. comprise ID and Title
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return void
	 * 
	 * @param string $title
	 * @param string $id
	 */
	function __construct($title=false, $id=false){
		// call the parent class constructor
		parent::__construct();
		
		// Setting the ID
		if(!$id){
			$this->setTableId( uniqid('SylarId_', true) );
		}else{
			$this->setTableId( $id );
		}
		
		// Setting the Title
		if(!$title){
			$this->setTableTitle( uniqid('SylarTable_', true) );
		}else{
			$this->setTableTitle( $title );
		}
		
		// Set the row Control policy
		$this->setRowControls();
		
		// Start with empty header
		$this->setColumns(0);
		
		// reset datacontainers
		$this->resetHeader();
		$this->resetArrayData();
	}
	function __destruct(){
		// nothing to do at the moment
	}
	
	// Getter and Setter
	// --------------------------------
	
	public function setTableId($id){
		$this->id = $id;
	}
	public function getTableId(){
		return $this->id;
	}
	
	public function setTableTitle($titolo){
		$this->titolo = $titolo;
	}
	public function getTableTitle(){
		return $this->titolo;
	}

	public function setColumns($colNum){
		$this->tbColumns = $colNum;
	}
	public function getColumns(){
		return $this->tbColumns;
	}
	
	public function setTableDescription($desc){
		$this->description = $desc;
	}
	public function getTableDescription(){
		return $this->description;
	}
	
	/**
	 * Set controls on every Row
	 * if set true the object controls the row befor insert else it try to insert directly.
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return void
	 * @param boolean $control
	 */
	public function setRowControls($control=true){
		$this->flagRowControl = $control;
	}
	public function getRowControls(){
		return $this->flagRowControl;
	}
	
	
	
	
	// Public methods
	// --------------------------------
	
	
	/**
	 * Fill table data
	 * fill data in the object starting from array $arrayData
	 * it empty and reset the object data.
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
 	 * @todo To be done and test
 	 * 
	 * @return boolean
	 * @param array $arrayData
	 */
	public function fillDataFromArray($arrayData){
		
		//TODO must array of each row have the same key or the same number of elements? If yes, it must be implement
		try{
			if(is_array($arrayData)){
				$this->resetArrayData();
				foreach ($arrayData as $key => $value){
					if(is_array($value)){
						$this->addSimpleTableRow(new Sylar_SimpleTableRow($value));
					}else{
						throw new ExceptionInSylar("The array provided to key: ".$key." is not an array. [Sylar_SimpleTable::fillDataFromArray]");
					}
				}
			}else{
				throw new ExceptionInSylar("The array provided to fill Sylar_SimpleTableRow isn't an array.");
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Append row in table
	 * Row must be a Sylar_SimpleTableRow object, this method append it in the last position of table.
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return boolean
	 * @param Sylar_SimpleTableRow $tableRow
	 */
	public function addSimpleTableRow(Sylar_SimpleTableRow $tableRow){
		try{
			if($this->isRowControlsEnabled()){				
				if(!$this->rowFitInTable($tableRow)){
					return false;
				}
			}
			$this->arrayData[] = $tableRow;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
		
		return true;
	}
	
	
	/**
	 * Get row from table
	 * Return the Object row containet at row $rowID. Return false on error
	 *
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return Sylar_SimpleTableRow
	 * @param int $rowID
	 */
	public function getRow($rowID){
		try{
			if($this->getRows()>0 && array_key_exists($rowID, $this->arrayData)){
				return $this->arrayData[$rowID];
			}
			
			throw new ExceptionInSylar("Searched Row id: ".$rowID." does not exists in the Table. [Sylar_SimpleTable::getRow]");
		
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Numer of table rows
	 * Return the number of rows contained in the table. Return false on error.
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return int
	 */
	public function getRows(){
		try{
			if(is_array($this->arrayData) && count($this->arrayData)>0){
				return count($this->arrayData);
			}
			
			// throw new ExceptionInSylar("Table (name: ".$this->getTableTitle().") is empty or not sets. [Sylar_SimpleTable::getRows]");
			// TODO chose if return 0 or throw an exception
			return 0;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Table has row?
	 * It controls if table has row, return true if rows is > 0 false otherwise
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @see getRows()
	 * @return boolean
	 */
	public function hasRow(){
		if($this->getRows() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 * Set the header of table
	 * Set the information about table header into Table object.
	 * Usually the columnCode correspond to the column name in DB
	 * 
	 * @since 03/2008
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return void
	 * @param Sylar_SimpleTableHeader $tbHeader object that contain header of table
	 */
	public function setColumnsHeader(Sylar_SimpleTableHeader $tbHeader){
		
		//TODO Check the header befor insert
		// throw new ExceptionInSylar("The Header array info provided is not an array or is empty. [Sylar_SimpleTable::fillTableHeader]");
		$this->columnsHeader = $tbHeader;
		
		// refresh Table Columns
		$this->setColumns($tbHeader->getColumns());
	}
	
	
	/**
	 * Get Header
	 * Return an object that contain information about header of table
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return Sylar_SimpleTableHeader
	 */
	public function getColumnsHeader(){
		
		//TODO Check the header befor insert
		return $this->columnsHeader;
	}
		
	
	/**
	 * Reset table container
	 * if is set destroy it and reset the array data container
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
	 * Reset HeaderInfo
	 * It inizialize the container of table header information
	 *
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return void
	 */
	private function resetHeader(){
		if(isset($this->columnsHeader)){
			unset($this->columnsHeader);
		}
		$this->columnsHeader = new Sylar_SimpleTableHeader();
	}
	
	
	/**
	 * Check control
	 * It verify if the control on the rows is on return true, false otherwise.
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return boolean
	 */
	private function isRowControlsEnabled(){
		if(!$this->getRowControls()){
			return false;
		}
		return true;
	}
	
	
	/**
	 * Controls Row befor add it in Table
	 * It verify if the row is correct and can be added, if it is ok return true, false otherwise.
	 * 
	 * @since 22/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
	 * @return boolean
	 * @param Sylar_SimpleTableRow $tbRow row to add in table
	 */
	private function rowFitInTable(Sylar_SimpleTableRow $tbRow){ 
		try{
			if(!$tbRow->hasData()){
				throw new ExceptionInSylar("Error Adding Row in Table (name: ".$this->getTableTitle()."). Row is empty or not set. [Sylar_SimpleTable::rowFitInTable]");
			}
			
			if($this->getColumns() != $tbRow->getColumns()){
				throw new ExceptionInSylar("Error Adding Row in Table (name: ".$this->getTableTitle()."). Row columns number is different from Table Columns number. [Sylar_SimpleTable::rowFitInTable]");
			}
			return true;
		
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}	
	
	
	
}
 
 
?>