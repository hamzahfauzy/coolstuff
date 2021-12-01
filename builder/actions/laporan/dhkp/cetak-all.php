<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$query = "SELECT * FROM TEMP_DHKP ORDER BY THN_PAJAK,KD_KECAMATAN,KD_KELURAHAN,NOPQ ASC";

$datas = $qb->rawQuery($query)->get();

