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



/** Include the class ConfigBox */
import('sylar.common.system.ConfigBox');	
import('sylar.common.db.mysql.MysqlStatement');


/**
 * Sql layer for Logger
 * 
 * @see Sylar_MysqlDriver
 * @see Sylar_DataBaseDriver
 * @see Sylar_Logger
 * 
 * @package Sylar
 * @version 1.0
 * @since 12-2004
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */	
class Sylar_SqlLogger extends Sylar_MysqlStatement{
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Log di un evento.
	 * Logga l'azione nella categoria $sezione e con tipo log $tipo. Il livello
	 * è in ordine decrescente.
	 * 
	 * @since 12-2004
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return string
	 * @param array $logInfo codice breve della sezione a cui appartiene l'evento
	 */	
	public static function logEventInDb($logArray){
					
		#
		# Log the event
		#
		$sql = "	insert into SYLAR_event_log
					(
						level,
						level_desc,
						ip_address,
						istant,
						event_desc,
						web_page, 
						extra_info
					) 
					values 
					(
						".$logArray[0].", 
						'".$logArray[1]."',
						'".$logArray[2]."',
						NOW(), 
						'".mysql_escape_string($logArray[3])."',
						'".mysql_escape_string($logArray[4])."',						
						'".mysql_escape_string($logArray[5])."'
					)
				";	

		return $sql;	
	}
}
 
 
 
?>