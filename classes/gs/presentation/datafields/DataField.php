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

 
/**
 * Abstract Class for DataField
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */


import('sylar.common.locale.Locale');
import('sylar.common.locale.Language');
 
import('sylar.presentation.html.HtmlDiv');



/**
 * Abstract class for all Data Fields components.
 * 
 * From this extends: 
 * GS_Email
 * GS_Valute
 * GS_Telephone
 * GS_WebUrl
 * GS_Integer
 * GS_Float
 * GS_PostalCode
 * 
 * @package Sylar
 * @version 1.0
 * @since 14/mag/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
abstract class GS_DataField {
	private $iFieldId;
	private $bIsRequired;
	private $bIsEnabled;
	
	// Sylar_HtmlDiv containers
	private $oMain;
	private $oLabel;	
	private $oInput;
	private $oActions;
	private $oMesg;
	
	// Div visibility
	private $bMainVisible;
	private $bLabelVisible;	
	private $bInputVisible;
	private $bActionsVisible;
	private $bMesgVisible;	
	
	
	function __construct($sFieldId, $bRequired=false, Sylar_LocaleConfiguration $localeConf=null){
		$this->setId($sFieldId);
		$this->setRequired($bRequired);
		
		if(is_null($localeConf)){
			/** 
			 * system locale
			 * an objet to use as default sylar Locale Config
			 * 
			 * @see sylar.php
			 * 
			 */
			$localeConf = new Sylar_LocaleConfiguration(Sylar_ConfigBox::getDefaultLocaleKey());
		}
		
		
		$this->initialize();
	}
	
	
	function __destruct(){
		// nothing to do at the moment
		parent::__destruct();
	}


	//								 				   Getter and Setter Methods
	//__________________________________________________________________________
	
	public function setId($sId){
		$this->sFieldId = $sId;
	}
	/** @return string */
	public function getId(){
		return $this->sFieldId;
	}
	
	
	public function setRequired($bRequired){
		$this->bIsRequired = $bRequired;
	}
	public function setAsRequired(){
		$this->setRequired(true);
	}
	public function setAsUnrequired(){
		$this->setRequired(false);
	}
	/** @return string */
	public function isRequired(){
		return $this->bIsRequired;
	}	
	
	
	
	public function setMain(Sylar_HtmlDiv $oMain){
		$this->oMain = $oMain;
	}
	/** @return Sylar_HtmlDiv */
	public function getMain(){
		return $this->oMain;
	}
		
	public function setLabel(Sylar_HtmlDiv $oLabel){
		$this->oLabel = $oLabel;
	}
	/** @return Sylar_HtmlDiv */
	public function getLabel(){
		return $this->oLabel;
	}
	
	public function setInput(Sylar_HtmlDiv $oInput){
		$this->oInput = $oInput;
	}
	/** @return Sylar_HtmlDiv */
	public function getInput(){
		return $this->oInput;
	}	
	
	public function setActions(Sylar_HtmlDiv $oActions){
		$this->oActions = $oActions;
	}
	/** @return Sylar_HtmlDiv */
	public function getActions(){
		return $this->oActions;
	}
	
	public function setMesg(Sylar_HtmlDiv $oMesg){
		$this->oMesg = $oMesg;
	}
	/** @return Sylar_HtmlDiv */
	public function getMesg(){
		return $this->oMesg;
	}
	
	
	//								 							  Public Methods
	//__________________________________________________________________________
	

	/**
	 * return the Htmldiv Object
	 * 
	 * @return Sylar_HtmlDiv
	 */
	abstract public function getField();
	
	
	
	
	
	
	
	
	/**
	 * set the content of Label DIV in the tag <label></label>
	 * For example: <label id="nameL" for="name">Name</label>
	 * 
	 * @param string $sHtmlContent
	 * @return void
	 */
	public function setLabelContent($sHtmlContent){
		$sHtmlContent = "<label id=\"{$this->getId()}_L\" for=\"{$this->getId()}\">{$sHtmlContent}</label>";
		$this->getLabel()->appendContent($sHtmlContent);
	}
	
	/**
	 * set the content of Input DIV
	 * 
	 * @param string $sHtmlContent
	 * @return void
	 */
	public function setInputContent($sHtmlContent){
		$this->getInput()->appendContent($sHtmlContent);
	}

	/**
	 * set the content of Actions DIV
	 * 
	 * @param string $sHtmlContent
	 * @return void
	 */	
	public function setActionsContent($sHtmlContent){
		$this->getActions()->appendContent($sHtmlContent);
	}

	/**
	 * set the content of Message DIV
	 * 
	 * @param string $sHtmlContent
	 * @return void
	 */	
	public function setMesgContent($sHtmlContent){
		$this->getMesg()->appendContent($sHtmlContent);
	}
	
	
	
	
	
	
	public function setVisible($sDivCode){
		switch ($sDivCode) {
			case "Main":
				$this->bMainVisible = true;
				break;
			
			case "Label":
				$this->bLabelVisible = true;
				break;
			
			case "Input":
				$this->bInputVisible = true;
				break;
			
			case "Actions":
				$this->bActionsVisible = true;
				break;
			
			case "Mesg":
				$this->bMesgVisible = true;
				break;
			
			case "*":
				$this->bMainVisible = true;	
				$this->bLabelVisible = true;
				$this->bInputVisible = true;
				$this->bActionsVisible = true;
				$this->bMesgVisible = true;	
				break;	
		}
		
	}
	public function setInvisible($sDivCode){
		switch ($sDivCode) {
			case "Main":
			$this->bMainVisible = false;
			break;
			
			case "Label":
			$this->bLabelVisible = false;
			break;
			
			case "Input":
			$this->bInputVisible = false;
			break;
			
			case "Actions":
			$this->bActionsVisible = false;
			break;
			
			case "Mesg":
			$this->bMesgVisible = false;
			break;
			
			case "*":
			$this->bMainVisible = false;	
			$this->bLabelVisible = false;
			$this->bInputVisible = false;
			$this->bActionsVisible = false;
			$this->bMesgVisible = false;	
			break;
		}	
	}
	public function isVisible($sDivCode){
		switch ($sDivCode) {
			case "Main":
				return $this->bMainVisible;
			
			case "Label":
				return $this->bLabelVisible;
			
			case "Input":
				return $this->bInputVisible;
			
			case "Actions":
				return $this->bActionsVisible;
			
			case "Mesg":
				return $this->bMesgVisible;
		}
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________

	
	/**
	 * Inizialize all Div
	 *
	 * It creates all needed Div
	 */
	protected function initialize(){
		$this->setMain( new Sylar_HtmlDiv("sylarFrmFieldMain_{$this->getId()}", "sylarFrmFieldMain_{$this->getId()}", "sylarFrmFieldMain") );
		$this->setLabel( new Sylar_HtmlDiv("sylarFrmFieldLabel_{$this->getId()}", "sylarFrmFieldLabel_{$this->getId()}", "sylarFrmFieldLabel") );	
		$this->setInput( new Sylar_HtmlDiv("sylarFrmFieldInput_{$this->getId()}", "sylarFrmFieldInput_{$this->getId()}", "sylarFrmFieldInput") );
		$this->setActions( new Sylar_HtmlDiv("sylarFrmFieldActions_{$this->getId()}", "sylarFrmFieldActions_{$this->getId()}", "sylarFrmFieldActions") );
		$this->setMesg( new Sylar_HtmlDiv("sylarFrmFieldMesg_{$this->getId()}", "sylarFrmFieldMesg_{$this->getId()}", "sylarFrmFieldMesg") );
		
		$this->setInvisible("*");
		$this->setVisible("Main");
		$this->setVisible("Label");
		$this->setVisible("Input");
	}
	
	/**
	 * Prepare Main Div
	 *
	 */
	protected function pack(){
		
		// Set all div visibility
		if(!$this->isVisible("Main")) { 
			$this->getMain()->setStyle("display:none;");
		}
		if(!$this->isVisible("Label")) { 
			$this->getLabel()->setStyle("display:none;");
		}
		if(!$this->isVisible("Input")) { 
			$this->getInput()->setStyle("display:none;");
		}
		if(!$this->isVisible("Actions")) { 
			$this->getActions()->setStyle("display:none;");
		}
		if(!$this->isVisible("Mesg")) { 
			$this->getMesg()->setStyle("display:none;");
		}
		
		// Nest all div in main div
		$this->getMain()->nestDiv($this->getLabel());
		$this->getMain()->nestDiv($this->getInput());
		$this->getMain()->nestDiv($this->getActions());
		$this->getMain()->nestDiv($this->getMesg());
		
	}
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________

	
	
}
 
 
?>