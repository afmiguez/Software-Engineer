<form action="interfaceAuthorizeCaretaker.php" method="get">
	<label> <span>Pacient</span><input type="text" name="pacient" value=""/></label>
	<label> <span>Token</span><input type="text" name="token" value=""/></label>
    <label> <span>Activity</span><input type="text" name="activity" value=""/></label>
	<label> <span>Caretaker</span><input type="text" name="caretaker" value=""/></label>
    
    <input id="submit" type="submit" value="submit"/>
</form>

<?php


require_once "../lib/nusoap.php";
require_once "lib/functions.php";

if(get('pacient')==''){
    exit;
}

$client = new nusoap_client("http://localhost/ES-Project/WS2/class.Webservice.php");

//$content=file_get_contents($url);
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
$result = $client->call('WS2_Webservice.authorizeCaretaker', array('pacient' => $pacient, 'token'=>$token,  'activityName' => $activityName,'caretaker' => $caretaker));

echo '<h2>Result</h2><pre>';
print_r($result);

/*
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
*/

?>