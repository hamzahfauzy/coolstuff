<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$datas = $qb->select("REF_KECAMATAN")->get();
