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
// Don't remove!





import('giano.common.ajax.Ajax');
import('giano.logic.ExampleEngine');

/**
 * Example Ajax Engine that extends the StandardEngine
 * 
 * @package Sylar
 * @version 1.0
 * @since 05/mar/08
 * 
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class App_AjaxExampleEngine extends App_ExampleEngine {

	private $oAjax;
	
	function __construct(){
		parent::__construct();
		
		// This Line block the execution if the referrer is not authorized ajax!
		//$this->initializeApplicationAjax();
	}
	function __destruct(){
		// nothing to do at the moment
	}

	
	
	//								 				   Getter and setter Methods
	//__________________________________________________________________________		
	
	/**
	 * Ritorna l'oggetto ajax Sylar
	 *
	 * @return Sokever_Ajax
	 */
	public function getAjaxController(){
		return $this->oAjax;
	}	
	
	
	//								 							  Public Methods
	//__________________________________________________________________________	
	
	/**
	 * @return Sylar_HtmlDiv
	 */
	public function dispatcherExample(){
		
		try{
			
			switch ($_GET['todo']) {
				
				case "ORDER":
					echo "To be done";
					exit;
				break;
				
				default:
					return $this->makeExampleRandomList($_GET['tln'], $_GET['pg'])->toDiv();
				break;
			}
			
			
		}catch(ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	
	
	
	
	
	//								 						   Protected Methods
	//__________________________________________________________________________	
	

	
	
	

	
	
	//								 						     Private Methods
	//__________________________________________________________________________
	
	
	/**
	 * Inizializza i controlli standard Ajax del framework Sylar tramite l'estensione di Sokever
	 */
	private function initializeApplicationAjax($bCheckReferrer=true){
		$this->oAjax = new App_Ajax($bCheckReferrer);
	}	
	
	
	
}
 
?>