<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$datas = $qb->select("WEWENANG");

if(isset($_GET['filter'])){

    if($_GET['roles']){
        $datas->where('NM_WEWENANG',"%".$_GET['roles']."%",'like');
    }

}

$datas = $datas->get();
