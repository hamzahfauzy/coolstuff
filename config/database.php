<?php
$serverName = "localhost"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array( "Database"=>"dbpajak", "UID"=>"PBBQ", "PWD"=>"0134");
$conn = sqlsrv_connect( $serverName, $connectionInfo);