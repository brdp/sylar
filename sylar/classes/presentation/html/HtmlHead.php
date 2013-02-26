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
import('sylar.presentation.html.Html');



/**
 * Html Head
 * 
 * It manage the <head> of html page
 * 
 * @package Sylar
 * @version 1.0
 * @since 31/mar/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class Sylar_HtmlHead extends Sylar_Html{
	
	// Html Page <TITLE>
	private $sTitle;
	
	// All javascript file link
	private $aJsScriptLink;
	
	// All floating javascript scripts to insert in the head tag
	private $aFloatingJsScript;
	
	// All links to CSS file Style
	private $aStyleLink;
	
	// All floating Style declaration to insert in the head tag
	private $aFloatingStyle;
	
	// All html meta tag 
	private $aMetaTag;
	
	// Url root for application css
	private $sAppCssUrlRoot;
	
	// Url root for application javascript
	private $sAppJsUrlRoot;
	
	// Eventually custom tag
	private $aCustomTag;	
	
	function __construct($sTitle=null){
		
		if(!is_null($sTitle)){
			$this->setPageTitle($sTitle);
		}
		
		// Prepare array
		$this->aJsScriptLink = array();			
		$this->aFloatingJsScript= array();		
		$this->aStyleLink = array();			
		$this->aFloatingStyle = array();	
		$this->aMetaTag = array();		
		$this->aCustomTag = array();		
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	
	// 														   Setter and Getter
	//__________________________________________________________________________
	
	public function setAppCssUrlRoot($sAppCssUrlRoot){
		$this->sAppCssUrlRoot = $sAppCssUrlRoot;
	}
	public function getAppCssUrlRoot(){
		return $this->sAppCssUrlRoot;
	}
	
	public function setAppJsUrlRoot($sAppJsUrlRoot){
		$this->sAppJsUrlRoot = $sAppJsUrlRoot;
	}
	public function getAppJsUrlRoot(){
		return $this->sAppJsUrlRoot;
	}
	
	
	

	//								 							  Public Methods
	//__________________________________________________________________________

	
	/**
	 * Set the Title of HTML Page included html tag <TITLE>
	 *
	 * @return void
	 * @param string $sTitle is the title without html tag
	 */
	public function setPageTitle($sTitle){
		$this->sTitle = "<title>".$sTitle."</title>";
	}	
	public function getPageTitle(){
		return $this->sTitle;
	}
	
	
	
	/**
	 * Prepare <META> html Tag
	 * it prepares and store in the object the tag HTML <META> with 
	 * attributes value passed as parameters. Results is something like:
	 * <meta http-equiv="pragma" content="no-cache">
	 * <meta name="Author" content="pippo"> 
	 *
	 * @return void
	 * @param string $sContent
	 * @param string $sName
	 * @param string $sHttpEquiv
	 */
	public function addMetaTag($sContent, $sName=null, $sHttpEquiv=null ){
		$aAttributes = array(	"name"=>$sName, 
								"http-equiv"=>$sHttpEquiv, 
								"content"=>$sContent
							);
			
		$this->aMetaTag[] = parent::fillTagAttributes("meta", $aAttributes);
	}
	
	
	/**
	 * Prepare <SCRIPT> Html tag from Sylar default repository
	 * it prepare the statment that includes js in html <script SRC='...'>...
	 * The statment will be saved in the object.
	 * An example of statment is:
	 * <script src="sylar/javascript/mainGiano.js" type="text/javascript" charset="UTF-8"></script>
	 *
	 * @see addApplicationJavascript
	 * 
	 * @return void
	 * @param string $sScriptFile
	 * @param string $sCharset
	 */
	public function addSylarJavascript($sScriptFile, $sCharset=null){
		if(is_null($sCharset)){
			$sCharset = Sylar_ConfigBox::getDefaultCharset();
		}
		
		$aAttributes = array(	"src"=>Sylar_ConfigBox::getSylarJsUrlPath().$sScriptFile,
								"type"=>"text/javascript", 
								"charset"=>$sCharset
							);		
							
		$this->aJsScriptLink[] = parent::fillTagAttributes("script", $aAttributes)."</script>";
	}
	
	
	/**
	 * Prepare <SCRIPT> Html tag from Application default repository
	 * it prepare the statment that includes js in html <script SRC='...'>...
	 * The statment will be saved in the object.
	 * An example of statment is:
	 * <script src="app/javascript/mainGiano.js" type="text/javascript" charset="UTF-8"></script>
	 *
	 * @see addSylarJavascript
	 * 
	 * @return void
	 * @param string $sScriptFile
	 * @param string $sCharset
	 */
	public function addApplicationJavascript($sScriptFile, $sCharset=null){
		if(is_null($sCharset)){
			$sCharset = Sylar_ConfigBox::getDefaultCharset();
		}
		
		$aAttributes = array(	"src"=>$this->getAppJsUrlRoot().$sScriptFile,
								"type"=>"text/javascript", 
								"charset"=>$sCharset
							);	
								
		$this->aJsScriptLink[] = parent::fillTagAttributes("script", $aAttributes)."</script>";
	}
	

	/**
	 * it prepares floating JS script.
	 * it prepares and stores in the object a js script to include between the tag <SCRIPT>. For example:
	 * <script>
	 * 	var i=100;
	 *  for (j=0; j<i; j++){
	 * 		etc...
	 * </script>
	 * 
	 * @return void
	 * @param string $sScriptFile
	 * @param string $sCharset
	 */	
	public function addFloatingJsScript($sScript, $sCharset=null){
		if(is_null($sCharset)){
			$sCharset = Sylar_ConfigBox::getDefaultCharset();
		}
		
		if($sScript){
			$this->aFloatingJsScript[] = "<script type=\"text/javascript\" charset=\"".$sCharset."\">".$sScript."</script>";
		}
	}
	
	
	/**
	 * Prepare and store <Style> to include Sylar css
	 * It prepares and stores in the object the html tag needed to include a CSS file. 
	 * For example: 
	 * <link rel="stylesheet" href="/sylar/layouts/default/css/mainGiano.css" type="text/css" charset="UTF-8">
	 *
	 * @see addApplicationStyle
	 * 
	 * @return void
	 * @param string $sStyleFile
	 * @param string $sCharset
	 */
	public function addSylarStyle($sStyleFile, $sCharset=null){
		if(is_null($sCharset)){
			$sCharset = Sylar_ConfigBox::getDefaultCharset();
		}
		
		$aAttributes = array(	"rel"=>"stylesheet",
								"href"=>Sylar_ConfigBox::getSylarCssUrlPath().$sStyleFile, 
								"type"=>"text/css", 
								"charset"=>$sCharset
							);	
								
		$this->aStyleLink[] = parent::fillTagAttributes("link", $aAttributes);
	}


	/**
	 * Prepare and store <Style> to include Application css
	 * It prepares and stores in the object the html tag needed to include a CSS file. 
	 * For example: 
	 * <link rel="stylesheet" href="/app/layouts/default/css/mainGiano.css" type="text/css" charset="UTF-8">
	 *
	 * @see addSylarStyle
	 * 
	 * @return void
	 * @param string $sStyleFile
	 * @param string $sCharset
	 */	
	public function addApplicationStyle($sStyleFile, $sCharset=null){
		if(is_null($sCharset)){
			$sCharset = Sylar_ConfigBox::getDefaultCharset();
		}
		
		$aAttributes = array(	"rel"=>"stylesheet",
								"href"=>$this->getAppCssUrlRoot().$sStyleFile, 
								"type"=>"text/css", 
								"charset"=>$sCharset
							);	
								
		$this->aStyleLink[] = parent::fillTagAttributes("link", $aAttributes);
	}	
	
	
	/**
	 * Prepare and store floating <Style>
	 * It's used to include a style directly in the html page, for example:
	 * <style type="text/css" media="all">
	 *	#one { width: 981px; }
	 *  #two { width: 9px; }
	 * </style>	
	 *
	 * @return void
	 * @param string $sStyle
	 * @param string $sMedia
	 */
	public function addFloatingStyle($sStyle, $sMedia=null){		
		if(!is_null($sStyle)){
			$this->aFloatingStyle[] = "<style type=\"text/css\" media=\"all\"> ".$sStyle."</style>";
		}
	}
	
	
	/**
	 * Insert custom tag in the <Head> tag of the page
	 *
	 * @return void
	 * @param string $sCode html code to add in <head>
	 */
	public function addCustomTag($sCode){		
		if(!is_null($sCode)){
			$this->aCustomTag[] = $sCode;
		}
	}	
	
	
	/**
	 * return the Html source
	 * it return html code of entire object
	 * 
	 * @return string
	 */
	public function getHtmlSource(){
		return $this->render();
	}
	
	
	/**
	 * Display the page
	 * it prints the object Html source on screen
	 * 
	 * @return void
	 */
	public function show(){
		echo $this->render();
	}	
	
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________
	
	
	/**
	 * Render <HEAD> html Tag
	 * using all information stored in the object, this method render and returns
	 * the <HEAD> html tag in a string.
	 *
	 * @return string
	 */
	protected function render(){
		$sTagHead = "\n<head>";
			
			// Extract every data and push in the <HEAD> tag
			
			// Page TITLE
			$sTagHead .= "\n\t".$this->getPageTitle();
		
			// <Meta name="" content=""
			foreach ($this->aMetaTag as $val) {
				$sTagHead .= "\n\t".$val;
			}
			
			// CSS Files <link etc...
			foreach ($this->aStyleLink as $val) {
				$sTagHead .= "\n\t".$val;
			}
			
			// JS Script files <script src="" etc....
			foreach ($this->aJsScriptLink as $val) {
				$sTagHead .= "\n\t".$val;
			}
			
			// Floating Style in the page <style> #classname: etc... </style>
			foreach ($this->aFloatingStyle as $val) {
				$sTagHead .= "\n\t".str_replace("\n", "\n\t",$val);
			}
			
			// FloatingJavascript in the page <script> var foo = ""; etc... </script>
			foreach ($this->aFloatingJsScript as $val) {
				$sTagHead .= "\n\t".str_replace("\n", "\n\t",$val);
			}
			
			// Eventually custom tags
			foreach ($this->aCustomTag as $val) {
				$sTagHead .= "\n\t".str_replace("\n", "\n\t",$val);
			}
		
		$sTagHead .= "\n</head>";
		
		return $sTagHead;
	}
	
}
 
 
 
?>