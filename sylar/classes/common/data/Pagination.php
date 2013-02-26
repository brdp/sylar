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



/**
 * Paginate
 * 
 * Class used to paginate results
 * 
 * @package Sylar
 * @version 1.0
 * @since 05/mar/2009
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
 
Class Sylar_Pagination{
 	private $elementsInPage;
 	private $totalElements;
 	
 	private $totalPages;
 	private $currentPage;
 	private $nextPage;
 	private $previousPage;	
 	
 	
 	private $orderBy;
 	private $orderDir;
 	
 	
 	
  	function __construct($totElements=0, $currentPage=1, $pgElements=30){

  		try{
  		  	$this->setElementsInPage($pgElements);
	  		$this->setCurrentPage($currentPage);
	  		$this->setTotalElements($totElements);	
		}catch(ExceptionInSylar $ex){
			throw $ex;
		}  		  		
  		
	}
	
	function __destruct(){
		// nothing to do at the moment
	}
		
	//								 				   Getter and setter Methods
	//__________________________________________________________________________		
	

	public function getCurrentPage() {
		return $this->currentPage;
	}
	
	public function getElementsInPage() {
		return $this->elementsInPage;
	}
	
	public function getNextPage() {
		return $this->nextPage;
	}
	
	public function getOrderBy() {
		return $this->orderBy;
	}
	
	public function getOrderDir() {
		return $this->orderDir;
	}
	
	public function getPreviousPage() {
		return $this->previousPage;
	}
	
	public function getTotalElements() {
		return $this->totalElements;
	}
	
	public function getTotalPages() {
		return $this->totalPages;
	}
	
	
	
	
	
	public function setCurrentPage($currentPage) {
		settype($currentPage, "integer");
		$this->currentPage = $currentPage;
	}
	
	public function setElementsInPage($elementsInPage) {
		settype($elementsInPage, "integer");
		$this->elementsInPage = $elementsInPage;
	}
	
	public function setNextPage($nextPage) {
		settype($nextPage, "integer");
		$this->nextPage = $nextPage;
	}
	
	public function setOrderBy($orderBy) {
		$this->orderBy = $orderBy;
	}
	
	public function setOrderDir($orderDir) {
		$this->orderDir = $orderDir;
	}
	
	public function setPreviousPage($previousPage) {
		settype($previousPage, "integer");
		$this->previousPage = $previousPage;
	}
	
	public function setTotalElements($totalElements) {
		settype($totalElements, "integer");
		$this->totalElements = $totalElements;
	}
	
	public function setTotalPages($totalPages) {
		settype($totalPages, "integer");
		$this->totalPages = $totalPages;
	}


	
	
	
	
	

	
	//								 							  Public Methods
	//__________________________________________________________________________	
	
	
	/**
	 * Run the pagination calc
	 *
	 * @param int $pg actual page
	 */
	public function paginate($pg=null){
		try{
			if(!is_null($pg) && $pg>=0){
				$this->setCurrentPage($pg);
			}
			
			$this->calculatePagesNumber();
			//$this->calculateFirstElementInPage($pg);
			$this->calculateNextPage();
			$this->calculatePreviousPage();
			
			// Page 0 means LAST PAGE!
			if($this->getCurrentPage()==0){
				$this->setCurrentPage($this->getTotalPages());
			}
			
			
			
		}catch(ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	
	/** @return boolean */
	public function isLastPage() {
		if($this->getCurrentPage() == $this->getTotalPages()){ return true; }
		return false;
	}
	
	/** @return boolean */
	public function isFirstPage() {
		if($this->getCurrentPage() == 1){ return true; }
		return false;
	}
	
	

	
	
	//								 						   Protected Methods
	//__________________________________________________________________________	
	


	
	
	

	
	
	//								 						     Private Methods
	//__________________________________________________________________________
		
	/**
	 * calculates and sets the pages number
	 *
	 * @return void
	 */
 	private function calculatePagesNumber() {
		try{
			
			if($this->getTotalElements()<=0){
				return 1;
			}
			
			if(is_null($this->getTotalElements())){
				throw new ExceptionInSylar("Paging Error. Total elements not set.", 10035);
			}
			
			if(is_null($this->getElementsInPage()) || $this->getElementsInPage()<1 ){
				throw new ExceptionInSylar("Paging Error. Element in Page not set or zero.", 10034);
			}			
						
			$this->setTotalPages( ceil($this->getTotalElements()/$this->getElementsInPage()) );
			
			
		}catch(ExceptionInSylar $ex){
			throw $ex;
		}
	}	
	
	
	/**
	 * It calculates the first element of the page starting from 0
	 *
	 * @return int
	 */
 	private function calculateFirstElementInPage($pg=null) {
		try{

			if(!is_null($pg)){ $this->setCurrentPage($pg); }
			
			if(is_null($this->getCurrentPage()) || $this->getCurrentPage()<1 ){
				throw new ExceptionInSylar("Paging Error. Page not set or zero.", 10033);
			}
			
			if(is_null($this->getElementsInPage()) || $this->getElementsInPage()<1 ){
				throw new ExceptionInSylar("Paging Error. Element in Page not set or zero.", 10034);
			}
			
						
		}catch(ExceptionInSylar $ex){
			throw $ex;
		}
	}		
	
	
	/**
	 * It calculates and set the value of next page
	 * It set null if out of range
	 * 
	 * @return void
	 */
	private function calculateNextPage(){
		if($this->getCurrentPage() == ($this->getTotalPages()-1) ){
			$this->setNextPage(null);
		}else{
			$this->setNextPage($this->getCurrentPage()+1);
		}
	}
	
	/**
	 * It calculates and set the value of previous page
	 * It set null if out of range
	 * 
	 * @return void
	 */	
	private function calculatePreviousPage(){
		if($this->getCurrentPage() <= 1 ){
			$this->setPreviousPage(null);
		}else{
			$this->setPreviousPage( $this->getCurrentPage()-1 );
		}
	}
	
}


 
 
 
?>