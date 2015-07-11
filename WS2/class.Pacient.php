<?php

error_reporting(E_ALL);

/**
 * SE-Project - WS2\class.Pacient.php
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
 * Short description of class WS2_Pacient
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS2
 */
class WS2_Pacient
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
 * register a pacient into the ws2 database
 *
 * @author firstname and lastname of author, <author@example.org>
 * return String
 */
    public function registerPacient(){
        $this->setToken(sha1($this->getFirstname().$this->getLastname().$this->getUsername().time()));
        $query = "insert into pacient (firstname,lastname,username,token,birthdate,gender) values (?,?,?,?,?,?)";
        $result = queryMysqli($query, array($this->getFirstname(), $this->getLastname(), $this->getUsername(), $this->getToken(), $this->getBirthdate(), $this->getGender()));
        if ($result->rowCount() > 0) {
            return $this->getToken();
        }
        return 'could not register';
    }
	
 /**
 * check if a given pacient is in the database
 *
 * @author firstname and lastname of author, <author@example.org>
 * @param  String pacient
 * return boolean
 */
 
    public static function existPacient($pacient){
        $query='select * from pacient where username=?';
        $result= queryMysqli($query, array($pacient));
        if ($result->rowCount() > 0) {
            return true;
        }
        return false;
    }

/**
 * check if a token is valid for a given pacient
 *
 * @author firstname and lastname of author, <author@example.org>
 * @param  String username
 * return boolean
 */
	public static function validatePacient($pacient,$token){
		$query='select * from pacient where username=? and token=?';
		$result=queryMysqli($query,array($pacient,$token));
		if ($result->rowCount() > 0) {
			return true;
		} 
		return false;
	}
} 

/*
$pacient=new WS2_Pacient('fn1','ln1','un1','1990-10-01','m');
print_r($pacient);
*/
/*
$result=$pacient->registerPacient();
echo $result;
*/

/*
$result= WS2_Pacient::validatePacient('pc1','123');
if($result){
    echo "the pacient is validated";
}
else{
    echo "the pacient is not validated";
}*/

?>