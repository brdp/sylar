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
import('sylar.common.db.DataBaseManager');

/**
 * Gestione Log del sistema. 
 * La classe estende DataBase e dunque dipende da essa
 * ma dipende anche da Sessione infatti viene usato un oggetto globale $SS che
 * deve essere dichiarato. Nel sistema GVisit tale oggetto è dichiarato nel
 * file di configurazione generale.
 * 
 * @see Sylar_SqlLogger
 * 
 * @package Sylar
 * @version 1.0
 * @since 12-2004
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team 
 */	
class Sylar_Logger{
	/** 
	 * define the log method 
	 * It can assume the value of:
	 * - db
	 * - file
	 * - xml
	 */
	private $logSaveMethod;
	
	/**
	 * Log levels
	 * it conteins all possible levels
	 */
	private $logLevels;
	
	/**
	 * The level set for logger
	 *
	 * @var integer
	 */
	private $logLevel;
	
	
	/**
	 * DataBase Configuration for log
	 *
	 * @var Sylar_DataBaseConfiguration
	 */
	private $oDataBaseConfig;

	
	
	function __construct( $logLevel=SYLAR_LOG_LEVEL ){
		$this->setLogSaveMethod();
		$this->loadLogLevels();
		$this->setLogLevel($logLevel);
	}
	function __destruct() {
		# nothing to do
	}

	
	
	
	
	/**
	 * Set Logging into Db
	 * Set the class to log information into specified DataBase, if not 
	 * specified it try to log into default Sylar DataBase
	 *
	 * @return void
	 * @param Sylar_DataBaseConfiguration $dbConfiguration
	 */
	public function setDataBaseConfig(Sylar_DataBaseConfiguration $dbConfiguration=null){
		try{
			if($dbConfiguration == null){
				try{
					$this->oDataBaseConfig = Sylar_DataBaseManager::getDefaultDbConfiguration();
				}catch (ExceptionInSylar $ex){
					throw new ExceptionInSylar("Wrong Db Configuration. Check the application configuration file.", 1 );
				}
			}else{
				$this->oDataBaseConfig = $dbConfiguration;
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Return Db Configuration for log
	 * it return the object with all database information
	 *
	 * @return Sylar_DataBaseConfiguration
	 */
	public function getDataBaseConfig(){
		return $this->oDataBaseConfig;
	}
	
	
		
	/**
	 * save event in log
	 *
	 * @since 2-2008
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com> 
	 * 
	 * @param string $event codice breve della sezione a cui appartiene l'evento
	 * @param string $level il codice di livello di importanza dell'evento
	 * @return boolean
	 */
	public function logEvent($event, $level){
		#
		# verify if the event sould be log
		#
		if( $this->getLoggerLevelValue() > $this->getLevelValue($level) ) return true;
				
		switch ($this->getLogSaveMethod()) {
			
			case 'db':
				$this->logEventInDb($event, $level);
				break;
				
			case 'file':
				$this->logEventInFile($event, $level);
				break;
				
			default:
				$this->logEventInDb($event, $level);
				break;
		}
		
	}
	
	
	
	/**
	 * save log into file
	 *
	 * @todo to implement
	 * 
	 * @since 12-2004
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com> 
	 * 
	 * @param string $event codice breve della sezione a cui appartiene l'evento
	 * @param string $level il codice di livello di importanza dell'evento
	 * @return boolean
	 */
	private function logEventInFile($event, $level){
		return true;
	}	
	
	
	/**
	 * Log di un evento.
	 * Logga l'azione nella categoria $sezione e con tipo log $tipo. Il livello
	 * è in ordine decrescente.
	 * 
	 * @todo move SQL in Sql Space!
	 * 
	 * @since 12-2004
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return void
	 * @param string $event codice breve della sezione a cui appartiene l'evento
	 * @param string $level il codice di livello di importanza dell'evento
	 */	
	private function logEventInDb($event, $level){

		try{
			
			$this->setDataBaseConfig();
			
			$oDbMngr = new Sylar_DataBaseManager();
			
			//
			// Import the correct SQL Query library for Logger
			//
			import( $oDbMngr->getDriverClassPath($this->getDataBaseConfig()) .".system.SqlLogger" );
			
			$db = $oDbMngr->driverDispatcher($this->getDataBaseConfig());
			
			//$sqlLogger = new Sylar_SqlLogger();
			
			$sqlArray = array( 
								$this->getLevelValue($level), 
								$level, 
								$_SERVER["REMOTE_ADDR"],
								$event, 
								$this->formatWebPageInfo(), 
								$this->formatExtraInfo() 
							);
		
			//$sqlLogger->logEventInDb($sqlArray);		
		
			$db->execSmartQuery(Sylar_SqlLogger::logEventInDb($sqlArray));				
							
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
		
		
	}	
	

	/**
	 * Informazioni Extra. 
	 * Formatta le informazioni extra da inserire nel campo info_extra della
	 * tabella di LOG.
	 * 
	 * @todo Da implementare
	 * 
	 * @since 12-2004
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return string
	 */		
	private function formatExtraInfo(){
		return "Extra info utente ecc...";
	}	

	/**
	 * Informazioni Pagina. 
	 * Recupera le informazioni relative al file che ha scatenato l'evento da
	 * Loggare
	 * 
	 * @since 12-2004
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return string
	 * 
	 * @todo Da implementare e migliorare
	 */		
	private  function formatWebPageInfo(){
		return "Web Info da fare";
	}
	
	/**
	 * Ottieni Livello. 
	 * Ritorna il valore numerico del livello fornito, es. DEBUG=50, NORMAL=150 ecc...
	 * 
	 * @since 12-2004
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return integer
	 * @param string $levelName il codice di livello di log, es. DEBUG, NORMAL, ecc...
	 */		
	private function getLevelValue($levelName){	
		
		if(!$this->logLevels[$levelName]){
			return 44;		# Security
		}else{
			return $this->logLevels[$levelName];	
		}	
	}
	
	/**
	 * Set the log level
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param string $levelName the name ov the log level
	 */
	public function setLogLevel($levelName=SYLAR_LOG_LEVEL){
		$this->logLevel = $this->getLevelValue($levelName);
	}
	
	/**
	 * Return the numeric log lovel
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return integer
	 */
	public function getLoggerLevelValue(){
		return $this->logLevel;
	}
	
	public function setLogSaveMethod($logMethod='db'){
		$this->logSaveMethod = $logMethod;
		
		// if log use db then set the DataBase Default Config...
		if($logMethod == 'db'){
			$this->setDataBaseConfig();
		}
		
	}
	
	public function getLogSaveMethod(){
		return $this->logSaveMethod;
	}
	
	/**
	 * Load all possible log value
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return void
	 */
	private function loadLogLevels(){

		/** All possible Log levels */	
		$this->logLevels = array(	'DEBUG_NO_LIVELLO'=>44, 
									'DEBUG'=>50, 
									'VERBOSE'=>100, 
									'NORMAL'=>150, 
									'WARNING'=>200, 
									'FATAL'=>250, 
									'NO_LOG'=>300
								);
	}
	
}

?>