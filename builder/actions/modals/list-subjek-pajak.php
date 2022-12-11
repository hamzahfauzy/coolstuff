<?php


if(isset($_GET['search'])){

    require '../helpers/QueryBuilder.php';

    $qb = new QueryBuilder();

    $StringQ = "select * from DAT_SUBJEK_PAJAK where NM_WP LIKE '" . "%" . trim($_GET['search']) . "%'";

    $data = $qb->rawQuery($StringQ)->get();

    echo json_encode($data);

    die;
}


