<?php

require '../helpers/QueryBuilder.php';

$mysql = new QueryBuilder("mysql");
$mysql2 = new QueryBuilder("mysql");

if(isset($_GET['act'])) {
   switch ($_GET['act']) {

    case 'accept':
        
        $mysql->update('esppt', ['STATUS'=>'DITERIMA'])->where('ID',$_GET['act_id'])->exec();
        break;
    case 'reject':
        
        $mysql->update('esppt', ['STATUS'=>'DITOLAK'])->where('ID',$_GET['act_id'])->exec();
        break;
   }

    header('Location:index.php?page=builder/pendaftaran/e-sppt/index');
    return;
}

$msg = get_flash_msg('success');

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$query = "select * from esppt";
$limits = $mysql2->select("esppt","count(*) as count");

if(isset($_GET['filter'])){
    if($_GET['nama']){
        $query .= " NAMA_WAJIB_PAJAK like %$_GET[nama]%";
        $limits->where('NAMA_WAJIB_PAJAK',"%".$_GET['nama']."%",'like');
    }

}

$query .= " order by NAMA_WAJIB_PAJAK";

$datas = $mysql->rawQuery($query)->get();
$limits = $limits->first();