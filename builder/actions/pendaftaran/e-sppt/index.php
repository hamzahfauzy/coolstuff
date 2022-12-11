<?php

require '../helpers/QueryBuilder.php';

$mysql = new QueryBuilder("mysql");
$mysql2 = new QueryBuilder("mysql");

if(isset($_GET['act'])) {
   $data = $mysql->select("esppt")->where('ID',$_GET['act_id'])->first();
   switch ($_GET['act']) {
       
       case 'accept':
        
        $mysql->update('esppt', ['STATUS'=>'DITERIMA'])->where('ID',$_GET['act_id'])->exec();
        if (filter_var($data['EMAIL'], FILTER_VALIDATE_EMAIL)) {
            ob_start();
            require_once('mail-accept-template.php');
            $message = ob_get_contents();
            // send notif accept
            $mail = new Mailer();
            $mail->send($data['EMAIL'],'PEMBERITAHUAN PENDAFTARAN e-SPPT',$message);
        }
        set_flash_msg(['success'=>'Pendaftaran e-SPPT Berhasil dikonfirmasi']);
        break;
    case 'reject':
        
        $mysql->update('esppt', ['STATUS'=>'DITOLAK'])->where('ID',$_GET['act_id'])->exec();
        if (filter_var($data['EMAIL'], FILTER_VALIDATE_EMAIL)) {
            ob_start();
            require_once('mail-decline-template.php');
            $message = ob_get_contents();
            // send notif reject
            $mail = new Mailer();
            $mail->send($data['EMAIL'],'PEMBERITAHUAN PENDAFTARAN e-SPPT',$message);
        }
        set_flash_msg(['success'=>'Pendaftaran e-SPPT telah ditolak']);
        break;
   }

    header('Location:index.php?page=builder/pendaftaran/e-sppt/index');
    return;
}

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');

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