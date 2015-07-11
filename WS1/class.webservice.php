<?php

/**
 * SE-Project - WS1\class.webservice.php
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

/**
 * include WS1_activity
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.activity.php');

/**
 * include WS1_user
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once('class.user.php');

/* user defined includes */
/**
 * include nusoap library
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once "../lib/nusoap.php";

/**
 * include our library with some DB functions
 *
 * @author firstname and lastname of author, <author@example.org>
 */
require_once "lib/functions.php";
// section -64--88-56-1--10f7481:14a38f381b0:-8000:0000000000000A73-includes end

/**
 * Short description of class WS1_webservice
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS1
 */
class WS1_webservice {

    public $server = NULL;

    public function __construct() {
        // Create the server instance
        $this->server = new nusoap_server();
        // Define the method as a PHP function
    }

    /**
     * create an WS1_user object and make register itself. will return either a token or a message of error
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
	 * @param  String firstname
	 * @param  String lastname
     * @param  String username
     * @param  String birthdate
     * @param  char gender
     * @return WS1_xml
     */
    public function createUser($firstname, $lastname, $username, $birthdate, $gender) {
		$user=new WS1_user($firstname,$lastname,$username,$birthdate,$gender);
        $token = $user->registerUser();
        return $token;
    }

    /**
     * create an WS1_activity after check if the user exists, and the given token is valid
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String username
     * @param  String start
     * @param  String end
     * @param  String activityName
	 * @param  String token
     * @return mixed
     */
    public function createUserActivity($username, $start, $end, $activityName, $token) {
		$exists=WS1_user::existUser($username);
		if(!$exists)
		{
			return "there's not that user";
		}
		$validate=WS1_user::validateUser($username, $token);
		if (!$validate) 
		{
            return "invalid token";
        }
        $activity = new WS1_activity($username, $start, $end, $activityName);
        $result = $activity->insertActivity();
        if ($result) {
            return "activity successfully inserted";
        }
        return "activity could not be inserted";
    }

    /**
     * get an array of WS1_activity objects
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
	 * @param  String username
     * @param  String activityName
	 * @param  String token
     * @return Array
     */
    public function getUserQuery($username, $activityName, $token) {
		
		$exists=WS1_user::existUser($username);
        if (!$exists){
			return array("there's not that user");
		}
		$validate=WS1_user::validateUser($username, $token);
		if (!$validate){
            return array("invalid token");
        }
        $result=WS1_activity::queryActivity($username, $activityName);
        if($result==null){
            return array("There's no activity with that name");
        }
        else{
            return $result;
        }
    }

    // Register the method to expose
    public function registerMethod($nameMethod) {
        $this->server->register($nameMethod);
    }

    // Use the request to (try to) invoke the service
    public function processRequest() {
        $this->server->service($GLOBALS['HTTP_RAW_POST_DATA']);
    }
}

/* end of class WS1_webservice */


$ws = new WS1_webservice();
$ws->registerMethod('WS1_webservice.createUser');
$ws->registerMethod('WS1_webservice.createUserActivity');
$ws->registerMethod('WS1_webservice.getUserQuery');

$namespace = "http://localhost/ES-Project/WS1/class.webservice.php";

$ws->server->configureWSDL('projectWS1', 'urn:projectWS1wsdl');
$ws->server->wsdl->schemaTargetNamespace = $namespace;

$ws->server->wsdl->addComplexType('query', 'complexType', 'array', 'sequence', '', array('result' => array('name' => 'result', 'type' => 'xsd:string')));

//register webservice documentation
$ws->server->register('WS1_webservice.createUser', // method name
        array('firstname' => 'xsd:string', 'lastname' => 'xsd:string', 'username' => 'xsd:string', 'date' => 'xsd:string', 'gender' => 'xsd:char'), // input parameters
        array('return' => 'xsd:string'), // output parameters
        'urn:projectWS1', // namespace
        'urn:projectWS1wsdl#createUser', // soapaction
        'rpc', // style
        'encoded', // use
        'register a new user'            // documentation
);

$ws->server->register('WS1_webservice.createUserActivity', // method name
        array('username' => 'xsd:string', 'start' => 'xsd:string', 'end' => 'xsd:string', 'activtyName' => 'xsd:string', 'token' => 'xsd:string'), // input parameters
        array('return' => 'xsd:string'), // output parameters
        'urn:projectWS1', // namespace
        'urn:projectWS1wsdl#createUserActivity', // soapaction
        'rpc', // style
        'encoded', // use
        'register a new activity'            // documentation
);

$ws->server->register('WS1_webservice.getUserQuery', // method name
        array('username' => 'xsd:string', 'name' => 'xsd:string', 'token' => 'xsd:string'), // input parameters
        array('return' => 'tns:query'), // output parameters
        'urn:projectWS1', // namespace
        'urn:projectWS1wsdl#getUserQuery', // soapaction
        'rpc', // style
        'encoded', // use
        'return an activity query'            // documentation
);

$ws->processRequest();

?>