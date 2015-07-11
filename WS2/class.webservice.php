<?php
/**
 * SE-Project - WS2\class.Webservice.php
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
 * include WS2_Caretaker
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.Caretaker.php');

/**
 * include WS2_Pacient
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.Pacient.php');

/**
 * include WS2_PacientInfo
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.PacientInfo.php');

/**
 * include WS2_Authorization
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.Authorization.php');

/* user defined includes */

require_once "../lib/nusoap.php";
require_once "lib/functions.php";


/**
 * Short description of class WS2_Webservice
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS2
 */
 
class WS2_Webservice
{
    public $server = NULL;

    public function __construct() {
        // Create the server instance
        $this->server = new nusoap_server();
        // Define the method as a PHP function
    }

    /**
     * try to register a pacient, and return either the token or an error message
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
    public function registerPacient($firstname, $lastname, $username, $birthdate, $gender)
    {
        $pacient=new WS2_Pacient($firstname,$lastname,$username,$birthdate,$gender);
        $token = $pacient->registerPacient();
        return $token;
    }

    /**
     * try to register a caretaker, and return either the token or an error message
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
    public function registerCaretaker($firstname, $lastname, $username, $birthdate, $gender)
    {
        $caretaker=new WS2_Caretaker($firstname,$lastname,$username,$birthdate,$gender);
        $token = $caretaker->registerCaretaker();
        return $token;
    }

    /**
     * insert an pacient activity location after validate its token. return a message of error or success
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String pacient
	 * @param  String token
     * @param  String activityName
	 * @param  String url
     * @return String
     */
    public function insertInfoLocation($pacient,$pacientToken,$wsUsername,$wsToken,$activityName,$url)
    {
		$validate=WS2_Pacient::validatePacient($pacient,$pacientToken);
		if(!$validate){
			return 'the token is invalid';
		}
		
		if(urldecode($url)=='http://localhost/ES-Project/WS1/class.webservice.php'){
			$method='WS1_webservice.getUserQuery';
			$param=$pacient.';'.$activityName.';'.$wsToken;
			$typeWS='soap';
			
			$pacientInfo=new WS2_PacientInfo($pacient,$activityName,$url,$typeWS,$method,$param);
			$returnValue=$pacientInfo->insertPacientInfo();
			return $returnValue;	
		}
		$type='json';
		$pacientInfo=new WS2_PacientInfo($pacient,$activityName,$url,$type);
		$returnValue=$pacientInfo->insertPacientInfo();
		return $returnValue;
		
    }
	
	/**
     * authorize a caretaker to have access to pacient info after validate the pacient, check if the caretaker is in the webservice database and if there's an activity registered. return either a message of error or success
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String pacient
	 * @param  String token
     * @param  String activityName
	 * @param  String caretaker
     * @return String
     */
	
	public function authorizeCaretaker($pacient,$token,$activityName,$caretaker){
		$validate=WS2_Pacient::validatePacient($pacient,$token);
		if(!$validate){
			return 'the token is invalid';
		}
		
		$existCT=WS2_Caretaker::existCaretaker($caretaker);
		if(!$existCT){
			return 'the caretaker is not registered';
		}
		
		$pacientInfo=WS2_PacientInfo::getPacientInfo($pacient,$activityName);
		if($pacientInfo==null){
			return "there's not the activity '".$activityName."' for the pacient ".$pacient;
		}
		
		return WS2_Authorization::authorizeCaretaker($caretaker,$pacientInfo);
	}

    /**
     * Short description of method accessInfoLocation
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String caretaker
     * @param  String pacient
     * @param  String activityName
     * @return WS1_Array
     */
	 
    public function accessInfoLocation($caretaker,$token, $pacient, $activityName)
    {	
		$validate=WS2_Caretaker::validateCaretaker($caretaker,$token);
		if(!$validate){
			return array('the token is invalid');
		}
	
		$pacientInfo=WS2_PacientInfo::getPacientInfo($pacient,$activityName);
		if($pacientInfo==null){
			return array("there's no '".$activityName."' information for '".$pacient."'");
		}
		$authorization=WS2_Authorization::isCaretakerAuthorized($pacientInfo,$caretaker);
		if(!$authorization){
			return array("caretaker '".$caretaker."' is not authorized");
		}
		
		$pacientInfoObj=WS2_PacientInfo::getPacientInfoObj($pacientInfo);
		//return array($pacientInfoObj->getParam());
		if($pacientInfoObj->getTypeWS()=='soap'){
			$client = new nusoap_client(urldecode($pacientInfoObj->getUrl()));
			$param=explode(";",$pacientInfoObj->getParam());
			$result = $client->call($pacientInfoObj->getMethod(), array('username' => $param[0], 'name'=>$param[1],'token' =>$param[2]));	
			return $result;
		}
		$content=file_get_contents(urldecode($pacientInfoObj->getUrl())); //faz get do conteúdo da url
		$parse=json_decode($content);
		//$parse=$content;
		$result=array();
		foreach ($parse->data as $line){
			array_push($result,$line);
		}
		return $result;
		
		//return array($parse);
    }
	
