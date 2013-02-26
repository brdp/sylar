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

 

import('sylar.presentation.Format');


/**
 * Main Html Format Class
 * 
 * This class is extended from various Html Sylar Classes and collect 
 * common method uses to formato HTML source
 * 
 * @package Sylar
 * @version 1.0
 * @since 03/apr/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_Html extends Sylar_Format{
	
	// Tag Attributes
	private $aAttributes;
	
	// Tag Attributes without names for example checked, selected, disabled, etc...
	private $aNoNameAttributes;
	
	// All required Sylar javascript files by this tag
	private $aRequiredSylarJsFiles;	
	// All required Sylar css files by this tag
	private $aRequiredSylarCssFiles;	
	
	// All required Application javascript files by this tag
	private $aRequiredAppJsFiles;	
	// All required Application css files by this tag
	private $aRequiredAppCssFiles;		
	
	
	
	function __construct(){
		$this->aAttributes = array();
		$this->aNoNameAttributes = array();
		
		$this->aRequiredSylarJsFiles = array();
		$this->aRequiredSylarCssFiles = array();
		
		$this->aRequiredAppJsFiles = array();
		$this->aRequiredAppCssFiles = array();
	}
	function __destruct(){
		// nothing to do at the moment
	}
		
	//								 							  Public Methods
	//__________________________________________________________________________
	

	/**
	 * Add a Sylar Required Css file in list
	 * The list is an hash with as Value the path and file for example: http://domain/folder/test.css and as key the md5 of value
	 * 
	 * @param string $sRequiredCssFiles
	 * @return void
	 */
	public function addRequiredSylarCssFiles($sRequiredCssFiles) {
		$this->aRequiredSylarCssFiles[md5($sRequiredCssFiles)] = $sRequiredCssFiles;
	}		
	/**
	 * Return the list of Sylar Requireded Css files
	 * 
	 * @return array
	 */
	public function getRequiredSylarCssFiles() {
		return $this->aRequiredSylarCssFiles;
	}	
	
	
	/**
	 * Add a Sylar Required Javascript file in list
	 * The list is an hash with as Value the path and file for example: http://domain/folder/test.js and as key the md5 of value
	 * 
	 * @param string $sRequiredJsFiles
	 * @return void
	 */
	public function addRequiredSylarJsFiles($sRequiredJsFiles) {
		$this->aRequiredSylarJsFiles[md5($sRequiredJsFiles)] = $sRequiredJsFiles;
	}		
	/**
	 * Return the list of Sylar Requireded Css files
	 * 
	 * @return array
	 */
	public function getRequiredSylarJsFiles() {
		return $this->aRequiredSylarJsFiles;
	}
	
	
	
	/**
	 * Add a Application Required Css file in list
	 * The list is an hash with as Value the path and file for example: http://domain/folder/test.css and as key the md5 of value
	 * 
	 * @param string $sRequiredCssFiles
	 * @return void
	 */
	public function addRequiredAppCssFiles($sRequiredCssFiles) {
		$this->aRequiredAppCssFiles[md5($sRequiredCssFiles)] = $sRequiredCssFiles;
	}		
	/**
	 * Return the list of Application Requireded Css files
	 * 
	 * @return array
	 */
	public function getRequiredAppCssFiles() {
		return $this->aRequiredAppCssFiles;
	}	
	
	
	/**
	 * Add a Application Required Javascript file in list
	 * The list is an hash with as Value the path and file for example: http://domain/folder/test.js and as key the md5 of value
	 * 
	 * @param string $sRequiredJsFiles
	 * @return void
	 */
	public function addRequiredAppJsFiles($sRequiredJsFiles) {
		$this->aRequiredAppJsFiles[md5($sRequiredJsFiles)] = $sRequiredJsFiles;
	}		
	/**
	 * Return the list of Application Required Css files
	 * 
	 * @return array
	 */
	public function getRequiredAppJsFiles() {
		return $this->aRequiredAppJsFiles;
	}
	
	
	
	/**
	 * Add an attribute name and value into the tag attribute list
	 * 
	 * @return void
	 * @param string $sAttributeName name
	 * @param string $sAttributeValue value
	 * 
	 * @see $this->aAttributes
	 */
	public function setAttribute($sAttributeName, $sAttributeValue){
		$this->aAttributes[$sAttributeName] = $sAttributeValue;
	}


	/**
	 * Add a NoName attribute value into the tag attribute list. 
	 * Fore example DISABLED, CHECKED, etc...
	 * 
	 * @return void
	 * @param string $sAttributeValue value
	 * 
	 * @see $this->aNoNameAttributes
	 */
	public function setAttributeWithoutName($sAttributeValue){
		$this->aNoNameAttributes[$sAttributeValue] = $sAttributeValue;
	}	
	

	/**
	 * Return attribute value from the internal list. Null if doesn't exists
	 * 
	 * @return void
	 * @param string $sAttributeName name
	 * 
	 * @see $this->aAttributes
	 */	
	public function getAttribute($sAttributeName){
		if(array_key_exists($sAttributeName, $this->aAttributes)){
			return $this->aAttributes[$sAttributeName];
		}
		return null;
	}	

	
	/**
	 * Return attribute value from the internal list. Null if doesn't exists
	 * Used for attributes like CHECKED, SELECTED, etc...
	 * 
	 * @return void
	 * @param string $sAttributeValue value
	 * 
	 * @see $this->aAttributes
	 */	
	public function getAttributeWithoutName($sAttributeValue){
		if(array_key_exists($sAttributeValue, $this->aNoNameAttributes)){
			return $this->aNoNameAttributes[$sAttributeValue];
		}
		return null;
	}
		
	
	/**
	 * Remove an attribute from the internal list. 
	 * 
	 * @param string $sAttributeName name
	 * 
	 * @see $this->aAttributes
	 */	
	public function removeAttribute($sAttributeName){
		if(array_key_exists($sAttributeName, $this->aAttributes)){
			unset($this->aAttributes[$sAttributeName]);
		}
	}	
	

	/**
	 * Remove an attribute from the internal list. 
	 * Used for attributes like CHECKED, SELECTED, etc...
	 * 
	 * @param string $sAttributeValue value
	 * 
	 * @see $this->aNoNameAttributes
	 */	
	public function removeAttributeWithoutName($sAttributeValue){
		if(array_key_exists($sAttributeValue, $this->aNoNameAttributes)){
			unset($this->aNoNameAttributes[$sAttributeValue]);
		}
	}	
	

	/**
	 * Return the Tag HTML code with all attribute contained into the internal list
	 * 
	 * @return void
	 * @param string $sTag Tag name for example TABLE, DIV, etc...
	 * @param boolean $bInLineClose if is true the method will close the tag in line for example: <br/> or <input type... /> else will not close <br> or <input type...>
	 * 
	 * @see $this->aAttributes
	 */	
	public function provideTagWithAttributes($sTag, $bInLineClose=false){
		return Sylar_Html::fillTagAttributes($sTag, $this->aAttributes, $this->aNoNameAttributes, $bInLineClose);
	}
	
	
	/**
	 * Fill Html Attributes in Tag
	 * It generate the HTML tag $sTagStart with all attributes secified in the array $aAttributes
	 * The array is formatted like Key=>Value, Key is the attribute name and Value is the value of attribute. 
	 * It ignores all null data contained in the attributes array. 
	 * 
	 * For example:
	 * $sTagStart = "div";
	 * $aAttributes = array("id"=>"My_ID", "class"=>"My_CSS_Class");
	 * 
	 * calling the method:
	 * fillTagAttributes($sTagStart, $aAttributes)
	 * it returns a string thath contain: <div id="My_ID" class="My_CSS_Class">
	 * 
	 * @return string
	 * @param string $sTagStart The begin of the tag for example: script or div without '<'
	 * @param array $aAttributes An array Key=>Value to insert as attributes in the Tag.
	 * @param array $aNoNameAttributes An array Key=>Value to insert as attributes without name in the Tag, like DISABLED, CHECKED, SELECTED, etc...
	 * @param boolean $bInLineClose if is true the method will close the tag in line for example: <br/> or <input type... /> else will not close <br> or <input type...>
	 */
	public static function fillTagAttributes($sTagStart, $aAttributes, $aNoNameAttributes=null, $bInLineClose=false){
		try{
			if(is_null($sTagStart) || strlen(str_replace(" ", "",$sTagStart))==0){
				throw new ExceptionInSylar("HTML TAG is not declared. [Sylar_Html::fillTagAttributes]");
			}
			
			
			$sTagStart = "<".$sTagStart;
			
			// Attribute Tag with NAME
			if(!is_null($aAttributes) && is_array($aAttributes)){
				foreach ($aAttributes as $k => $v) {
					if(!is_null($v)){
						$sTagStart .= " ".$k."=\"".$v."\"";
					}
				}
			}
			
			// Attribute Tag without NAME
			if(!is_null($aNoNameAttributes) && is_array($aNoNameAttributes)){
				foreach ($aNoNameAttributes as $k => $v) {
					if(!is_null($v)){
						$sTagStart .= " {$v}";
					}
				}
			}
			
			// Sould close the tag or not?    ">" or "/>" ?
			$sTagStart .= (($bInLineClose)?" /":" ").">";
					
			return $sTagStart;
		
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
		
	//								 							 Private Methods
	//__________________________________________________________________________
	

	//								 						   Protected Methods
	//__________________________________________________________________________
	
	
	/**
	 * @param array $aRequiredAppCssFiles
	 */
	protected function setRequiredAppCssFiles($aRequiredAppCssFiles) {
		$this->aRequiredAppCssFiles = $aRequiredAppCssFiles;
	}
	
	/**
	 * @param array $aRequiredAppJsFiles
	 */
	protected function setRequiredAppJsFiles($aRequiredAppJsFiles) {
		$this->aRequiredAppJsFiles = $aRequiredAppJsFiles;
	}
	
	/**
	 * @param array $aRequiredSylarCssFiles
	 */
	protected function setRequiredSylarCssFiles($aRequiredSylarCssFiles) {
		$this->aRequiredSylarCssFiles = $aRequiredSylarCssFiles;
	}
	
	/**
	 * @param array $aRequiredSylarJsFiles
	 */
	protected function setRequiredSylarJsFiles($aRequiredSylarJsFiles) {
		$this->aRequiredSylarJsFiles = $aRequiredSylarJsFiles;
	}
	
	
	
	
	/**
	 * Return the Tag HTML code with all attribute contained into the internal list
	 * 
	 * @return void
	 * @param string $sTag Tag name for example TABLE, DIV, etc...
	 */	
	protected function mergeRequiredSylarJsFiles($aRequiredArray){
		$this->setRequiredSylarJsFiles( array_merge($this->getRequiredSylarJsFiles(), $aRequiredArray) );
	}
	protected function mergeRequiredSylarCssFiles($aRequiredArray){
		$this->setRequiredSylarCssFiles( array_merge($this->getRequiredSylarCssFiles(), $aRequiredArray) );
	}
	protected function mergeRequiredAppJsFiles($aRequiredArray){
		$this->setRequiredAppJsFiles( array_merge($this->getRequiredAppJsFiles(), $aRequiredArray) );
	}
	protected function mergeRequiredAppCssFiles($aRequiredArray){
		$this->setRequiredAppCssFiles( array_merge($this->getRequiredAppCssFiles(), $aRequiredArray) );
	}
	
	
	
	
	
	
}


?>