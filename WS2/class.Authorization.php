<?php

/**
 * SE-Project - WS2\class.Authorization.php
 *
 * $Id$
 *
 * This file is part of SE-Project.
 *
 * Automatically generated on 09.01.2015, 14:55:15 with ArgoUML PHP module 
 * (last revised $Date: 2010-01-12 20:14:42 +0100 (Tue, 12 Jan 2010) $)
 *
 * @author firstname and lastname of author, <author@example.org>
 * @package WS2
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

/**
 * include WS2_Caretaker
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.Caretaker.php');

/**
 * include WS2_PacientInfo
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.PacientInfo.php');


/* user defined includes */
require_once('lib/functions.php');


/**
 * link a given caretaker to a pacient activity into the database
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS2
 */
class WS2_Authorization
{
    /**
     * id of pacient activity into the ws2 database
     *
     * @access private
     * @var Integer
     */
    private $pacient_info_id = null;

    /**
     * Short description of attribute caretaker
     *
     * @access private
     * @var String
     */
    private $caretaker = null;

    // --- OPERATIONS --
	public function getPacientInfoId(){
		return $this->pacient_info_id;
	}
	
	public function getCaretaker(){
		return $this->caretaker;
	}
	
/**
 * authorize a caretaker to have access to a pacient activity
 *
 * @author firstname and lastname of author, <author@example.org>
 * @param  String caretaker
 * @param  Integer pacientInfo
 * return String
 */
	public static function authorizeCaretaker($caretaker,$pacientInfo){
		$query = 'insert into authorization (pacient_info,caretaker) values (?,?)';	
		$result=queryMysqli($query,array($pacientInfo,$caretaker));
		if ($result->rowCount() > 0) {
			return "the caretaker '".$caretaker."' was successfully authorized";
		}
		return "the caretaker '".$caretaker."' could not be authorized";		
	}
	
	/**
 * check if a caretaker is authorized to access a pacient activity
 *
 * @author firstname and lastname of author, <author@example.org>
 * @param  String caretaker
 * @param  Integer pacientInfo
 * return String
 */
	
	public static function isCaretakerAuthorized($pacientInfo,$caretaker){
		$query='select * from authorization where pacient_info=? and caretaker=?';
		$result=queryMysqli($query,array($pacientInfo,$caretaker));
		if ($result->rowCount() > 0) {
			return true;
		}
		return false;
	}

} /* end of class WS2_Authorization */
/*
$auth=WS2_Authorization::isCaretakerAuthorized(1,'ct4');
if($auth){
echo'ok';
}
else{
echo 'no';
}
*/



?>