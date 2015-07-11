<?php

/**
 * SE-Project - WS1\class.user.php
 *
 * $Id$
 *
 * This file is part of SE-Project.
 *
 * Automatically generated on 13.12.2014, 13:01:03 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author firstname and lastname of author, <author@example.org>
 * @package WS1
 */
 
if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

require_once "lib/functions.php";

/* user defined includes */
require_once "lib/functions.php";


/**
 * Represents an user of webservice 1
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS1
 */

class WS1_user {
    

    /**
     * user firstname
     *
     * @access private
     * @var String
     */
    private $firstname = null;

    /**
     * user lastname
     *
     * @access private
     * @var String
     */
    private $lastname = null;

    /**
     * username
     *
     * @access private
     * @var String
     */
    private $username = null;

    /**
     * user token
     *
     * @access private
     * @var String
     */
    private $token = null;

    /**
     * user birthdate
     *
     * @access private
     * @var String
     */
    private $birthdate = null;

    /**
     * user gender
     *
     * @access private
     * @var char
     */
    private $gender = '';

    // --- OPERATIONS ---

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function getGender() {
        return $this->gender;
    }
	
    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    /**
     * Constructor for the WS1_user class
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String firstname
     * @param  String lastname
     * @param  String username
     * @param  String birthdate
     * @param  char gender
     * 
     */
    public function __construct($firstname, $lastname, $username, $birthdate, $gender) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
    }

    /**
     * a WS1_user object will try to insert itself in the database and will return either its token or an error message
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String firstname
     * @param  String lastname
     * @param  String username
     * @param  String birthdate
     * @param  char gender
     * @return String
     */
    public function registerUser(){
        $this->setToken(sha1($this->getFirstname().$this->getLastname().$this->getUsername().time()));
		$query = "insert into user (firstname,lastname,username,token,birthdate,gender) values (?,?,?,?,?,?)";
		$result = queryMysqli($query, array($this->getFirstname(), $this->getLastname(), $this->getUsername(), $this->getToken(), $this->getBirthdate(), $this->getGender()));
        if ($result->rowCount() > 0) {
            return $this->getToken();
        }
        return 'could not register';
    }
	
	/**
     * validates an user with its username and token
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String username
     * @param  String token
     * @return Boolean
     */
	
    public static function validateUser($username,$token) {
        $query = "select * from user where username=? and token=?";
        $result = queryMysqli($query, array($username,$token));
        if ($result->rowCount() > 0) {
            return true;
        }
        return false;
    }
	
	/**
     * checks if a given user exists in the database
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String username
     * @param  String token
     * @return Boolean
     */
	
	public static function existUser($username){
        $query='select * from user where username=?';
        $result= queryMysqli($query, array($username));
        if ($result->rowCount() > 0) {
            return true;
        }
        return false;
    }
}


/* end of class WS1_user */

/*
$a = new WS1_user("fn1", "ln1", "123", "1990-01-01", "m");
print_r($a);
$token=$a->registerUser();
echo $token;
*/
/*
$result=WS1_user::validateUser('123',$token);
if($result)
{
	echo 'is validated';
}
else
{
	echo 'is not validated';
}

*/

?>