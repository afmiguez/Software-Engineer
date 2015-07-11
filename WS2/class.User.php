<?php

error_reporting(E_ALL);

/**
 * SE-Project - WS2\class.User.php
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
 * a generic user for the webservice 2
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS2
 */
class WS2_User {

    /**
     * WS2_User firstname
     *
     * @access public
     * @var String
     */
    private $firstname = null;

    /**
     * WS2_User lastname
     *
     * @access public
     * @var String
     */
    private $lastname = null;

    /**
     * WS2_User username
     *
     * @access public
     * @var String
     */
    private $username = null;

    /**
     * WS2_User token
     *
     * @access public
     * @var String
     */
    private $token = null;

    /**
     * WS2_User birthdate
     *
     * @access public
     * @var String
     */
    private $birthdate = null;

    /**
     * WS2_User gender
     *
     * @access public
     * @var char
     */
    private $gender = '';

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
     * constructor for a WS2_User
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String firstname
     * @param  String lastname
     * @param  String username
     * @param  String birthdate
     * @param  char gender
     */
    public function __construct($firstname, $lastname, $username, $birthdate, $gender) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->username = $username;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
    }

}

/* end of class WS2_User */
?>