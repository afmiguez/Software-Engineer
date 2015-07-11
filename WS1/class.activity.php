<?php

/**
 * SE-Project - WS1\class.activity.php
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

/* user defined includes */
require_once "lib/functions.php";

/**
 * Represents an activity of webservice 1
 *
 * @access public
 * @author firstname and lastname of author, <author@example.org>
 * @package WS1
 */
class WS1_activity {
    // --- ATTRIBUTES ---

    /**
     * Username of the activity
     *
     * @access private
     * @var String
     */
    private $username = null;

    /**
     * Short description of attribute start
     *
     * @access private
     * @var date
     */
    private $start = null;

    /**
     * Short description of attribute end
     *
     * @access private
     * @var Date
     */
    private $end = null;

    /**
     * Short description of attribute name
     *
     * @access private
     * @var String
     */
    private $activityName = null;

    // --- OPERATIONS ---

    public function __construct($username, $start, $end, $activityName) {
        $this->username = $username;
        $this->start = $start;
        $this->end = $end;
        $this->activityName = $activityName;
    }
	
	public function getUsername(){
		return $this->username;
	}
	
	public function getStart(){
		return $this->start;
	}
	
	public function getEnd(){
		return $this->end;
	}
	
	public function getActivityName(){
		return $this->activityName;
	}

    /**
     * an WS1_Activity will try to insert itself into the database
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @return Boolean
     */
    public function insertActivity() {
        $query = "insert into activity (username,start,end,name) values (?,?,?,?)";
        $result = queryMysqli($query, array($this->getUsername(), $this->getStart(), $this->getEnd(), $this->getActivityName()));
        if ($result->rowCount() > 0) {
            return true;
        }
        return false;
    }
	
	/**
     * query an activity by username and name of the activity
     *
     * @access public
     * @author firstname and lastname of author, <author@example.org>
     * @param  String username
     * @param  String activityName
     * @return Array
     */
    public static function queryActivity($username,$activityName) {
        $query = "select *  from activity where username=? and name=?";
        $queryResult=array();
        $result = queryMysqli($query, array($username, $activityName));
        if ($result->rowCount() < 1) {
            return null;
        } else {
            for ($i = 0; $i < $result->rowCount(); $i++) {
                $object = $result->fetchObject();
                array_push($queryResult, $object->username . ' ' . $object->name . ' ' . $object->start . ' ' . $object->end . ' ');
            }
        }
        return $queryResult;
    }
}


/*
$a=new WS1_activity('123','1990-01-01','1990-01-02','teste');
//print_r($a);
$result=$a->insertActivity();
if($result)
{
	echo 'is inserted';
}
else
{
	echo 'is not inserted';
}
*/
/*
echo 'teste';
$result=WS1_activity::queryActivity('un40','testa');
print_r($result);
*/

/* end of class WS1_activity */
?>