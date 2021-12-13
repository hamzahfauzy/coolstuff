<?php

require '../helpers/QueryBuilder.php';
$qb = new QueryBuilder();
$builder = new Builder;
$installation = $builder->get_installation();
$last_year = $_POST['tahun_pajak'];
$first_year = $last_year-4;
$in_year = [];
for($i=$first_year;$i<=$last_year;$i++)
{
    $in_year[] = $i;
}
$in_year = implode(",",$in_year);

if(isset($_POST['NOP']))
    $query = "SELECT * FROM QOBJEKPAJAK WHERE NOPQ = '$_POST[NOP]'";
else
    $query = "SELECT * FROM QOBJEKPAJAK WHERE KD_KECAMATAN = '$_POST[KD_KECAMATAN]' AND KD_KELURAHAN = '$_POST[KD_KELURAHAN]'";
$datas = $qb->rawQuery($query)->get();

if(isset($_GET['check']))
{
    echo json_encode(['count'=>count($datas)]);
    die();
}


$C_STR = "SELECT * FROM PEJABAT";
$pejabat = $qb->rawQuery($C_STR)->get();
foreach($pejabat as $pj)
{
    $xNIP = $pj['NIP'];
    $xNama = $pj['NAMA'];
    $xJabatan = $pj['JABATAN'];
}
