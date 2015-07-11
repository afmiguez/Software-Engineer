<form action="interfaceCaretaker.php" method="get">

    <label> <span>First Name</span><input type="text" name="firstname" value=""/></label>
    <label> <span>Last Name</span><input type="text" name="lastname" value=""/></label>
    <label> <span>User Name</span><input type="text" name="username" value=""/></label>
    <label> <span>Birthdate</span><input type="text" name="birthdate" value=""/></label>
    <label> <span>Male</span><input type="radio" name="gender" value="m"/></label>
    <label> <span>Female</span><input type="radio" name="gender" value="f"/></label>
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

$client = new nusoap_client("http://localhost/ES-Project/WS2/class.Webservice.php");

$firstname = get('firstname');
$lastname = get('lastname');
$username = get('username');
$birthdate = get('birthdate');
$gender = get('gender');

$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

//calls the WS using a
$result = $client->call('WS2_Webservice.registerCaretaker', array('firstname' => $firstname, 'lastname' => $lastname, 'username' => $username, 'birthdate' => $birthdate, 'gender' => $gender));

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
