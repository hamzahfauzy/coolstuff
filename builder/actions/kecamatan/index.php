<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$datas = $qb->select("REF_KECAMATAN")->get();
