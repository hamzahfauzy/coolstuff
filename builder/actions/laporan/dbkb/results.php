<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$qb = new QueryBuilder();

extract($_GET);

if(isset($mode) && $mode == 'cek_cetak')
{
    echo json_encode([
        'status'=>'success',
        'message'=>'',
        'type'=>$type
    ]);
    die();

}

