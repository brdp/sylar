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
import('sylar.common.db.mysql.MysqlDriver');
import('sylar.common.system.Logger');
import('sylar.common.security.Session');
import('sylar.common.security.StorageSession'); 
import('sylar.common.system.ExceptionInSylar');

/**
 * Sql Class for Session Storage on DB
 * 
 * It manage the sql command needed from Session Objects to storage and access data
 * 
 * @package Sylar
 * @version 1.0
 * @since 16/feb/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_SqlSession implements Sylar_StorageSession{
	
	function __construct(){
		# nothing to do
	}
	
	
	function __destruct() {
		# nothing to do
	}

	
	/**
	 * Perform a smart login without password
	 *
	 * @see performLogin()
	 * 
	 * @param string $lastSessionId
	 * @param string $username
	 * @param string $email
	 * @param string $user_id
	 * @return array
	 */
	public function smartLogin($lastSessionId, $username=null, $email=null, $user_id=null){	
		try{
			if(is_null($lastSessionId)){
				$log = new Sylar_Logger();	
				$log->logEvent("ERROR! Smart login is impossible without LastSessioId [Sylar_SqlSession::Login]","FATAL");
				throw new ExceptionInSylar("Smart login is impossible without LastSessioId", 10031 );				
			}		

			if(is_null($username) && is_null($email) && is_null($user_id)){
				throw new ExceptionInSylar("No enough data provided for login process.", 10010 );
			}
			
			return $this->performLogin(null, $username, $email, $user_id, $lastSessionId);
			
		}catch (ExceptionInSylar $ex){			
			// Pass the exceptions to caller method
			throw $ex;
		}
	}
	
	
	/**
	 * Query SQL for login procedure
	 * If Login query is ok it return an hash with all info to Session Class. Return false otherwise.
	 * Login process can be done with password and other information like email, username and userid.
 	 *
 	 * @see performLogin()
 	 *  
	 * @param string $encryptedPassword
	 * @param string $username
	 * @param string $email
	 * @param int $user_id
	 * @return array
	 */
	public function login($encryptedPassword, $username=null, $email=null, $user_id=null){
		$log = new Sylar_Logger();		
		$db = new Sylar_MysqlDriver();
		$params = 0;
		
		try{	
					
			if(is_null($username) && is_null($email) && is_null($user_id)){
				throw new ExceptionInSylar("No enough data provided for login process.", 10010 );
			}
			
			return $this->performLogin($encryptedPassword, $username, $email, $user_id);
			
		}catch (ExceptionInSylar $ex){			
			// Pass the exceptions to caller method
			throw $ex;
		}
	}

	
	/**
	 * Query SQL to extract all groups where the user is in
 	 * 
 	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param string $user_id
	 * @return array
	 */
	public function loadUserGroups($user_id=0){
		$log = new Sylar_Logger();		
		$db = new Sylar_MysqlDriver();
		
		try{			
			$sql = "	SELECT 
							SYLAR_usergroups.group_id as group_id, 
							SYLAR_usergroups.name as name
						FROM 
							SYLAR_usergroups, 
							SYLAR_rel_users_usergroups
						WHERE 
							SYLAR_rel_users_usergroups.group_id = SYLAR_usergroups.group_id and
							SYLAR_rel_users_usergroups.user_id = ".$user_id."
					";
			
			$result = $db->execSmartQuery($sql);
			
			$aAppo = array();
			while ($row = $db->fetchArrayByName()) {
			   $aAppo[$row["group_id"]] = $row["name"]; 
			}
			
			if($db->resultRows()<1){
				$log->logEvent("User logged but he has no group. [Sylar_SqlSession::Login]","WARNING");				
			}
			
			return $aAppo;
			
		}catch (ExceptionInSylar $ex){			
			// Pass the exceptions to caller method
			throw $ex;
		}
	}	
	
	
	/**
	 * Query SQL to extract all permission of user 
 	 * 
 	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param string $user_id
	 * @return array
	 */
	public function loadUserPermissions($user_id=0){
		$log = new Sylar_Logger();		
		$db = new Sylar_MysqlDriver();
		
		try{			
			$sql = "	SELECT 
							SYLAR_permissions.permission_id as permission_id, 
							SYLAR_permissions.code as code
						FROM 
							SYLAR_permissions,
							SYLAR_rel_usergroup_permission,
							SYLAR_usergroups, 
							SYLAR_rel_users_usergroups
						WHERE 
							SYLAR_rel_usergroup_permission.permission_id = SYLAR_permissions.permission_id and
							SYLAR_rel_users_usergroups.group_id = SYLAR_rel_usergroup_permission.group_id and
							SYLAR_rel_users_usergroups.group_id = SYLAR_usergroups.group_id and
							SYLAR_rel_users_usergroups.user_id = $user_id
					";
			
			$result = $db->execSmartQuery($sql);
			
			$aAppo = array();
			while ($row = $db->fetchArrayByName()) {
			   $aAppo[$row["permission_id"]] = $row["code"]; 
			}
			
			if($db->resultRows()<1){
				$log->logEvent("User logged but he has no permission. [Sylar_SqlSession::Login]","WARNING");				
			}
			
			return $aAppo;
			
		}catch (ExceptionInSylar $ex){			
			// Pass the exceptions to caller method
			throw $ex;
		}
	}		
	
	
	/**
	 * Set the information about user as logged on the storage DB
 	 * 
 	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param string $username
	 * @param int $user_id not request field. if it's 0 the method ignore it
	 * @return boolean
	 */
	public function setUserAsLogged($username, $user_id=0){
		$log = new Sylar_Logger();		
		$db = new Sylar_MysqlDriver();
		
		try{
			
			if($user_id>0){ $sqlAdd = " and user_id=".$user_id; }
			$sql = "update SYLAR_users set last_login=NOW(), num_login=num_login+1, session_id='".Sylar_Session::getSessionID()."' where username = '".$db->quoteString($username)."' ".$sqlAdd;
			$results = $db->execSmartQuery($sql);
			//TODO Control on affected rows
			
			$log->logEvent("Updating status for login in DB: ".$username.". [Sylar_SqlSession::setUserAsLogged]","VERBOSE");
			return true;
			
		}catch (Exception $ex){
			//$log->logEvent("Error! During Login process... SQL. [Sylar_SqlSession::setUserAsLogged] ex: ".$ex->getMessage(), "WARNING");
			
			if($db->isConnected()){ $db->disconnect(); }
			
			// Pass the exceptions to caller method
			throw $ex;
		}
	}	
	

	/**
	 * Set the information about user as NOT logged on the storage DB
 	 * 
 	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param string $username
	 * @param int $user_id not request field. if it's 0 the method ignore it
	 * @return boolean
	 */
	public function setUserAsNotLogged($username, $user_id=0){
		$log = new Sylar_Logger();		
		$db = new Sylar_MysqlDriver();
		
		try{
			
			if($user_id>0){ $sqlAdd = " and user_id=".$user_id; }			
			$sql = "update SYLAR_users set last_logout=NOW() where username = '".$db->quoteString($username)."' ".$sqlAdd;
			$results = $db->execSmartQuery($sql);
			
			$log->logEvent("Updating status for logout in DB: ".$username.". [Sylar_SqlSession::setUserAsNotLogged]","VERBOSE");
			return true;
			
		}catch (Exception $ex){			
			//$log->logEvent("Error! During Logout process... SQL. [Sylar_SqlSession::setUserAsNotLogged] ex: ".$ex->getMessage(), "WARNING");
			
			if($db->isConnected()){ $db->disconnect(); }
			
			// Pass the exceptions to caller method
			throw $ex;
		}
	}	
	
	
	
	
	
	
	
	
	//								 						     Private Methods
	//__________________________________________________________________________
	
	
	/**
	 * Query SQL for login procedure
	 * If Login query is ok it return an hash with all info to Session Class. Return false otherwise.
	 * Login process can be done with password and other information like email, username and userid.
 	 *
 	 * Keep attention when used without password! For example if used to perform login from cookie.
 	 * Always needed almost two params.
 	 * It's required $encryptedPassword or $lastSessId
 	 * 
 	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *  
	 * @param string $encryptedPassword
	 * @param string $username
	 * @param string $email
	 * @param int $user_id
	 * @param string $lastSessId
	 * @return array
	 */
	private function performLogin($encryptedPassword=null, $username=null, $email=null, $user_id=null, $lastSessId=null){
		$log = new Sylar_Logger();		
		$db = new Sylar_MysqlDriver();
		$params = 0;
		
		try{	

			// one of this two params must be valid and not null!
			if(is_null($encryptedPassword) && is_null($lastSessId)){
				$log->logEvent("ERROR! Required param null. Password and lastSessId is all null. ","FATAL");
				// Sometings is WRONG! more than one user with the same username! Impossible!
				throw new ExceptionInSylar("Required param null. Password and lastSessId is all null", 10032 );
			}
			
			$sql = "select * from SYLAR_users where active=1 and deleted=0 ";
			
			// controls and add param to select
			if(!is_null($username)){
				$params++;
				$sql .= " and username = '".$db->quoteString($username)."' ";
			}
			
			// controls and add param to select
			if(!is_null($email)){
				$params++;
				$sql .= " and email = '".$db->quoteString($email)."' ";
			}
			
			// controls and add param to select
			if(!is_null($encryptedPassword)){
				$params++;
				$sql .= " and password = '".$db->quoteString($encryptedPassword)."' ";
			}
			
			// controls and add param to select
			if(!is_null($lastSessId)){
				$params++;
				$sql .= " and session_id = '".$db->quoteString($lastSessId)."' ";
			}			
			
			// controls and add param to select
			if(!is_null($user_id) && $user_id>0){
				$params++;
				settype($user_id, "integer");
				$sql .= " and user_id = '".$user_id."' ";
			}
			
			if($params <2){
				throw new ExceptionInSylar("No sufficient data provided for login process.", 10010 );
			}
			
			$db->execSmartQuery($sql);			
			
			if($db->resultRows()==1){				
				
				// User exists and load base data from db in array
				$aAppo = array();
				$row=$db->fetchArrayByName();
				
				return $row;
			}else{					
				if($db->resultRows()>1){
					
					$log->logEvent("ERROR! More than one user in the Storage! [Sylar_SqlSession::Login]","FATAL");
					// Sometings is WRONG! more than one user with the same username! Impossible!
					throw new ExceptionInSylar("ERROR! More than one user with same username in the Storage! [Sylar_SqlSession::Login]", 10012 );
				}
				
				if($db->isConnected()){ $db->disconnect(); }
				
				throw new ExceptionInSylar("User Not found for Login. One ore more than one params are wrong.", 10011 );			
			}
			
		}catch (ExceptionInSylar $ex){			
			// Pass the exceptions to caller method
			throw $ex;
		}
	}
}

?>