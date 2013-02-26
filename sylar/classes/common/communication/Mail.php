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
import('sylar.common.locale.Locale');

/**
 * Mail
 * 
 * Class to send mail in txt and html format
 * 
 * @package Sylar
 * @version 1.0
 * @since 22/apr/08
 * @author Gianluca Giusti [brdp] <g.giusti@giano-solutions.com>
 * @copyright Sylar Development Team
 */
class Sylar_Mail{
	
	/**
	 * Sender email address
	 * @var string
	 */
	private $sFrom;
	
	/**
	 * Email address for eventually Reply To
	 * @var string
	 */
	private $sReplyTo;
	
	
	/**
	 * Recipient email address array.
	 * 
	 * The array has this structure:
	 * 		$aSend_To = array( 
	 * 						"Mark Green" => "m.green@exampmail.com",
	 * 						"Mark Black" => "m.black@exampmail.com"
	 * 					)
	 * 
	 * The array information will be transformed in:
	 * 		Mark Green <m.green@exampmail.com>, Mark Black <m.black@exampmail.com>
	 * 
	 * @var array
	 */
	private $aSend_To;
	
	/**
	 * Recipient CC email address array 
	 * array structure is the same of $aSend_To
	 * 
	 * @see $aSend_To
	 * @var array
	 */
	private $aSend_CC;
	
	/**
	 * Recipient BCC email address array 
	 * array structure is the same of $aSend_To
	 * 
	 * @see $aSend_To
	 * @var array
	 */
	private $aSend_BCC;	

	/**
	 * Mail Header informations
	 * 
	 * @see mail() php function for specific. http://it.php.net/manual/it/function.mail.php
	 * 
	 * @var string
	 */
	private $sHeader;	
	
	
	/**
	 * Email message object
	 * @var string
	 */
	private $sObject;
	
