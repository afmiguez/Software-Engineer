<form action="insertActivity.php" method="get">
    <label> <span>Username</span><input type="text" name="username" value=""/></label>
    <label> <span>Start</span><input type="text" name="start" value=""/></label>
    <label> <span>End</span><input type="text" name="end" value=""/></label>
    <label> <span>Name</span><input type="text" name="name" value=""/></label>
    <label> <span>Token</span><input type="text" name="token" value=""/></label>
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

if(get('username')==''){
    exit;
}

$client = new nusoap_client("http://localhost/ES-Project/WS1/class.webservice.php");

$username=get('username');
$start=get('start');
$end=get('end');
$name=get('name');
$token=get('token');

$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$result = $client->call('WS1_webservice.createUserActivity', array('username' => $username, 'start' => $start, 'end' => $end, 'activityName' => $name,'token'=>$token));


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
