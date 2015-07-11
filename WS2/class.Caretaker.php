<?php


/**
 * SE-Project - WS2\class.Caretaker.php
 *
 * $Id$
 *
 * This file is part of SE-Project.
 *
 * Automatically generated on 07.01.2015, 17:09:54 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author firstname and lastname of author, <author@example.org>
 * @package WS2
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}


/**
 * include WS2_User
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.User.php');

/* user defined includes */
require_once('lib/functions.php');

/**
 * Short description of class WS2_Caretaker
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS2
 */
class WS2_Caretaker
    extends WS2_User
{

    public function getFirstname(){
        return parent::getFirstname();
    }

	
    public function getLastname(){
        return parent::getLastname();
    }

	
    public function getUsername(){
        return parent::getUsername();
    }

	
    public function getBirthdate(){
        return parent::getBirthdate();
    }

	
    public function getGender(){
        return parent::getGender();
    }

	
    public function getToken(){
        return parent::getToken();
    }

	
/**
 * register a caretaker into the ws2 database
 *
 * @author firstname and lastname of author, <author@example.org>
 * return String
 */
    
    public function registerCaretaker(){
        $this->setToken(sha1($this->getFirstname().$this->getLastname().$this->getUsername().time()));
        $query = "insert into caretaker (firstname,lastname,username,token,birthdate,gender) values (?,?,?,?,?,?)";
        $result = queryMysqli($query, array($this->getFirstname(), $this->getLastname(), $this->getUsername(), $this->getToken(), $this->getBirthdate(), $this->getGender()));
        if ($result->rowCount() > 0) {
            return $this->getToken();
        }
        return 'could not register';
    }       
    
 /**
 * check if a given caretaker is in the database
 *
 * @author firstname and lastname of author, <author@example.org>
 * @param  String caretaker
 * return boolean
 */
	
    public static function existCaretaker($caretaker){
        $query='select * from caretaker where username=?';
        $result= queryMysqli($query, array($caretaker));
        if ($result->rowCount() > 0) {
            return true;
        }
        return false;
    }
	
	/**
 * check if a token is valid for a given caretaker
 *
 * @author firstname and lastname of author, <author@example.org>
 * @param  String username
 * return boolean
 */
	public static function validateCaretaker($caretaker,$token){
		$query='select * from caretaker where username=? and token=?';
		$result=queryMysqli($query,array($caretaker,$token));
		if ($result->rowCount() > 0) {
			return true;
		} 
		return false;
	}
} /* end of class WS2_Caretaker */
/*
$ct=new WS2_Caretaker('fn1','ln1','pc','1990-10-01','m');
print_r($ct);
*/
//$result=$ct->registerCaretaker();
//echo $result;
//

/*$result=  WS2_Caretaker::existCaretaker('pc');
if($result){
    echo "the caretaker is registered";
}
else{
    echo "the caretaker is not registered";
}*/

?>