	/**
	 * Mail Message Text or HTML
	 * @var string
	 */
	private $sMessage;
	
	
	/**
	 * Mail type, can be txt, html or other in the future...
	 * @var string
	 */
	private $sMailType;	
	
	
	/**
	 * Constructor
	 *
	 * @return void
	 * @param string $sMailType default is txt
	 * @param string $sFrom
	 * @param string $sReplyTo
	 */
	function __construct($sMailType="txt", $sFrom=null, $sReplyTo=null){
		try{
			// check and set email type
			$this->setMailType($sMailType);
			
			// Empty array
			$this->setSend_To(array());
			$this->setSend_CC(array());
			$this->setSend_BCC(array());
			
			// check and set eventually Sender Address
			if(!is_null($sFrom)){
				$this->setFrom($sFrom);
			}
			
			// check and set eventually Sender Address Reply to
			if(!is_null($sReplyTo)){
				$this->setReplyTo($sReplyTo);
			}	
				
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
		
	}

	
	function __destruct() {
		# nothing to do
	}

	
	
	
	
	
	//								 				   Getter and Setter Methods
	//__________________________________________________________________________		

	/**
	 * @return void
	 * @param string $sFrom
	 */
	public function setFrom($sFrom){
		$this->sFrom = $sFrom;
	}
	
	/**
	 * @return string
	 */
	public function getFrom(){
		return $this->sFrom;
	}


	/**
	 * @return void
	 * @param string $sFrom
	 */	
	public function setReplyTo($sReplyTo){
		$this->sReplyTo = $sReplyTo;
	}
	/**
	 * @return string
	 */	
	public function getReplyTo(){
		return $this->sReplyTo;
	}


	/**
	 * @return void
	 * @param array $sFrom
	 */	
	public function setSend_To($aSendTo){
		$this->aSend_To = $aSendTo;
	}
	/**
	 * @return array
	 */		
	public function getSend_To(){
		return $this->aSend_To;
	}


	/**
	 * @return void
	 * @param array $sFrom
	 */		
	public function setSend_CC($aSend_CC){
		$this->aSend_CC = $aSend_CC;
	}
	/**
	 * @return array
	 */		
	public function getSend_CC(){
		return $this->aSend_CC;
	}			

	
	/**
	 * @return void
	 * @param array $sFrom
	 */		
	public function setSend_BCC($aSend_BCC){
		$this->aSend_BCC = $aSend_BCC;
	}
	/**
	 * @return array
	 */	
	public function getSend_BCC(){
		return $this->aSend_BCC;
	}			


	/**
	 * @return void
	 * @param string $sFrom
	 */	
	public function setHeader($sHeader){
		$this->sHeader = $sHeader;
	}
	/**
	 * @return string
	 */	
	public function getHeader(){
		return $this->sHeader;
	}
	
	
	/**
	 * @return void
	 * @param string $sFrom
	 */	
	public function setObject($sObject){
		$this->sObject = $sObject;
	}
	/**
	 * @return string
	 */	
	public function getObject(){
		return $this->sObject;
	}			
			

	/**
	 * @return void
	 * @param string $sFrom
	 */	
	public function setMessage($sMessage){
		$this->sMessage = $sMessage;
	}
	/**
	 * @return string
	 */	
	public function getMessage(){
		return $this->sMessage;
	}			
	

	/**
	 * It also check if specified type exists and is supported
	 * @return void
	 * @param string $sFrom
	 */	
	public function setMailType($sMailType){
		try{
			// check and set email type
			if($sMailType=="txt" || $sMailType=="html"){
				$this->sMailType = $sMailType;
			}else{
				throw new ExceptionInSylar("Unknown Mail Type: ".$sMailType, 10014 );
			}
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	/**
	 * @return string
	 */		
	public function getMailType(){
		return $this->sMailType;
	}

	
	
	

	
	//								 							  Public Methods
	//__________________________________________________________________________	
		
	/**
	 * Send the e-mail
	 * It prepare header, object and all the other field and send the e-mail
	 *
	 * @return void
	 * @param string $sObject
	 * @param string $sMessage
	 * @param string $sCharSet
	 */
	public function send($sObject=null, $sMessage=null, $sCharSet=null){
		try{
			
			// Prepare Obj, Message and header
			if(!is_null($sObject)){
				$this->setObject($sObject);
			}
			
			if(!is_null($sMessage)){
				$this->setMessage($sMessage);
			}
			
				
			// Send the email.
			// TODO
			mail(null, $this->getObject(), $this->getMessage(), $this->provideHeader(null, $sCharSet));
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}

	
	/**
	 * a temporary address controls...
	 * 
	 * @todo rewrite this method
	 *
	 * @param string $address
	 * @return boolean
	 */	
	public function validateAddress($address){
		$address = strtolower($address);
		$address = trim($address);
		
		$valid_tlds = array("arpa", "biz", "com", "edu", "gov", "int", "mil", "net", "org",
		  "ad", "ae", "af", "ag", "ai", "al", "am", "an", "ao", "aq", "ar", "as", "at", "au",
		  "aw", "az", "ba", "bb", "bd", "be", "bf", "bg", "bh", "bi", "bj", "bm", "bn", "bo",
		  "br", "bs", "bt", "bv", "bw", "by", "bz", "ca", "cc", "cf", "cd", "cg", "ch", "ci",
		  "ck", "cl", "cm", "cn", "co", "cr", "cs", "cu", "cv", "cx", "cy", "cz", "de", "dj",
		  "dk", "dm", "do", "dz", "ec", "ee", "eg", "eh", "er", "es", "et", "fi", "fj", "fk",
		  "fm", "fo", "fr", "fx", "ga", "gb", "gd", "ge", "gf", "gh", "gi", "gl", "gm", "gn",
		  "gp", "gq", "gr", "gs", "gt", "gu", "gw", "gy", "hk", "hm", "hn", "hr", "ht", "hu",
		  "id", "ie", "il", "in", "io", "iq", "ir", "is", "it", "jm", "jo", "jp", "ke", "kg",
		  "kh", "ki", "km", "kn", "kp", "kr", "kw", "ky", "kz", "la", "lb", "lc", "li", "lk",
		  "lr", "ls", "lt", "lu", "lv", "ly", "ma", "mc", "md", "mg", "mh", "mk", "ml", "mm",
		  "mn", "mo", "mp", "mq", "mr", "ms", "mt", "mu", "mv", "mw", "mx", "my", "mz", "na",
		  "nc", "ne", "nf", "ng", "ni", "nl", "no", "np", "nr", "nt", "nu", "nz", "om", "pa",
		  "pe", "pf", "pg", "ph", "pk", "pl", "pm", "pn", "pr", "pt", "pw", "py", "qa", "re",
		  "ro", "ru", "rw", "sa", "sb", "sc", "sd", "se", "sg", "sh", "si", "sj", "sk", "sl",
		  "sm", "sn", "so", "sr", "st", "su", "sv", "sy", "sz", "tc", "td", "tf", "tg", "th",
		  "tj", "tk", "tm", "tn", "to", "tp", "tr", "tt", "tv", "tw", "tz", "ua", "ug", "uk",
		  "um", "us", "uy", "uz", "va", "vc", "ve", "vg", "vi", "vn", "vu", "wf", "ws", "ye",
		  "yt", "yu", "za", "zm", "zr", "zw");
		
		
		// email empty or null
		if(is_null($address) || strlen($address)<7)
			return false;
		
		
		// Regular expression
		$atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';    	// allowed characters for part before "at" character
		$domain = '([a-z]([-a-z0-9]*[a-z0-9]+)?)'; 	// allowed characters for part after "at" character

		$regex = '^' . $atom . '+' .         		// One or more atom characters.
				 '(\.' . $atom . '+)*'.          	// Followed by zero or more dot separated sets of one or more atom characters.
				 '@'.                            	// Followed by an "at" character.
				 '(' . $domain . '{1,63}\.)+'.   	// Followed by one or max 63 domain characters (dot separated).
				 $domain . '{2,63}'.             	// Must be followed by one set consisting a period of two
				 '$';                            	// or max 63 domain characters.
	
		if(!eregi($regex, $address)){
			return false;
		}
		
		
		// Explode the address on name and domain parts
		$name_domain = explode("@", $address);
		
		// There can be only one ;-) I mean... the "@" symbol
		if (count($name_domain) != 2)
		  return false;
		
		// Check the domain parts
		$domain_parts = explode(".", $name_domain[1]);
		if (count($domain_parts) < 2)
		  return false;
		
		// Check the TLD ($domain_parts[count($domain_parts) - 1])
		if (!in_array($domain_parts[count($domain_parts) - 1], $valid_tlds))
		  return false;
		
		return true;
	}
	
	
	
	//								 							 Private Methods
	//__________________________________________________________________________	

	
	/**
	 * Return e-mail header
	 * It prepare and returns the standard e-mail header for txt and html e-mail.
	 * 
	 * @param string $sMailType
	 * @param string $sCharSet
	 * @return string
	 */
	private function provideHeader($sMailType=null, $sCharSet=null){
		try{
			if(!is_null($sMailType)){
				$this->setMailType($sMailType);
			}
			
			switch ($this->getMailType()) {
				case "txt":
					return $this->provideSimpleHeader();
					break;
				
				case "html":
					return $this->provideHtmlHeader($sCharSet);
					break;
				
				// default is TXT
				default:
					return $this->provideSimpleHeader();
					break;
			}
			
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Returns header to use in the txt email
	 *
	 * @return string
	 */
	private function provideSimpleHeader(){
		try{
			$header ="";
			
			// blocking problem
			if($this->isEmpty($this->getSend_To())){
				throw new ExceptionInSylar("It's impossible to send e-mail to nobody!", 10020);
			}else{
				$header .= 	"To: ".$this->prepareAddressList($this->getSend_To())."\r\n";
			}

			// blocking problem
			if(is_null($this->getFrom())){
				throw new ExceptionInSylar("It's impossible to send e-mail without Sender address specified", 10021);
			}else{
				$header .= "From: {$this->getFrom()}\r\n";
			}

			// optional information
			if(!is_null($this->getReplyTo())){
				$header .= "Reply-To: {$this->getReplyTo()}\r\n";
			}
			
			// optional information
			if(!$this->isEmpty($this->getSend_CC())){
				$header .= "Cc: ".$this->prepareAddressList($this->getSend_CC())."\r\n";
			}
			
			// optional information
			if(!$this->isEmpty($this->getSend_BCC())){
				$header .= "Bcc: ".$this->prepareAddressList($this->getSend_BCC())."\r\n";
			}
			
	     				
			$header .= "X-Mailer: PHP/" . phpversion();
			
			return $header;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Returns header to use in the html email
	 *
	 * @return string
	 */	
	private function provideHtmlHeader($sCharSet=null){
		try{
			
			$header = 	"MIME-Version: 1.0\r\n".
						"Content-type: text/html; charset={$sCharSet}\r\n";
			
			// blocking problem
			if($this->isEmpty($this->getSend_To())){
				throw new ExceptionInSylar("It's impossible to send e-mail to nobody!", 10020);
			}else{
				$header .= 	"To: ".$this->prepareAddressList($this->getSend_To())."\r\n";
			}

			// blocking problem
			if(is_null($this->getFrom())){
				throw new ExceptionInSylar("It's impossible to send e-mail without Sender address specified", 10021);
			}else{
				$header .= "From: {$this->getFrom()}\r\n";
			}

			// optional information
			if(!is_null($this->getReplyTo())){
				$header .= "Reply-To: {$this->getReplyTo()}\r\n";
			}
			
			// optional information
			if(!$this->isEmpty($this->getSend_CC())){
				$header .= "Cc: ".$this->prepareAddressList($this->getSend_CC())."\r\n";
			}
			
			// optional information
			if(!$this->isEmpty($this->getSend_BCC())){
				$header .= "Bcc: ".$this->prepareAddressList($this->getSend_BCC())."\r\n";
			}
			
			// CharacterSet
			if(is_null($sCharSet)){
				$sCharSet = Sylar_ConfigBox::getDefaultCharset();
			}
						
			return $header;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}		
	}
	
	
	/**
	 * Split array in address list
	 * Split the array in a string that contains all email address using the e-mail standard. 
	 * For example:
	 * 			array( 
	 * 					"Mark Green" => "m.green@exampmail.com",
	 * 					"Mark Black" => "m.black@exampmail.com"
	 * 				)
	 * 
	 * become a string as:
	 * 			"Mark Green <m.green@exampmail.com>, Mark Black <m.black@exampmail.com>"
	 * 
	 * @param array $aAddressList
	 * @return string
	 */
	private function prepareAddressList($aAddressList){
		try{
			if(!$this->checkAddressList($aAddressList) || $this->isEmpty($aAddressList)){
				// List is not OK! Then return null
				throw new ExceptionInSylar("Email address list is not OK! ", 10017);	
			}
		
			$fFirst = true;
			$emailList = "";
			
			foreach ($aAddressList as $name=> $email) {
				if(!$fFirst){
					
					$emailList .=", "; 
				}else{						
					$fFirst = false;
				}
				
				$emailList .= "{$name} <{$email}>";
			}
			
			return $emailList;

			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}	
	
	
	/**
	 * Controls every single email address in  the list
	 *
	 * @param array $aAddressList
	 * @param boolean $fVerifyEmailAddress
	 * @return boolean
	 */
	private function checkAddresses($aAddressList, $fVerifyEmailAddress=false){
		try{
			if(!$this->checkAddressList($aAddressList)){
				throw new ExceptionInSylar("Provided array of email addresses is inconsistent ", 10016);
			}
			
			foreach ($aAddressList as $nameAddr => $emailAddr) {
				// first elementary controls on email: a@ab.en minimum 7 characters...
				if(is_null($nameAddr) || is_null($emailAddr) || strlen($emailAddr)<6){
					throw new ExceptionInSylar("Name or email address inconsistent! Name: {$nameAddr} Email: {$emailAddr}", 10015);
				}
				
				if($fVerifyEmailAddress){
					// Verify address - Call the method to verify email address
					if( !$this->validateAddress($emailAddr) ){
						throw new ExceptionInSylar("Email address not valid! email: {$emailAddr}", 10022);
					}
				}
			}
			
			return true;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
	
	/**
	 * Controls the address list array
	 *
	 * @param array $aAddressList
	 * @return boolean
	 */
	private function checkAddressList($aAddressList){
		try{
			if(is_null($aAddressList)){
				throw new ExceptionInSylar("Address list array is NULL", 10018);
			}
			
			if(!is_array($aAddressList)){
				throw new ExceptionInSylar("Address list array is not an array", 10019);
			}
			
			return true;
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}		
			
	}
	
	
	/**
	 * Verify if address list is empty. Return true if is empty, false otherwise
	 *
	 * @param array $aAddressList
	 * @return boolean
	 */
	private function isEmpty($aAddressList){
		try{
			if(!$this->checkAddressList($aAddressList)){
				throw new ExceptionInSylar("Provided array of email addresses is inconsistent ", 10016);
			}
		
			if( $this->countAddresses($aAddressList)>0 ){
				return false;
			}else{
				return true;
			}
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}		
	}
	
	
	/**
	 * count and return the number of email address in the list
	 * return a negative value on error.
	 * 
	 * @param array $aAddressList
	 * @return int
	 */
	private function countAddresses($aAddressList){
		try{
			if(!$this->checkAddressList($aAddressList)){
				throw new ExceptionInSylar("Provided array of email addresses is inconsistent ", 10016);
			}
			
			// return the lenght
			return count($aAddressList);
			
		}catch (ExceptionInSylar $ex){
			throw $ex;
		}
	}
	
} 
 
 
 
?>