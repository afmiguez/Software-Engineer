<form action="interfaceInsertInfoLocation.php" method="get">
    <label> <span>Pacient</span><input type="text" name="pacient" value=""/></label>
    <label> <span>Token</span><input type="text" name="pacientToken" value=""/></label>
	<label> <span>Username WS</span><input type="text" name="wsUsername" value=""/></label>
    <label> <span>Token WS</span><input type="text" name="wsToken" value=""/></label>
    <label> <span>Activity Name</span><input type="text" name="activityName" value=""/></label>
    <label> <span>Url</span><input type="text" name="url" value=""/></label>
    <input id="submit" type="submit" value="submit"/>
</form>

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
require_once "../lib/nusoap.php";
require_once "lib/functions.php";

if(get('pacient')==''){
    exit;
}


$client = new nusoap_client("http://localhost/ES-Project/WS2/class.Webservice.php");

echo 'teste';

$pacient= get('pacient');
$pacientToken = get('pacientToken');
$wsUsername=get('wsUsername');
$wsToken=get('wsToken');
$activityName = get('activityName');
$url = urlencode(get('url'));

$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//calls the WS using a
$result = $client->call('WS2_Webservice.insertInfoLocation', array('pacient' => $pacient, 'pacientToken' => $pacientToken,'wsUsername' => $wsUsername,'wsToken' => $wsToken, 'activityName' => $activityName, 'url' => $url));

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
