<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$datas = $qb->select("PEJABAT");


if(isset($_GET['filter'])){

    if($_GET['pejabat']){
        $datas->where('NAMA',"%".$_GET['pejabat']."%",'like');
    }

}

$datas = $datas->get();
