<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$mysql = new QueryBuilder("mysql");

$pekerjaans = [
    '1' => 'PNS',
    '2' => 'TNI/Polri',
    '3' => 'Pensiunan',
    '4' => 'Badan',
    '5' => 'Lainnya'
];

if(isset($_GET['act'])) {
    // $data = $mysql->select('DAT_OP_BUMI')->where('ID',$_GET['act_id'])->first();
    $subjek_pajak = $mysql->select('subjek_pajak')->where('reg_code',$_GET['code'])->first();
    $reg_type = $subjek_pajak['reg_type'];
    $reg_type = explode(' | ', $reg_type);
    $reg_type_0 = str_replace('REGISTRASI OBJEK PAJAK ','',$reg_type[0]);

    switch ($_GET['act']) {

        case 'accept' :

            $mysql->update('subjek_pajak', ['reg_status'=>'DITERIMA','reg_updated_at'=>date('Y-m-d H:i:s'),'reg_updated_by'=>$_SESSION['auth']['username']])->where('reg_code',$_GET['code'])->exec();
            $mysql->update('DAT_OP_BUMI', ['STATUS'=>'DITERIMA'])->where('reg_code',$_GET['code'])->exec();
            $mysql->update('DAT_OP_BANGUNAN', ['STATUS'=>'DITERIMA'])->where('reg_code',$_GET['code'])->exec();

            if($reg_type_0 == 'BUMI')
            {
                // move data to primary db
                $bumi = $mysql->select('DAT_OP_BUMI')->where('reg_code',$_GET['code'])->first();
                $subjek_pajak['SUBJEK_PAJAK_ID'] = $subjek_pajak['NIK'];
                $bumi['SUBJEK_PAJAK_ID'] = $subjek_pajak['NIK'];
                if($reg_type[1] == 'Baru')
                {
                    // cek subjek pajak
                    // cek apakah NIK sudah terdaftar
                    if(!$qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$subjek_pajak['NIK'])->first())
                    {
                        createSubjekPajak($subjek_pajak);
                    }
                }
                createObjekPajakBumi($bumi);
                // send email bumi
                if (filter_var($bumi['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                    ob_start();
                    require_once('mail-template/accept-pbb-bumi.php');
                    $message = ob_get_contents();
                    ob_end_clean();
                    // send notif accept
                    $mail = new Mailer();
                    $mail->send($bumi['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
                }
            }
            else
            {
                // move data to primary db
                $bangunan = $mysql->select('DAT_OP_BANGUNAN')->where('reg_code',$_GET['code'])->first();
                if($reg_type[1] == 'Baru')
                {
                    // cek subjek pajak
                    // cek apakah NIK sudah terdaftar
                    if(!$qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$subjek_pajak['NIK'])->first())
                    {
                        createSubjekPajak($subjek_pajak);
                    }
                }

                // createObjekPajakBumi($bumi);

                // send email bangunan
                if (filter_var($bangunan['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                    ob_start();
                    require_once('mail-template/accept-pbb-bangunan.php');
                    $message = ob_get_contents();
                    ob_end_clean();
                    // send notif accept
                    $mail = new Mailer();
                    $mail->send($bangunan['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
                }
            }

            set_flash_msg(['success'=>'Pendaftaran Berhasil Diterima!']);

        break;

        case 'reject' :
            $mysql->update('subjek_pajak', [
                'reg_status'=>'DITOLAK',
                'reg_updated_at'=>date('Y-m-d H:i:s'),
                'reg_updated_by'=>$_SESSION['auth']['username'],
                'reg_note'=>$_GET['reason']
            ])->where('reg_code',$_GET['code'])->exec();
            $mysql->update('DAT_OP_BUMI', ['STATUS'=>'DITOLAK'])->where('reg_code',$_GET['code'])->exec();
            $mysql->update('DAT_OP_BANGUNAN', ['STATUS'=>'DITOLAK'])->where('reg_code',$_GET['code'])->exec();

            if($reg_type_0 == 'BUMI')
            {
                // send email bumi
                $bumi = $mysql->select('DAT_OP_BUMI')->where('reg_code',$_GET['code'])->first();
                if (filter_var($bumi['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                    ob_start();
                    require_once('mail-template/reject-pbb-bumi.php');
                    $message = ob_get_contents();
                    ob_end_clean();
                    // send notif accept
                    $mail = new Mailer();
                    $mail->send($bumi['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
                }
            }
            else
            {
                // send email bangunan
                $bangunan = $mysql->select('DAT_OP_BANGUNAN')->where('reg_code',$_GET['code'])->first();
                if (filter_var($bangunan['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                    ob_start();
                    require_once('mail-template/reject-pbb-bangunan.php');
                    $message = ob_get_contents();
                    ob_end_clean();
                    // send notif accept
                    $mail = new Mailer();
                    $mail->send($bangunan['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
                }
            }

            set_flash_msg(['success'=>'Pendaftaran Telah Ditolak!']);
        break;

    // case 'accept_bumi':
        
    //     $mysql->update('DAT_OP_BUMI', ['STATUS'=>'DITERIMA'])->where('ID',$_GET['act_id'])->exec();
    //     if (filter_var($data['EMAIL'], FILTER_VALIDATE_EMAIL)) {
    //         ob_start();
    //         require_once('mail-accept-bumi-template.php');
    //         $message = ob_get_contents();
    //         // send notif accept
    //         $mail = new Mailer();
    //         $mail->send($data['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
    //     }
    //     set_flash_msg(['success'=>'Data Bumi Berhasil Diterima!']);
    //     break;

    // case 'accept_bng':
        
    //     $mysql->update('DAT_OP_BANGUNAN', ['STATUS'=>'DITERIMA'])->where('ID',$_GET['act_id'])->exec();
    //     if (filter_var($data['EMAIL'], FILTER_VALIDATE_EMAIL)) {
    //         ob_start();
    //         require_once('mail-accept-bng-template.php');
    //         $message = ob_get_contents();
    //         // send notif accept
    //         $mail = new Mailer();
    //         $mail->send($data['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
    //     }
    //     set_flash_msg(['success'=>'Data Bangunan Berhasil Diterima!']);
    //     break;

    // case 'reject_bumi':
        
    //     $mysql->update('DAT_OP_BUMI', ['STATUS'=>'DITOLAK'])->where('ID',$_GET['act_id'])->exec();
    //     if (filter_var($data['EMAIL'], FILTER_VALIDATE_EMAIL)) {
    //         ob_start();
    //         require_once('mail-decline-bumi-template.php');
    //         $message = ob_get_contents();
    //         // send notif accept
    //         $mail = new Mailer();
    //         $mail->send($data['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
    //     }
    //     set_flash_msg(['success'=>'Data Bumi Ditolak!']);
    //     break;

    // case 'reject_bng':
        
    //     $mysql->update('DAT_OP_BANGUNAN', ['STATUS'=>'DITOLAK'])->where('ID',$_GET['act_id'])->exec();
    //     if (filter_var($data['EMAIL'], FILTER_VALIDATE_EMAIL)) {
    //         ob_start();
    //         require_once('mail-decline-bng-template.php');
    //         $message = ob_get_contents();
    //         // send notif accept
    //         $mail = new Mailer();
    //         $mail->send($data['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
    //     }
    //     set_flash_msg(['success'=>'Data Bangunan Ditolak!']);
    //     break;
   }
    header('Location:index.php?page=builder/pendaftaran/subjek-pajak/view&code='.$_GET['code']);
    return;
}

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');

$data = $mysql->select('subjek_pajak')->where("reg_code",$_GET['code'])->first();

$opBumis = $mysql->select("DAT_OP_BUMI")->where('reg_code',$_GET['code'])->get();
$opBangunans = $mysql->select("DAT_OP_BANGUNAN")->where('reg_code',$_GET['code'])->get();

$kondisi = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
$konstruksi = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
$atap = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
$dinding = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
$lantai = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
$langit = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];

$jenisBumi = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];
