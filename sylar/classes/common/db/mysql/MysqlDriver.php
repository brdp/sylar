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


import('sylar.common.system.ConfigBox');	

/** Import the interface implemented from this class */
import('sylar.common.db.DataBaseDriver');
import('sylar.common.db.DataBaseConfiguration');
import('sylar.common.system.Logger');
import('sylar.common.system.ExceptionInSylar');

/**
 * Connessione MySQL. 
 * Esegue la connessione ad un database, in questo caso specifico MySQL.
 * Permette di connettersi direttamente al DB predefinito se non vengono
 * specificati parametri diversi.
 * 
 * @package Sylar
 * @version 1.0
 * @since 03-2005
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */	
class Sylar_MysqlDriver implements Sylar_DataBaseDriver 
{
	/**
     * Param container 
     * it's an array that contains all information on DB connection.
     * 
     * @todo create special class container for the param
     * 
     * @var array
     */	
	protected  $db;	


	/**
	 * Constructor. 
	 * It loads the configuration info for database from config file
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return void
	 * @param string $useDB the label of db in use
	 * 
	 * @see DataBaseConfiguration
	 * @see sylar_loader.php	
	 */	
	function __construct(Sylar_DataBaseConfiguration $dbConfiguration=null){
		try{
			if($dbConfiguration == null){
				$this->setConnectionInfo(Sylar_DataBaseManager::getDefaultDbConfiguration());
			}else{
				$this->setConnectionInfo($dbConfiguration);
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}

	
	/**
	 * Destructor. 
	 * 
	 * @todo empy memory remove results if set
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return void
	 * @param string $useDB the label of db in use
	 */	
	function __destruct(){
		if($this->isConnected()) $this->disconnect();
	}

	/**
	 * Set Connection Info
	 * Retrive and load the connection info from configuration file
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return boolean
	 * @param string $useDB
	 */
	public function setConnectionInfo(Sylar_DataBaseConfiguration $dbConf){
		
		if( !$dbConf->checkConfiguration() ){
			throw new ExceptionInSylar("Wrong Db Configuration. Check the application configuration file.", 10026 );
		}
		
		$this->db["user"] = $dbConf->getUsername();
		$this->db["password"] = $dbConf->getPassword();
		$this->db["db"] = $dbConf->getSchema();
		$this->db["host"] = $dbConf->getHost();
		$this->db["charset"] = $dbConf->getCharSet();
		
		return true;
	}	
	

	/**
	 * Check connection status
	 * Return true if the connection with database is up, false otherwise.
	 * 
	 * @since 12-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return boolean
	 */
	public function isConnected () {
		return @is_resource( $this->db["connection"] ) ? true : false;
	}

	/**
	 * Open a connection. 
	 * Open a connect to Database MySQL adn return the resource to MySQL 
	 * connection or FALSE on failure.
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return resource
	 */	
	public function connect(){
		try{
			if(!$this->isConnected()){
				$this->db["connection"] = @mysql_connect($this->db["host"], $this->db["user"], $this->db["password"]);
				
				if(!$this->isConnected()){
					throw new ExceptionInSylar("MySQL Err.no: ".mysql_errno()." MySQL Err.: ".mysql_error()."\n".__METHOD__." Line: ".__LINE__, 10023 );
				}
				
				// Patch set CharacterSet
				if(@$this->db["charset"])
					$this->execQuery("SET NAMES '{$this->db["charset"]}'" );
			}
						
			return $this->db["connection"];
		
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}


	/**
	 * Close the connection. 
	 * It close the connection to Db if opened.
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return boolean
	 */	
	public function disconnect(){
		try{
			if($this->isConnected()){
				if(!@mysql_close($this->db["connection"])){
					throw new ExceptionInSylar("MySQL Err.no: ".mysql_errno()." MySQL Err.: ".mysql_error()."\n".__METHOD__." Line: ".__LINE__, 10027 );
				}
			}
			return true;
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}	


	/**
	 * Exec a SQL query. 
	 * The connection to database must be opened. It exec a query and return 
	 * MySQL result resource, or FALSE on error.
	 * 
	 * It also return a boolean value if the query is an update/insert/delete
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return resource/boolean
	 * @param string $query la query SQL da eseguire sul DB impostato nel costruttore
	 */	
	public function execQuery($query){ 
		
		try{
			// Purge possible old data in result
			$this->resetResults();
			if(!$this->isConnected()) $this->connect();
			
			$this->db["results"] = @mysql_db_query($this->db["db"], $query, $this->db["connection"]);
			if (!$this->db["results"]) {
				throw new ExceptionInSylar('Error in MySQL execQuery. Errno: '.mysql_errno()." Err: ".mysql_error(), 10028 );
			}else{
				return $this->db["results"];
			}
			
		}catch (ExceptionInSylar $ex){
			// send exception out
			throw $ex;
		}
	}

	
	/**
	 * connect exec and disconnect
	 * open connection, exec query and close the connection.
	 * It connect to database and execute the query. It returns a resurse result 
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return resource
	 * @param string $query la query SQL da eseguire sul DB impostato nel costruttore
	 */	
	public function execSmartQuery($query){ 
		
		try{
			
			// Purge possible old data in result
			$this->resetResults();
		
			if(!$this->isConnected()){ $this->connect(); }
			
			
			$this->db["results"] = $this->execQuery($query);
			if (!$this->db["results"]) {
		    	throw new ExceptionInSylar("MySQL Err.no: ".mysql_errno()." MySQL Err.: ".mysql_error()."\n".__METHOD__." Line: ".__LINE__, 10028 );
		    }		    
			$this->disconnect();
			
			return $this->db["results"];
			
		}catch (ExceptionInSylar  $ex){
			
			// disconnect in case of exceptions
			if($this->isConnected()){
				$this->disconnect();	
			}
			
			// send exception out
			throw $ex;			
		}
	}


	/**
	 * Get the last ID.
	 * it returns the ID generated for an AUTO_INCREMENT column by the previous INSERT query on success 
	 * On error returns false 
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return int
	 */		
	public function getLastId(){ 
		try{
			if($this->isConnected()){
				return @mysql_insert_id($this->db["connection"]);
			}else{
				throw new ExceptionInSylar("MySQL Err.no: ".mysql_errno()." MySQL Err.: ".mysql_error()."\n".__METHOD__." Line: ".__LINE__, 10029 );
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	

	/**
	 * Affected Row. 
	 * Get the number of affected rows by the last INSERT, UPDATE, 
	 * REPLACE or DELETE query
	 * on error return false
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return int
	 */		
	public function affectedRow(){ 
		try{
			if($this->isConnected()){
				return @mysql_affected_rows($this->db["connection"]);
			}else{
				throw new ExceptionInSylar("MySQL Err.no: ".mysql_errno()." MySQL Err.: ".mysql_error()."\n".__METHOD__." Line: ".__LINE__, 10030 );
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}


	/**
	 * Read a particoular value. 
	 * returns the value of the field named $fieldName at row $rowNumber
	 * 
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return mixed
	 * @param mixed $column column name if is string or column number starting from 0 if integer
	 * @param int $rowNumber number of row starting from 0.
	 */	
	public function readField($rowNumber, $column){
		return @mysql_result($this->db["results"], $rowNumber, $column);
	}	


	/**
	 * read a row in an array. 
	 * returns an array with all field of row in associative indices Array with columns name
	 * 
	 * @since 02-2007
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return array
	 */	
	public function fetchArrayByName(){
		return @mysql_fetch_array($this->db["results"], MYSQL_ASSOC);
	}	
	
	
	/**
	 * read a row in an array. 
	 * returns an array with all field of row in number indices Array
	 * 
	 * @since 02-2007
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return array
	 */	
	public function fetchArrayByNum(){
		// it's the same of @mysql_fetch_array($this->db["results"], MYSQL_NUM);
		return @mysql_fetch_row($this->db["results"]);
	}	

	
	/**
	 * total rows number. 
	 * the number of rows returned by a query like select
	 *
	 * @since 03-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return integer
	 */	
	public function resultRows(){
		$this->db["rows"] = @mysql_num_rows($this->db["results"]);
		return $this->db["rows"];
	}
	

	/**
	 * Escapes string for use in SQL. 
	 * It escapes special characters in a string for use in a SQL statement
	 * 
	 * It returns a string with escape character, on errore returns false
	 * 
	 * @since 03-2008
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return string
	 * @param string $string the string to quote
	 * @param boolean $autoDisconnect disconnect when finish. Default is TRUE
	 */
	public function quoteString($string, $autoDisconnect=true){
		try{
			if(!$this->isConnected()){ $this->connect(); }
			
			$string = @mysql_real_escape_string($string);
			
			if($autoDisconnect){ 
				$this->disconnect(); 
			}
			
			return $string;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}




	// Protected Methods
	// --------------------------------

	/**
	 * Reset Results
	 * 
	 * It resets all data in the result variables. 
	 * 
	 * @since 03/2008
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return boolean
	 */
	protected function resetResults(){
		unset($this->db["results"]);
		return true;
	}


}
	

?>