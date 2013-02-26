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


import('sylar.common.system.ConfigBox');
import('sylar.presentation.Format');
import('sylar.common.data.SimpleTable');
import('sylar.common.data.Pagination');

import('sylar.presentation.html.HtmlDiv');
import('sylar.presentation.html.components.Form');
import('sylar.presentation.html.components.FormInputCheckbox');
import('sylar.presentation.html.components.FormInputButton');


 
/**
 * Format Table list
 * 
 * This class format a Simple Table in an Html Table list
 * 
 * @see Sylar_SimpleTable
 * 
 * @package Sylar
 * @version 1.0
 * @since 02/ott/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 

class Sylar_TableList extends Sylar_Format{
	
	private $sTableId;
	private $sTitle;
	private $sSubTitle;
	private $oSimpleTable;	
	
	private $aButtons;					// Buttons list
	
	// This for pagination
	private $oPagination=null;			// Sylar_Pagination	
	
	// Functionality
	private $bEnableOrdering=true;
	private $bEnableColumnHeader=true;
	private $bEnablePaging=true;
	private $bEnableButtons=true;
	private $bEnableTopController=true;
	private $bEnableBottomController=true;
	private $bEnableSelector=true;
	private $sSelectorType="checkbox";
	
	
	function __construct($sTableId, Sylar_LocaleConfiguration $localeConf=null){
		parent::__construct($localeConf);
		
		if(!is_null($sTableId)){
			$this->setTableId($sTableId);
		}
		
		$this->aButtons = array();
		
	}
	function __destruct(){
		// nothing to do at the moment
	}
		
	//								 						   Setter and Getter
	//__________________________________________________________________________
	

	/**
	 * @return string
	 */
	public function getSelectorType() {
		return $this->sSelectorType;
	}
	
	/**
	 * @param string $sSelectorType may be checkbox or radio
	 */
	public function setSelectorType($sSelectorType) {
		if($sSelectorType!="checkbox" && $sSelectorType!="radio"){
			$sSelectorType = "checkbox";
		}
		$this->sSelectorType = $sSelectorType;
	}
	
	
	public function getTableId(){
		return $this->sTableId;
	}
	public function setTableId($sTableId){
		$this->sTableId = $sTableId;
	}	
	
	public function getTitle(){
		return $this->sTitle;
	}
	public function setTitle($sTitle){
		$this->sTitle = $sTitle;
	}	

	public function getSubTitle(){
		return $this->sSubTitle;
	}
	public function setSubTitle($sSubTitle){
		$this->sSubTitle = $sSubTitle;
	}
		
	/** @return Sylar_SimpleTable */
	public function getSimpleTable(){
		return $this->oSimpleTable;
	}
	/** @return Sylar_SimpleTable */
	public function setSimpleTable($oSimpleTable){
		$this->oSimpleTable = $oSimpleTable;
	}
	
	
	
	
	/** @return boolean */
	public function getColumnHeaderVisibility() {
		return $this->bEnableColumnHeader;
	}
	/** @param boolean $bEnabled */
	public function setColumnHeaderVisibility($bEnable) {
		$this->bEnableColumnHeader = $bEnable;
	}	
	
	/** @param boolean $bEnabled */
	public function setSelectorVisibility($bEnable) {
		$this->bEnableSelector = $bEnable;
	}
	/** @return boolean */
	public function getSelectorVisibility() {
		return $this->bEnableSelector;
	}
	
	/** @return boolean */
	public function getBottomControllerVisibility() {
		return $this->bEnableBottomController;
	}
	/** @param boolean $bEnabled */
	public function setBottomControllerVisibility($bEnable) {
		$this->bEnableBottomController = $bEnable;
	}
	
	/** @return boolean */
	public function getTopControllerVisibility() {
		return $this->bEnableTopController;
	}
	/** @param boolean $bEnabled */
	public function setTopControllerVisibility($bEnable) {
		$this->bEnableTopController = $bEnable;
	}
	
	/** @return boolean */
	public function getButtonsVisibility() {
		return $this->bEnableButtons;
	}	
	/** @param boolean $bEnabled */
	public function setButtonsVisibility($bEnable) {
		$this->bEnableButtons = $bEnable;
	}
	
	/** @return boolean */
	public function getOrderingVisibility() {
		return $this->bEnableOrdering;
	}	
	/** @param boolean $bEnabled */
	public function setOrderingVisibility($bEnable) {
		$this->bEnableOrdering = $bEnable;
	}
	
	/** @return boolean */
	public function getPaginationVisibility() {
		return $this->bEnablePaging;
	}	
	/** @param boolean $bEnabled */
	public function setPaginationVisibility($bEnable) {
		$this->bEnablePaging = $bEnable;
	}
	



	
	
	
	
	
	
	/** @return array */
	public function getButtons(){
		return $this->aButtons;
	}	
	
	
	
	public function isColumnHeaderEnabled(){
		return $this->bEnableColumnHeader;
	}
	public function isSelectorEnabled(){
		return $this->bEnableSelector;
	}
	public function isOrderingEnabled(){
		return $this->bEnableOrdering;
	}
	public function isTopControllerEnabled(){
		return $this->bEnableTopController;
	}
	public function isBottomControllerEnabled(){
		return $this->bEnableBottomController;
	}
	public function isButtonsEnabled(){
		return $this->bEnableButtons;
	}
	public function isPaginationEnabled(){
		return $this->bEnablePaging;
	}
	
	/**
	 * @return Sylar_Pagination
	 */
	public function getPagination() {
		return $this->oPagination;
	}
	/**
	 * @param Sylar_Pagination $oPagination
	 */
	public function setPagination(Sylar_Pagination $oPagination) {
		$this->oPagination = $oPagination;
	}

	
	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________

	
	public function addButton($id, $sText, $onClick){
		$button = new Sylar_FormInputButton($id, $id, $sText, $onClick);
		$button->setClass("sylarButtonSmall");
		$this->aButtons[] = $button;
	}
		
	
	/**
	 * return the Html source
	 * it return html code of entire object
	 * 
	 * @return string
	 */
	public function getHtmlSource(){
		return $this->render()->getHtmlSource();
	}
	
	
	/**
	 * Display the page
	 * it prints the object Html source on screen
	 * 
	 * @return void
	 */
	public function show(){
		$this->render()->show();
	}
	
	
	/**
	 * Convert in a DIV
	 * and returns the div contains the TableList
	 * 
	 * @return Sylar_HtmlDiv
	 */
	public function toDiv(){
		return $this->render();
	}	
	
	
	
	
	
	/**
	 * Fill the Html table 
	 * if $oSimpleTable is null it takes the table from the private objects 
	 * properties $this->oSimpleTable
	 * 
	 * @return Sylar_HtmlDiv
	 */
	public function fillTable(){
		
		
		$oSTable = $this->getSimpleTable();
		

		
		
		//Table start
		$result = "\n<table class='sylarTable' id='".$this->getTableId()."' TR='{$oSTable->getRows()}' TC='{$oSTable->getColumns()}'>";
			
			// Table Caption
			//$result .= "\n<CAPTION>Titolo: ".$sTable->getTableTitle()."</CAPTION>";
			
			// if enabled all Columns Header
			if($this->isColumnHeaderEnabled()){
				$result .= "\n<tr id=\"{$this->getTableId()}_HDR\">";
				
				if($this->isSelectorEnabled()){
					switch ($this->getSelectorType()) {
						case "radio":				// radio		
						$result .= "\n<th></th>";
						break;
						
						default:					// checkbox
							$result .= "\n<th><input id=\"{$this->getTableId()}_ALL_CHK\" type=\"checkbox\" ></th>";
						break;
					}					
				}
				
				for($i=0; $i<$oSTable->getColumnsHeader()->getColumns(); $i++){
					$tmp = "";
					if(!$oSTable->getColumnsHeader()->getColumnById($i)->getColumnVisible()){
						$tmp = "style='display:none;'";	
					}
					$result .= "\n<th id=\"{$this->getTableId()}_HDR_{$oSTable->getColumnsHeader()->getColumnById($i)->getColumnCode()}\" {$tmp}>{$oSTable->getColumnsHeader()->getColumnById($i)->getColumnName()}";
					if($this->isOrderingEnabled()){
						$result .= " &nbsp;<img src='".Sylar_ConfigBox::getSylarImgUrlPath()."TableList_OrderNone.gif'>";
					}
					$result .="</th>";
				}
				$result .= "\n</tr>";		
			}
			
			
			//It controls rows = 0
			if($oSTable->getRows() == 0){
				$result .= $this->provideNoRowsFound();
			}else{
					
				// All the rows with values
				for($i=0; $i<$oSTable->getRows(); $i++){
					$result .= "\n<tr id=\"{$this->getTableId()}_R{$i}\">";
					if($this->isSelectorEnabled()){
						switch ($this->getSelectorType()) {
							case "radio":	// radio
							$result .= "\n<td><input id=\"{$this->getTableId()}_R{$i}_RD\" name=\"{$this->getTableId()}_RD_SEL\" type=\"radio\" value=\"{$i}\"></td>";
							break;
							
							default:	// checkbox
								$result .= "\n<td><input id=\"{$this->getTableId()}_R{$i}_CHK\" type=\"checkbox\"></td>";
							break;
						}						
					}
					for($j=0; $j<$oSTable->getColumns(); $j++){
						$tmp = "";
						if(!$oSTable->getColumnsHeader()->getColumnById($j)->getColumnVisible()){
							$tmp = "style='display:none;'";	
						}
						$result .= "\n<td id=\"{$this->getTableId()}_R{$i}_{$oSTable->getColumnsHeader()->getColumnById($j)->getColumnCode()}\" {$tmp}>{$oSTable->getRow($i)->getColumnValue($j)}</td>";
					}				
					$result .= "\n</tr>";
				}
				
			}
		
		$result .= "\n</table>";
		
		
		
		$div = new Sylar_HtmlDiv($this->getTableId()."_TABLECONTAINER", $this->getTableId()."_TABLECONTAINER", "sylarTableContainer");
		$div->appendContent($result);
		
		
		return $div;
	}
	
	
	
	
	
	
	
	
	
	/**
	 * Make Pagination from simple data not from an object
	 *
	 * @param integer $iTotElem
	 * @param integer $iCurrPage
	 * @param integer $iElemInPage
	 * @return void
	 */	
	public function paginateFromRawData($iTotElem, $iCurrPage, $iElemInPage) {
		settype($iTotElem, "integer");
		settype($iCurrPage, "integer");
		settype($iElemInPage, "integer");
		
		$this->paginate(new Sylar_Pagination($iTotElem, $iCurrPage, $iElemInPage));
		
	}
	

	/**
	 * Make Pagination from simple data not from an object
	 *
	 * @param Sylar_Pagination $oPagination Object with all pagination data 
	 * @return void
	 */	
	public function paginate(Sylar_Pagination $oPagination) {
		
		$oPagination->paginate();
		
		$this->setPagination($oPagination);
	}	
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
	
	
	/**
	 * 
	 * @return Sylar_HtmlDiv
	 */
	protected function render(){
		$mainDiv = new Sylar_HtmlDiv($this->getTableId()."_MAIN", $this->getTableId()."_MAIN", "sylarTableMainContainer");
		
		// Manage Title
		if(!is_null($this->getTitle())){
			$appoDiv = new Sylar_HtmlDiv($this->getTableId()."_TITLE", $this->getTableId()."_TITLE", "sylarTableTitle");
			$appoDiv->appendContent($this->getTitle());
			$mainDiv->nestDiv($appoDiv);
		}

		// Manage Subtitle
		if(!is_null($this->getSubTitle())){
			$appoDiv = new Sylar_HtmlDiv($this->getTableId()."_SUBTITLE", $this->getTableId()."_SUBTITLE", "sylarTableSubTitle");
			$appoDiv->appendContent($this->getSubTitle());
			$mainDiv->nestDiv($appoDiv);
		}

		// Manage Top Controller
		if($this->isTopControllerEnabled()){
			$mainDiv->nestDiv($this->provideController("TOP"));
		}
		
		// Fill Table from SimpleTable
		$mainDiv->nestDiv($this->fillTable());
		
		// Manage Bottom Controller
			// Manage Top Controller
		if($this->isBottomControllerEnabled()){
			$mainDiv->nestDiv($this->provideController("BOTTOM"));
		}	
		
		return $mainDiv;
	}
	
	
	
	
	/** @return Sylar_HtmlDiv */
	protected function provideController($label){
		
		$tmpPaging = $this->providePagination();
		
		$tmpButtons = " Selected <span id=\"sylarSelectedItemsBottom\"><b>0</b> of 30</span> items.";
		
		
		$controllerDiv = new Sylar_HtmlDiv($this->getTableId()."_{$label}CONTROLLER", $this->getTableId()."_{$label}CONTROLLER", "sylarTableController");
		$buttonsDiv = new Sylar_HtmlDiv($this->getTableId()."_{$label}BUTTONS", $this->getTableId()."_{$label}BUTTONS", "sylarTableControllerSelector");
		$pagingDiv = new Sylar_HtmlDiv($this->getTableId()."_{$label}PAGING", $this->getTableId()."_{$label}PAGING", "sylarTableControllerPaging");
		
		
		//
		// Buttons
		//
		if($this->isButtonsEnabled()){
			$aButtons = $this->getButtons();
			for($i=0; $i<count($aButtons); $i++){
				$buttonsDiv->appendContent( $aButtons[$i]->getHtmlSource()."&nbsp;" );
			}				
			$buttonsDiv->appendContent($tmpButtons );
		}
		$controllerDiv->nestDiv($buttonsDiv);
		
		
		//
		// Paging
		//
		if($this->isPaginationEnabled()){
			$pagingDiv->appendContent( $tmpPaging );
		}
		$controllerDiv->nestDiv($pagingDiv);
		
		
		return $controllerDiv;
		
	}
	
	
	
	/** @return string */
	protected function provideNoRowsFound(){		
		return $this->provideMessageRow("No Rows Found");
	}
	
	
	/** @return string */
	protected function provideMessageRow($message){

		$colspan="";
		if($this->getSimpleTable()->getColumnsHeader()->getColumns() > 1){
			$colspan = "colspan=\"{$this->getSimpleTable()->getColumnsHeader()->getColumns()}\"";
		}
		
		$result = "\n<tr id=\"{$this->getTableId()}_R_MSG\">";
			$result .= "\n<td id=\"{$this->getTableId()}_C_MSG\" class=\"sylarNoRowFound\" {$colspan}> {$message} </td>";
		$result .= "\n</tr>";
		
		return $result;
	}

	
	/**
	 * It returns the pagination html code.
	 * If is not ok in the Pagination Object then it returns Paging disabled
	 * 
	 * @return string
	 */
	protected function providePagination() {
		
		try{
			
			//$tmpPaging  = "<input onclick=\"javascript:sylar_PageTables['{$this->getTableId()}'].goFirstPage();\" class=\"sylarButtonPaging\" type=\"button\" value=\"|&lt;&lt;\">";				
			//$tmpPaging .= "<input onclick=\"javascript:sylar_PageTables['{$this->getTableId()}'].goPreviousPage();\" class=\"sylarButtonPaging\" type=\"button\" value=\"&lt;\">"; 
			//$tmpPaging .= "<input onclick=\"javascript:sylar_PageTables['{$this->getTableId()}'].goNextPage();\" class=\"sylarButtonPaging\" type=\"button\" value=\"&gt;\">";
			//$tmpPaging .= "<input onclick=\"javascript:sylar_PageTables['{$this->getTableId()}'].goLastPage();\" class=\"sylarButtonPaging\" type=\"button\" value=\"&gt;&gt;|\">";
			
			if(!is_null($this->getPagination())){
				$jsUpdatePgStatus = "sylar_PageTables['{$this->getTableId()}'].refreshPagination({$this->getPagination()->getTotalPages()}, {$this->getPagination()->getCurrentPage()}, {$this->getPagination()->getElementsInPage()});";
			}
			
			
			// Go First
			$btnGF = new Sylar_FormInputButton(null, null, "|&lt;&lt;", "{$jsUpdatePgStatus} sylar_PageTables['{$this->getTableId()}'].goFirstPage();");
			$btnGF->setClass("sylarButtonPaging");

			
			// Go Previous
			$btnGP = new Sylar_FormInputButton(null, null, "&lt;", "{$jsUpdatePgStatus} sylar_PageTables['{$this->getTableId()}'].goPreviousPage();");
			$btnGP->setClass("sylarButtonPaging");
			
			// Go Next
			$btnGN = new Sylar_FormInputButton(null, null, "&gt;", "{$jsUpdatePgStatus} sylar_PageTables['{$this->getTableId()}'].goNextPage();");
			$btnGN->setClass("sylarButtonPaging");
			
			// Go Last
			$btnGL = new Sylar_FormInputButton(null, null, "&gt;&gt;|", "{$jsUpdatePgStatus} sylar_PageTables['{$this->getTableId()}'].goLastPage();");
			$btnGL->setClass("sylarButtonPaging");
			
			
			
			if(is_null($this->getPagination())){
				$btnGF->setDisabled(true);
				$btnGP->setDisabled(true);
				$btnGN->setDisabled(true);
				$btnGL->setDisabled(true);
				
				$pgIndexing =  " (--) ";	
			}else{
				
				// Controls on first page
				if($this->getPagination()->isFirstPage()){ 
					$btnGF->setDisabled(true); 
					$btnGP->setDisabled(true); 
				}
				
				// Controls on last page
				if($this->getPagination()->isLastPage()){ 
					$btnGN->setDisabled(true); 
					$btnGL->setDisabled(true); 
				}
				
				$pgIndexing = " (Pag <b>{$this->getPagination()->getCurrentPage()}</b> di {$this->getPagination()->getTotalPages()}) ";
			}
			
			return $btnGF->getHtmlSource().$btnGP->getHtmlSource().$pgIndexing.$btnGN->getHtmlSource().$btnGL->getHtmlSource();
			
		}catch(ExceptionInSylar $ex){
			throw $ex;
		}
		
		

		
	}
	
	
	
}
 
 
 
 
?>