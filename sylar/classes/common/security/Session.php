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


import('sylar.common.system.Logger');
import('sylar.common.system.ConfigBox');	
import('sylar.common.db.DataBaseManager');



/**
 * Gestione Sessione e Permessi.
 * La classe gestisce la sessione Web dell'utente e utilizza vari oggetti
 * globali per la gestione dei $Log, utilizza la classe DataBase, ecc...
 *
 * @package Sylar
 * @version 1.0
 * @since 11-2004
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_Session{

	/** encrypt algoritm used for password */
	private $encryptPwdMethod;
	
	private $storageMethod;
	
	
	function __construct(){
		$this->setEncryptPwdMethod();
		$this->setStorageMethod();
	}
	
	
	function __destruct() {
		# nothing to do
	}
	
	/**
	 * it sets the method used to encrypt the password befor autenticate user
	 * 
	 * @todo actually only md5 method is avaiable.
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @see encryptPwd
	 * @param string $methodName
	 */
	public function setEncryptPwdMethod($methodName='md5'){
		$this->encryptPwdMethod = $methodName;
	}
	
	/**
	 * it returns the method sets for password encription
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @see encryptPwd
	 * @return string
	 */
	public function getEncryptPwdMethod(){
		return $this->encryptPwdMethod;
	}
	
	
	/**
	 * It returns the list of groups in which user is contained
	 *
	 * @return array
	 */
	public function getUserGroupsList(){
		return $this->retriveUserCollectionDataFromSession("sylarGroups");
	}
	
	
	
	/**
	 * Perform a smart login 
	 * using lastSessionId instead of the password
	 *
	 * @see completeLogin()
	 * 
	 * @return boolean
	 * @param string $lastSessionId password di login dell'utente
	 * @param string $username nome di login dell'utente
	 * @param string $email user email
	 * @param string $userid user unique id
	 */
	public function smartLogin($lastSessionId, $username=null, $email=null, $userid=null){
		$log = new Sylar_Logger();
		
		try {			
			$sessionStorage = $this->provideSessionStorageObject();
			
			// Perform Login from data storage 
			$loginInfo = $sessionStorage->smartLogin($lastSessionId, $username, $email, $userid);
			
			return $this->completeLogin($sessionStorage, $loginInfo);
			
		}catch (ExceptionInSylar $ex){
			$log->logEvent("SmartLogin process failed. ".$ex->getMessage(),"WARNING");
			// after log exception pass info to method caller.
			throw $ex;
		}
	}

	
	/**
	 * User Login.
	 * Effettua il login dell'utente passato al metodo.
	 * Aggiorna la sua sessione, lo stato sul db e logga l'azione nel DB.
	 * Gestisce in modo trasparente le varie tipologie di utenza come
	 * Operatore, Dipendente, ecc...
	 * 
	 * @todo switch between the different storage methods. Now works only with DB
	 * 
	 * @see completeLogin()
	 * 
	 * @return boolean
	 * @param string $username nome di login dell'utente
	 * @param string $password password di login dell'utente
	 * @param string $email user email
	 * @param string $userid user unique id
	 */
	public function login($password, $username=null, $email=null, $userid=null){
		$log = new Sylar_Logger();
		
		try {
			$password = $this->encryptPwd($password);
			
			$sessionStorage = $this->provideSessionStorageObject();
			
			// Perform Login from data storage 
			$loginInfo = $sessionStorage->login($password, $username, $email, $userid);
			
			return $this->completeLogin($sessionStorage, $loginInfo);
			
		}catch (ExceptionInSylar $ex){
			$log->logEvent("Login process failed. ".$ex->getMessage(),"WARNING");
			// after log exception pass info to method caller.
			throw $ex;
		}
	}	
	
	
	/**
	 * It complete the login process loading group end permission for the user
	 *
	 * @param Sylar_StorageSession $sessionStorage
	 * @param array $loginInfo
	 * @return boolean
	 */
	private function completeLogin(Sylar_StorageSession &$sessionStorage, &$loginInfo){
		$log = new Sylar_Logger();
		
		try {
			
			if( !is_null($loginInfo) ){
				//debug print_r($loginInfo);
				
				$this->saveUserDataInSession($loginInfo);
				
				#
				# Extract Groups for user and store in session
				#
				$aGroup = $sessionStorage->loadUserGroups($this->getSessionParam("user_id"));
				$this->saveUserCollectionDataInSession("sylarGroups",$aGroup);

				#
				# Extract permissions for user and store in session
				#
				unset($aGroup);				
				$aGroup = $sessionStorage->loadUserPermissions($this->getSessionParam("user_id"));
				$this->saveUserCollectionDataInSession("sylarPermissions",$aGroup);
				
				#
				# Switch status of user on Logged in session and in storage
				#
				$this->setUserAsLogged();				
				
				return true;
			}else{
				return false;
			}
		}catch (ExceptionInSylar $ex){
			$log->logEvent("Login process failed. ".$ex->getMessage(),"WARNING");
			// after log exception pass info to method caller.
			throw $ex;
		}		
	}

	
	/**
	 * Logout
	 * execute the logout process for the user passed
	 *
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return boolean
	 */
	public function logout(){
		$log = new Sylar_Logger();	
		
		try{
			$this->setUserAsNotLogged();
		
			session_unregister(Sylar_ConfigBox::getSessionName());
			
			return true;
		}catch (ExceptionInSylar $ex){
			$log->logEvent("Logout process failed. ".$ex->getMessage(),"WARNING");
			throw $ex;
		}
	}
	
	
	/**
	 * Load all info about user in session.
	 * the data is passeb by an array.
	 *
	 * This method can be override and modified as you need
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param array $aUserData
	 * @return void
	 */
	private function saveUserDataInSession($aUserData){
				
		#
		# Save data in session from DB or other source
		#
		$this->setSessionParam("user_id", $aUserData['user_id']);
		$this->setSessionParam("username", $aUserData['username']);
		$this->setSessionParam("name", $aUserData['name']);
		$this->setSessionParam("surname", $aUserData['surname']);
		$this->setSessionParam("email", $aUserData['email']);
	}
	
		
	/**
	 * Load a complete collection data in Session. It use an array foreach collection.
	 * Note that it isn't a simple set method
	 * 
	 * This method can be override and modified as you need
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param array $aUserData
	 * @return void
	 */
	private function saveUserCollectionDataInSession($collectionDataName, $aUserData){

		//TODO at the moment it save array in session. In the future we should define some roules and controls in this method
		
		#
		# Save data in session from DB or other source
		#
		$this->setSessionParam($collectionDataName, $aUserData);
	}
	
	
	/**
	 * extract a collection of data from session. Usually array structure is used
	 * Note that it isn't a simple get method
	 * 
	 * This method can be override and modified as you need
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param array $aUserData
	 * @return array
	 */
	private function retriveUserCollectionDataFromSession($collectionDataName){
		$log = new Sylar_Logger();
		
		//TODO at the moment it read array from session. In the future we should define some roules and controls in this method
		
		$aCollection = $this->getSessionParam($collectionDataName);
		
		if(!is_array($aCollection)){
			$log->logEvent("Request a Collection from session that it isn't an array. Name: ".$collectionDataName, "WARNING");
		}
		
		return $aCollection;
	}
	
	
	/**
	 * check if a user is logged in session
	 * 
	 * This method can be override and modified as you need
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 * 
 	 * @return boolean
	 */
	public function isUserLogged(){
		if($this->getSessionParam("is_logged")){
			return true;
		}
		return false;
	}
		
	
	/**
	 * It returns an object that is an implementation of 
	 * interface iSessionStorage
	 * $methodName can assume:
	 * 	- db
	 * 	- xml
	 *  - csv
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @todo the rest of method software. Must implement the respective interfaces
	 * 
	 * @return object
	 */
	protected function provideSessionStorageObject($methodName="db"){
		try{
			switch ($methodName) {
				case "db":
					$oDbMngr = new Sylar_DataBaseManager();
					import( $oDbMngr->getDriverClassPath($oDbMngr->getDefaultDbConfiguration()).".security.SqlSession" );
					$sqlSession = new Sylar_SqlSession();
					return $sqlSession;
				break;
				
				default:
					$oDbMngr = new Sylar_DataBaseManager();
					import( $oDbMngr->getDriverClassPath($oDbMngr->getDefaultDbConfiguration()).".security.SqlSession" );
					$sqlSession = new Sylar_SqlSession();
					return $sqlSession;
				break;
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
		
	}
	
	
	/**
	 * it returns true if the user in session is member of specified group_id, false otherwise
	 * 
	 * @todo to be done isUserMemberOfGroupName but Groups name must be unique?
	 * 
	 * @see Sylar_Session::login($username, $password)
	 * @see Sylar_iSessionStorage::loadUserGroups($user_id)
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param int $user_id
	 * @return boolean
	 */
	public function isUserMemberOfGroupId($user_id){
		$aGroups = $this->retriveUserCollectionDataFromSession('sylarGroups');
		#
		# has the Groups array the key $user_id?
		#
		if(is_array($aGroups) && array_key_exists($user_id, $aGroups)){
			return true;
		}else{
			return false;	
		}		
	}
	
	
	/**
	 * it controls permissions associated user by permission_id
	 * 
	 * @see Sylar_Session::login($username, $password)
	 * @see Sylar_iSessionStorage::loadUserPermissions($user_id)
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param int $permission_id
	 * @return boolean
	 */
	public function hasUserPermissionId($permission_id){
		$aPermissions = $this->retriveUserCollectionDataFromSession('sylarPermissions');
		#
		# has the Permissions array the key $permission_id?
		#
		if(is_array($aPermissions) && array_key_exists($permission_id, $aPermissions)){
			return true;
		}else{
			return false;	
		}	
	}
	
	
	/**
	 * it controls permissions associati user by permission_code
	 *
	 * @see Sylar_Session::login($username, $password)
	 * @see Sylar_iSessionStorage::loadUserPermissions($user_id) 
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param string $permission_code
	 * @return boolean
	 */
	public function hasUserPermissionCode($permission_code){
		$aPermissions = $this->retriveUserCollectionDataFromSession('sylarPermissions');
		#
		# has the Permissions array the value $permission_code?
		#
		if(is_array($aPermissions) && in_array($permission_code, $aPermissions)){
			return true;
		}else{
			return false;	
		}	
	}	
	
	
	
	
	/**
	 * In Sylar User i logged if the session param IS_LOGGED is True.
	 * 
	 * Exceptions will be sent to caller method
	 * 
	 * This method can be override and modified as you need
	 * 
	 * Set the user status as logged in the system/session
	 * You can override thi method to modify or implement actual process
	 *
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
 	 * @return boolean
	 */
	private function setUserAsLogged(){
		
		try{
			/** Update data in session */
			$this->setSessionParam("is_logged", true);	
			$this->setSessionParam("unique_id", 999);
			
			/** Update session data on the storage */
			$sessionStorage = $this->provideSessionStorageObject();
			$sessionStorage->setUserAsLogged( $this->getSessionParam("username"), $this->getSessionParam("user_id") );
			return true;
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	

	/**
	 * In Sylar User i logged if the session param IS_LOGGED is True.
	 * 
	 * Exceptions will be sent to caller method
	 * 
	 * This method can be override and modified as you need
	 * 
	 * Set the user status as Not logged in the system/session
	 * You can override thi method to modify or implement actual process
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
 	 * @return boolean
	 */
	private function setUserAsNotLogged(){
		try{
			$this->setSessionParam("is_logged", false);	
			
			/** Update session data on the storage */
			$sessionStorage = $this->provideSessionStorageObject();
			$sessionStorage->setUserAsNotLogged( $this->getSessionParam("username"), $this->getSessionParam("user_id") );
			return true;
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}	
		
	
 	 /**
	 * set the param value.
	 * Set the value of Session param.
	 *
	 * @since 02-2008
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return mixed
	 * @param string $parametro il nome del parametro da impostare.
	 * @param mixed $valore il valore da assegnare al parametro.
	 */
	public function setSessionParam($parametro, $valore){
		$_SESSION[Sylar_ConfigBox::getSessionName()][$parametro] = $valore;
		return $valore;
	}
	
	
 	 /**
	 * return the value of session param.
	 *
	 * @since 02-2008
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return mixed
	 * @param string $parametro name of param.
	 */
	public function getSessionParam($parametro){
		if(session_is_registered(Sylar_ConfigBox::getSessionName()) && array_key_exists($parametro, $_SESSION[Sylar_ConfigBox::getSessionName()]) ){
			return $_SESSION[Sylar_ConfigBox::getSessionName()][$parametro];
		}else{
			return false;
		}
	}	
	
	
	/**
	 * set the storage method of user data
	 * Possible value: 
	 * 		- db
	 * 		- xml
	 * 		- csv
	 * 		- custom
	 * 
	 * @todo Implements other method different from db like file or other custom
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param string $methodName
	 * @return void
	 */
	public function setStorageMethod($methodName="db"){
		$this->storageMethod = $methodName;
	}
	

	/**
	 * return a dump of session status converted into a formatted string.
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public function getSessionStatusDump(){
		$sResult = "Sylar Session Status Dump: \n";
		
		// capture the output buffer 
		ob_start();
			print_r($this->getSessionObj());
			$sResult .= ob_get_contents();
		ob_end_clean();
		
		return $sResult;
	}	
	
	
	/**
	 * get the storage method of user data
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 * @todo Implements method different from db like csv, xml etc...
	 */
	public function getStorageMethod(){
		return $this->storageMethod;
	}
	
	
	/**
	 * return the id of session
	 *
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return string
	 */
	public static function getSessionID(){
		return session_id();
	}
		
	
	/**
	 * returns the Session Object. In Sylar is an Array
	 *
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @return array
	 */
	protected function getSessionObj(){
		if(session_is_registered(Sylar_ConfigBox::getSessionName())){
			return $_SESSION[Sylar_ConfigBox::getSessionName()];
		}else{
			return false;
		}
	}

	
	/**
	 * Encript the password using set algorytm
	 * If the method set is not avaiable md5 will be used
	 * 
	 * @todo to implement ather algorytm
	 * 
	 * @since 16/feb/08
 	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 	 *
	 * @param string $password password string
	 * @return string
	 */
	private function encryptPwd($password){
		switch ($this->getEncryptPwdMethod()) {
			case 'md5':
				return md5($password);
			break;

			default:
				return md5($password);
			break;
		}
		
	}

	
	 /**
	 * get a unique id for the user session.
	 *
	 * @since 08-2005
	 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
	 * 
	 * @return integer
	 */
	public function getUniqueID(){
		$_SESSION[Sylar_ConfigBox::getSessionName()]["unique_id"]++;

		return $this->getSessionParam("unique_id");
	}
	
}


?>