<?php
$server_name = $_SERVER['HTTP_HOST'];
$local_name = ['localhost','localhost:8000'];
$live_name = ['pbb.z-techno.com','z-techno.com'];
$stagging_name = ['127.0.0.1'];
$bpkad_test = '192.168.43.46';

// local
if (in_array($server_name,$local_name)) {
     $serverName = "localhost"; //serverName\instanceName, portNumber (default is 1433)
     $connectionInfo = array( "Database"=>"dbpajak", "UID"=>"PBBQ", "PWD"=>"0134");
}else

if (in_array($server_name,$stagging_name)) {
     $serverName = "103.15.242.196"; //serverName\instanceName, portNumber (default is 1433)
     $connectionInfo = array( "Database"=>"dbpajak", "UID"=>"SA", "PWD"=>"bappeda@4321");
}else

if (in_array($server_name,$live_name)) {
     $serverName = "127.0.0.1"; //serverName\instanceName, portNumber (default is 1433)
     $connectionInfo = array( "Database"=>"new_dbpajak", "UID"=>"SA", "PWD"=>"bappeda@4321");
}else{
     $serverName = "localhost"; //serverName\instanceName, portNumber (default is 1433)
     $connectionInfo = array( "Database"=>"dbpajak", "UID"=>"SA", "PWD"=>"bpkad@4321");
}
$conn = sqlsrv_connect( $serverName, $connectionInfo);