	// Register the method to expose
    public function registerMethod($nameMethod) {
        $this->server->register($nameMethod);
    }

    // Use the request to (try to) invoke the service
    public function processRequest() {
        $this->server->service($GLOBALS['HTTP_RAW_POST_DATA']);
    }


} /* end of class WS2_Webservice */


$ws = new WS2_Webservice();
$ws->registerMethod('WS2_Webservice.registerPacient');
$ws->registerMethod('WS2_Webservice.registerCaretaker');
$ws->registerMethod('WS2_Webservice.insertInfoLocation');
$ws->registerMethod('WS2_Webservice.authorizeCaretaker');
$ws->registerMethod('WS2_Webservice.accessInfoLocation');

$namespace = "http://localhost/ES-Project/WS2/class.Webservice.php";

$ws->server->configureWSDL('projectWS2', 'urn:projectWS2wsdl');
$ws->server->wsdl->schemaTargetNamespace = $namespace;

$ws->server->wsdl->addComplexType('query', 'complexType', 'array', 'sequence', '', array('result' => array('name' => 'result', 'type' => 'xsd:string')));

//register webservice documentation
$ws->server->register('WS2_Webservice.registerPacient', // method name
        array('firstname' => 'xsd:string', 'lastname' => 'xsd:string', 'username' => 'xsd:string', 'date' => 'xsd:string', 'gender' => 'xsd:char'), // input parameters
        array('return' => 'xsd:string'), // output parameters
        'urn:projectWS2', // namespace
        'urn:projectWS2wsdl#registerPacient', // soapaction
        'rpc', // style
        'encoded', // use
        'register a new pacient'            // documentation
);

$ws->server->register('WS2_Webservice.registerCaretaker', // method name
        array('firstname' => 'xsd:string', 'lastname' => 'xsd:string', 'username' => 'xsd:string', 'date' => 'xsd:string', 'gender' => 'xsd:char'), // input parameters
        array('return' => 'xsd:string'), // output parameters
        'urn:projectWS2', // namespace
        'urn:projectWS2wsdl#registerCaretaker', // soapaction
        'rpc', // style
        'encoded', // use
        'register a new caretaker'            // documentation
);

$ws->server->register('WS2_Webservice.insertInfoLocation', // method name
        array('pacient' => 'xsd:string', 'token' => 'xsd:string', 'activityName' => 'xsd:string','url' => 'xsd:string'), // input parameters
        array('return' => 'xsd:string'), // output parameters
        'urn:projectWS2', // namespace
        'urn:projectWS2wsdl#insertInfoLocation', // soapaction
        'rpc', // style
        'encoded', // use
        'insert a new address for a pacient information'            // documentation
);

$ws->server->register('WS2_Webservice.authorizeCaretaker', // method name
        array('pacient' => 'xsd:string', 'token' => 'xsd:string', 'activityName' => 'xsd:string','caretaker' => 'xsd:string'), // input parameters
        array('return' => 'xsd:string'), // output parameters
        'urn:projectWS2', // namespace
        'urn:projectWS2wsdl#authorizeCaretaker', // soapaction
        'rpc', // style
        'encoded', // use
        'authorize a caretaker to a given pacient information'            // documentation
);

$ws->server->register('WS2_Webservice.accessInfoLocation', // method name
        array('caretaker' => 'xsd:string','token' => 'xsd:string', 'pacient' => 'xsd:string','activityName' => 'xsd:string'), // input parameters
		array('return' => 'tns:query'), // output parameters
        'urn:projectWS2', // namespace
        'urn:projectWS2wsdl#accessInfoLocation', // soapaction
        'rpc', // style
        'encoded', // use
        'return a pacient information'            // documentation
);

$ws->processRequest();

/*
$result=$ws->accessInfoLocation('ct1','f06f319954148ee30fd52a8640b22157d65578df','un1','corre');
print_r($result);
*/



?>