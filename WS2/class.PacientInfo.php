<?php

/**
 * SE-Project - WS2\class.PacientInfo.php
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
 * include WS2_Pacient
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.Pacient.php');

/* user defined includes */
require_once('lib/functions.php');

/**
 * stores an the url of an activity of a pacient
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS2
 */
class WS2_PacientInfo
{

    /**
     * activity url
     *
     * @access private
     * @var String
     */
    private $url = null;

    /**
     * username of a pacient
     *
     * @access private
     * @var String
     */
    private $pacient = null;

    /**
     * name of the activity
     *
     * @access private
     * @var String
     */
    private $activityName = null;
	
	/**
     * method of nusoap call
     *
     * @access private
     * @var String
     */
    private $method = null;
	
	/**
     * param of nusoap call
     *
     * @access private
     * @var String
     */
    private $param = null;
	
	/**
     * type of webservice return (json, xml or soap)
     *
     * @access private
     * @var String
     */
    private $typeWS = null;
	
	
    public function __construct($pacient,$activity,$url,$typeWS=null,$method=null,$param=null) {
        $this->pacient=$pacient;
        $this->activityName=$activity;
        $this->url=$url;
		$this->method=$method;
		$this->param=$param;
		$this->typeWS=$typeWS;
    }
	
	public function getPacient()
	{
		return $this->pacient;
	}
	
	public function getActivityName()
	{
		return $this->activityName;
	}
	
	public function getUrl()
	{
		return $this->url;
	}
	
	public function getToken()
	{
		return $this->token;
	}
	
	public function getMethod()
	{
		return $this->method;
	}
	
	public function getParam()
	{
		return $this->param;
	}
	
	public function getTypeWS()
	{
		return $this->typeWS;
	}
	/**
 * insert the activity in the ws2 database
 *
 * @author firstname and lastname of author, <author@example.org>
 * return String
 */
	public function insertPacientInfo(){
		if($this->getTypeWS()=='soap'){
			$query = "insert into pacient_info (pacient, activityName, url,method,param,typeWS) values (?,?,?,?,?,?)";
			$result = queryMysqli($query, array($this->getPacient(), $this->getActivityName(), $this->getUrl(),$this->getMethod(),$this->getParam(),$this->getTypeWS()));
		}else{
			$query = "insert into pacient_info (pacient, activityName, url,typeWS) values (?,?,?,?)";
			$result = queryMysqli($query, array($this->getPacient(), $this->getActivityName(), $this->getUrl(),$this->getTypeWS()));
		}
        if ($result->rowCount() > 0) {
            return 'pacient info was registered';
        }
        return 'pacient info was not registered';
	}

/**
 * get the numeric id of an pacient's activity in the ws2 database
 *
 * @author firstname and lastname of author, <author@example.org>
 * @param  String pacient
 * @param  String activityName
 * return Integer
 */
	
	public static function getPacientInfo($pacient, $activityName){
		$activityQuery='select id from pacient_info where pacient=? and activityName=?';
		$result=queryMysqli($activityQuery,array($pacient,$activityName));
		if ($result->rowCount() > 0) {
			$object=$result->fetchObject();
			return $object->id;
		}
		return null;
	}
	
/**
 * get the url of an activity registered into the ws2 database
 *
 * @author firstname and lastname of author, <author@example.org>
 * @param  id pacientInfo
 * return String
 */
	
	public static function getUrlId($pacientInfo){
		$query='select url from pacient_info where id=?';
		$result=queryMysqli($query,array($pacientInfo));
		$object=$result->fecthObject();
		return $object->url;
	}
	
	public static function getTypeWSById($pacientInfo){
		$query='select typeWS from pacient_info where id=?';
		$result=queryMysqli($query,array($pacientInfo));
		$object=$result->fecthObject();
		return $object->typeWS;
	}
	
	public static function getPacientInfoObj($id){
		$query='select * from pacient_info where id=?';
		$result=queryMysqli($query,array($id));
		
		$object=$result->fetchObject();
		
		return new WS2_PacientInfo($object->pacient,$object->activityName ,$object->url ,$object->typeWS,$object->method ,$object->param);
	}
} /* end of class WS2_PacientInfo */

/*
$act=new WS2_PacientInfo('sfhsgfhfd','corre','wwww.teste.com');
print_r($act);*/
//echo $act->getPacient().' '.$act->getActivityName().' '.$act->getUrl();
//$result=WS2_PacientInfo::getPacientInfo('pc1','corre');
//echo $result;
/*
$pacientInfo=WS2_PacientInfo::getPacientInfoObj(1);
$param=explode(";",$pacientInfo->getParam());
echo $param[2];
*/
/*
$pacientInfo=WS2_PacientInfo::getPacientInfo('un1','teste');
if($pacientInfo==null){
	echo 'fail';
}else{
	echo 'ok';
}*/





?>