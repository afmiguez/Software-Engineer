<form action="interfaceAccessInfo.php" method="get">

	<label> <span>Caretaker</span><input type="text" name="caretaker" value=""/></label>
	<label> <span>Token</span><input type="text" name="token" value=""/></label>
    <label> <span>Pacient</span><input type="text" name="pacient" value=""/></label>
    <label> <span>Activity</span><input type="text" name="activity" value=""/></label>
    
    <input id="submit" type="submit" value="submit"/>
</form>

<?php

require_once "../lib/nusoap.php";
require_once "lib/functions.php";

if(get('caretaker')==''){
    exit;
}

$client = new nusoap_client("http://localhost/ES-Project/WS2/class.Webservice.php");

$caretaker=get('caretaker');
$token=get('token');
$pacient=get('pacient');
$activityName=get('activity');

$err = $client->getError();

if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//calls the WS using a
$result = $client->call('WS2_Webservice.accessInfoLocation', array('caretaker' => $caretaker, 'token'=>$token, 'pacient' => $pacient, 'activityName' => $activityName));

/*
echo '<h2>Result</h2><pre>';
print_r($result);
*/


// Check for a fault
if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        // Display the result
        echo '<h2>Result</h2><pre>';
        print_r($result);
    echo '</pre>';
    }
}

/*
// Display the request and response
echo '<h2>Request</h2>';
echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2>';
echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
// Display the debug messages
echo '<h2>Debug</h2>';
echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
*/


?>