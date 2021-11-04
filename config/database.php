<?php
$server_name = $_SERVER['HTTP_HOST'];

if ($server_name == "localhost") {
     $serverName = "localhost"; //serverName\instanceName, portNumber (default is 1433)
     $connectionInfo = array( "Database"=>"dbpajak", "UID"=>"PBBQ", "PWD"=>"0134");
} else {
     $serverName = "103.15.242.196"; //serverName\instanceName, portNumber (default is 1433)
     $connectionInfo = array( "Database"=>"dbpajak", "UID"=>"SA", "PWD"=>"bappeda@4321");
}
$conn = sqlsrv_connect( $serverName, $connectionInfo);