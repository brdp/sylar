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

import('sylar.common.data.SimpleTable');
import('sylar.presentation.html.HtmlDiv');

import('app.giano.presentation.Format');
 
/**
 * Example of format class
 * It format informations about log 
 * 
 * @package Sylar
 * @version 1.0
 * @since 05/mar/08
 * 
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
 
class FormatLogList extends App_Format{
	
	function __construct(Sylar_LocaleConfiguration $localeConf=null){
		parent::__construct($localeConf);
	}
	function __destruct(){
		// nothing to do at the moment
	}
	
	/**
	 * Example of format class
	 * Format logs from Db in a txt list
	 *
	 * @param Sylar_SimpleTable $sTable
	 * @return string
	 */
	public function makeLogList(Sylar_SimpleTable $sTable){
		$result = "\n Table Title: ".$sTable->getTableTitle();
		$result .= "\n Table Id: ".$sTable->getTableId();
		$result .= "\n Table Description: ".$sTable->getTableDescription();
		$result .= "\n-------------------------------------------------------------\n";
				
		for($i=0; $i<$sTable->getRows(); $i++){
			for($j=0; $j<$sTable->getColumnsHeader()->getColumns(); $j++){
				$result .= "\n- ".$sTable->getColumnsHeader()->getColumnById($j)->getColumnCode().": ".$sTable->getRow($i)->getColumnValue($j);
			}
			
			$result .= "\n-------------------------------------------------------------";
			
		}	

		return $result;
	}
	
	
	/**
	 * Example of format class
	 * Format logs from Db in a html table list
	 *
	 * @param Sylar_SimpleTable $sTable
	 * @return Sylar_HtmlDiv
	 */
	public function makeHtmlLogList(Sylar_SimpleTable $sTable){
		
		$div = new Sylar_HtmlDiv("tb_1", "tb_1");
		
		
		//Table start
		$result = "\n<table class='sample' id='".$sTable->getTableId()."' name='".$sTable->getTableTitle()."'>";
			
			// Table Caption
			$result .= "\n<CAPTION>Titolo: ".$sTable->getTableTitle()."</CAPTION>";
			
			// All Columns Header
			$result .= "\n<tr>";
			for($i=0; $i<$sTable->getColumnsHeader()->getColumns(); $i++){
				$result .= "\n<th>".$sTable->getColumnsHeader()->getColumnById($i)->getColumnCode()."</th>";
			}
			$result .= "\n</tr>";		
		
			// All the rows with values
			for($i=0; $i<$sTable->getRows(); $i++){
				$result .= "\n<tr>";
				for($j=0; $j<$sTable->getColumns(); $j++){
					$result .= "\n<td>".$sTable->getRow($i)->getColumnValue($j)."</td>";
				}				
				$result .= "\n</tr>";
			}
		
		$result .= "\n</table>";
		
		
		
		// style if you want
		$result .= "
					<style type=\"text/css\">
						table.sample {
							border-width: 2px 2px 2px 2px;
							border-spacing: 2px;
							border-style: solid solid solid solid;
							border-color: black black black black;
							border-collapse: separate;
							background-color: rgb(255, 250, 250);
						}
						table.sample th {
							border-width: 1px 1px 1px 1px;
							padding: 3px 3px 3px 3px;
							border-style: solid solid solid solid;
							border-color: red red red red;
							background-color: white;
							-moz-border-radius: 0px 0px 0px 0px;
						}
						table.sample td {
							border-width: 1px 1px 1px 1px;
							padding: 3px 3px 3px 3px;
							border-style: solid solid solid solid;
							border-color: red red red red;
							background-color: white;
							-moz-border-radius: 0px 0px 0px 0px;
						}
					</style>";
		
		return $result;
	}

	
	
	
	
	/**
	 * Example of format class
	 * Format logs from Db in a html table list
	 *
	 * @param Sylar_SimpleTable $sTable
	 * @return string
	 */
	public function OLD_makeHtmlLogList(Sylar_SimpleTable $sTable){
		
		//Table start
		$result = "\n<table class='sample' id='".$sTable->getTableId()."' name='".$sTable->getTableTitle()."'>";
			
			// Table Caption
			$result .= "\n<CAPTION>Titolo: ".$sTable->getTableTitle()."</CAPTION>";
			
			// All Columns Header
			$result .= "\n<tr>";
			for($i=0; $i<$sTable->getColumnsHeader()->getColumns(); $i++){
				$result .= "\n<th>".$sTable->getColumnsHeader()->getColumnById($i)->getColumnCode()."</th>";
			}
			$result .= "\n</tr>";		
		
			// All the rows with values
			for($i=0; $i<$sTable->getRows(); $i++){
				$result .= "\n<tr>";
				for($j=0; $j<$sTable->getColumns(); $j++){
					$result .= "\n<td>".$sTable->getRow($i)->getColumnValue($j)."</td>";
				}				
				$result .= "\n</tr>";
			}
		
		$result .= "\n</table>";
		
		
		
		// style if you want
		$result .= "
					<style type=\"text/css\">
						table.sample {
							border-width: 2px 2px 2px 2px;
							border-spacing: 2px;
							border-style: solid solid solid solid;
							border-color: black black black black;
							border-collapse: separate;
							background-color: rgb(255, 250, 250);
						}
						table.sample th {
							border-width: 1px 1px 1px 1px;
							padding: 3px 3px 3px 3px;
							border-style: solid solid solid solid;
							border-color: red red red red;
							background-color: white;
							-moz-border-radius: 0px 0px 0px 0px;
						}
						table.sample td {
							border-width: 1px 1px 1px 1px;
							padding: 3px 3px 3px 3px;
							border-style: solid solid solid solid;
							border-color: red red red red;
							background-color: white;
							-moz-border-radius: 0px 0px 0px 0px;
						}
					</style>";
		
		return $result;
	}	
	
	
	
}
 
 
 
 
?>