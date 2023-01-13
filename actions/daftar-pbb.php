<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$mysql = new QueryBuilder("mysql");
$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$clauseBumi = "KD_PROPINSI + '.' + KD_DATI2 + '.' + KD_KECAMATAN + '.' + KD_KELURAHAN + '.' + KD_BLOK";
$pekerjaans = [
    '1' => 'PNS',
    '2' => 'TNI/Polri',
    '3' => 'Pensiunan',
    '4' => 'Badan',
    '5' => 'Lainnya'
];

// get data jalan from filter
if(isset($_GET['get-jalan']) && isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan']))
{
    $jalan = $qb->select("JALAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->orderby('KD_ZNT')->get();
    echo json_encode($jalan);
    die();
}

// get data ZNT from filter
if(isset($_GET['filter-blok']) && isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->where('KD_BLOK',$_GET['filter-blok'])->orderby('KD_ZNT')->get();

    echo json_encode($znts);
    die;
}

// get data BLOK from filter
if(isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->orderby('KD_BLOK')->get();

    echo json_encode($bloks);
    die;
}

// get data Kelurahan from filter
if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->orderby('KD_KELURAHAN')->get();

    echo json_encode($kelurahans);
    die;
}

// get nomor urut
if(isset($_GET['get-no-urut'])){
    
    $valBumi = "12.12.".$_GET['kecamatan'] . '.' . $_GET['kelurahan'] . '.' . $_GET['blok'];

    $cntsUrut = $qb->select("DAT_OP_BUMI")->where($clauseBumi,$valBumi)->orderBy('NO_URUT','DESC')->first();

    if($cntsUrut){
        $no_urut = strval($cntsUrut['NO_URUT']+1);
        if($no_urut >= 100 && $no_urut < 1000) {
            $no_urut = "0" . $no_urut;
        } else if($no_urut < 100) {
            $no_urut = "00" . $no_urut;
        }
        echo json_encode($no_urut);
    }else{
        echo json_encode("001");
    }
    die;
}

if(isset($_GET['type'])) {
    if($_GET['type'] == 'subjek-pajak') {
        print_r($_POST);
        die;
    }

    // insert data objek pajak bumi
    if($_GET['type'] == 'bumi' && isset($_POST)) {
        
        $bumi = $_POST['bumi'];
        $bumi['NO_SPOP'] = $bumi['KD_KECAMATAN'].$bumi['KD_KELURAHAN'].$bumi['NO_URUT'];

        // untuk subjek pajak baru
        if($_POST['status'] == 'Baru') {

            $subjek_pajak = $_POST['subjek_pajak'];

            // cek apakah NIK sudah terdaftar
            if($qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$subjek_pajak['NIK'])->first())
            {
                echo json_encode(['status'=>'failed', 'message'=>'Subjek Pajak dengan NIK yang di inputkan sudah terdaftar!.']);
                die();
            }

            // buat subjek pajak terlebih dahulu
            $subjek_pajak['reg_code'] = 'REG-'.strtotime('now');
            $subjek_pajak['reg_status'] = 'MENUNGGU';
            $subjek_pajak['reg_type'] = 'REGISTRASI OBJEK PAJAK '.strtoupper($_GET['type']).' | '.$_POST['status'];
            
            $sp = $mysql->create("subjek_pajak", $subjek_pajak)->exec();
            
            if(!$sp || (is_array($sp) && $sp['error'])) {
                echo json_encode(['status'=>'failed', 'message'=>'Subjek Pajak dengan NIK yang di inputkan sudah terdaftar!']);
            } else {
                $bumi['WAJIB_PAJAK_ID'] = $subjek_pajak['NIK'];
                
                if(isset($_FILES['KTP'])){
                    $ktp = upload($_FILES['KTP'],'ktp');
        
                    if ($ktp) {
                        $bumi['KTP'] = $ktp['filename'];
                    }
                }

                if(isset($_FILES['FOTO_OBJEK'])){
                    $FOTO_OBJEK = upload($_FILES['FOTO_OBJEK'],'foto-objek');
        
                    if ($FOTO_OBJEK) {
                        $bumi['FOTO_OBJEK'] = $FOTO_OBJEK['filename'];
                    }
                }
                
                if(isset($_FILES['SURAT_TANAH'])){
                    $SURAT_TANAH = upload($_FILES['SURAT_TANAH'],'surat-tanah');
        
                    if ($SURAT_TANAH) {
                        $bumi['SURAT_TANAH'] = $SURAT_TANAH['filename'];
                    }
                }

                $bumi['reg_code'] = $subjek_pajak['reg_code'];

                $result = $mysql->create("DAT_OP_BUMI", $bumi)->exec();

                if(!$result || isset($result['error'])) {
                    echo json_encode(['status'=>'failed', 'message'=>'Silahkan cek data anda terlebih dahulu!']);
                } else {
                    if (filter_var($bumi['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                        ob_start();
                        require_once('mail-template/daftar-pbb-bumi.php');
                        $message = ob_get_contents();
                        ob_end_clean();
                        // send notif accept
                        $mail = new Mailer();
                        $mail->send($bumi['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
                    }
                    echo json_encode(['status'=>'success', 'message'=>'Data akan diverifikasi terlebih dahulu!. Silahkan cek email anda untuk detail pendaftaran']);
                }
            }

        // untuk subjek pajak yang sudah ada
        } else {
            
            $bumi['WAJIB_PAJAK_ID'] = $_POST['ID'];

            $subjek_pajak = $_POST['subjek_pajak'];
            $subjek_pajak['reg_code'] = 'REG-'.strtotime('now');
            $subjek_pajak['reg_status'] = 'MENUNGGU';
            $subjek_pajak['reg_type'] = 'REGISTRASI OBJEK PAJAK '.strtoupper($_GET['type']).' | '.$_POST['status'];
            
            $sp = $mysql->create("subjek_pajak", $subjek_pajak)->exec();

            if(!$sp || (is_array($sp) && $sp['error'])) {
                echo json_encode(['status'=>'failed', 'message'=>'Subjek Pajak dengan NIK yang di inputkan sudah terdaftar!']);
            } else {
                if(isset($_FILES['KTP'])){
                    $ktp = upload($_FILES['KTP'],'ktp');
        
                    if ($ktp) {
                        $bumi['KTP'] = $ktp['filename'];
                    }
                }
    
                if(isset($_FILES['FOTO_OBJEK'])){
                    $FOTO_OBJEK = upload($_FILES['FOTO_OBJEK'],'foto-objek');
        
                    if ($FOTO_OBJEK) {
                        $bumi['FOTO_OBJEK'] = $FOTO_OBJEK['filename'];
                    }
                }
                
                if(isset($_FILES['SURAT_TANAH'])){
                    $SURAT_TANAH = upload($_FILES['SURAT_TANAH'],'surat-tanah');
        
                    if ($SURAT_TANAH) {
                        $bumi['SURAT_TANAH'] = $SURAT_TANAH['filename'];
                    }
                }

                $bumi['reg_code'] = $subjek_pajak['reg_code'];
    
                $result = $mysql->create("DAT_OP_BUMI", $bumi)->exec();
    
                if(!$result || (is_array($result) && $result['error'])) {
                    echo json_encode(['status'=>'failed', 'message'=>'Silahkan cek data anda terlebih dahulu!']);
                } else {
                    if (filter_var($bumi['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                        ob_start();
                        require_once('mail-template/daftar-pbb-bumi.php');
                        $message = ob_get_contents();
                        ob_end_clean();
                        // send notif accept
                        $mail = new Mailer();
                        $mail->send($bumi['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
                    }
                    echo json_encode(['status'=>'success', 'message'=>'Data akan diverifikasi terlebih dahulu!. Silahkan cek email anda untuk detail pendaftaran']);
                }
            }
            
        }
        die;
    }

    // untuk objek pajak bangunan
    if($_GET['type'] == 'bangunan' && isset($_POST)) {
            
        $bangunan = $_POST['bangunan'];
        $bangunan['L_AC'] = json_encode($bangunan['L_AC']);
        $bangunan['LPH'] = json_encode($bangunan['LPH']);
        $bangunan['JLT_DL'] = json_encode($bangunan['JLT_DL']);
        $bangunan['JLT_TL'] = json_encode($bangunan['JLT_TL']);
        $bangunan['PAGAR'] = json_encode($bangunan['PAGAR']);
        $bangunan['LTB'] = json_encode($bangunan['LTB']);
        $bangunan['PK'] = json_encode($bangunan['PK']);
        $bangunan['J_LIFT'] = json_encode($bangunan['J_LIFT']);
        $bangunan['OTHERS'] = json_encode($bangunan['OTHERS']);
        $bangunan['KOLAM_RENANG'] = json_encode($bangunan['KOLAM_RENANG']);

        // subjek pajak baru
        if($_POST['status'] == 'Baru') {
            $subjek_pajak = $_POST['subjek_pajak'];

            // cek apakah NIK sudah terdaftar
            if($qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$subjek_pajak['NIK'])->first())
            {
                echo json_encode(['status'=>'failed', 'message'=>'Subjek Pajak dengan NIK yang di inputkan sudah terdaftar!.']);
                die();
            }

            // registrasi subjek pajak
            $subjek_pajak['reg_code'] = 'REG-'.strtotime('now');
            $subjek_pajak['reg_status'] = 'MENUNGGU';
            $subjek_pajak['reg_type'] = 'REGISTRASI OBJEK PAJAK '.strtoupper($_GET['type']).' | '.$_POST['status'];

            $bumi = $_POST['bumi'];
            
            $sp = $mysql->create("subjek_pajak", $subjek_pajak)->exec();
            
            if(!$sp || (is_array($sp) && $sp['error'])) {
                echo json_encode(['status'=>'failed', 'message'=>'Subjek Pajak dengan NIK yang di inputkan sudah terdaftar!']);
            } else {
                $bumi['NO_SPOP'] = $bumi['KD_KECAMATAN'].$bumi['KD_KELURAHAN'].$bumi['NO_URUT'];
                $bumi['WAJIB_PAJAK_ID'] = $subjek_pajak['NIK'];
                
                if(isset($_FILES['KTP_BUMI'])) {
                    $KTP_BUMI = upload($_FILES['KTP_BUMI'],'ktp');
    
                    if ($KTP_BUMI) {
                        $bumi['KTP'] = $KTP_BUMI['filename'];
                    }
                }


                if(isset($_FILES['FOTO_OBJEK_BUMI'])){
                    $FOTO_OBJEK_BUMI = upload($_FILES['FOTO_OBJEK_BUMI'],'foto-objek');
    
                    if ($FOTO_OBJEK_BUMI) {
                        $bumi['FOTO_OBJEK'] = $FOTO_OBJEK_BUMI['filename'];
                    }
                }
                
                if(isset($_FILES['SURAT_TANAH_BUMI'])){
                    $SURAT_TANAH_BUMI = upload($_FILES['SURAT_TANAH_BUMI'],'surat-tanah');
    
                    if ($SURAT_TANAH_BUMI) {
                        $bumi['SURAT_TANAH'] = $SURAT_TANAH_BUMI['filename'];
                    }
                }

                $bumi['reg_code'] = $subjek_pajak['reg_code'];

                $resultBumi = $mysql->create("DAT_OP_BUMI", $bumi)->exec();

                if(!$resultBumi || (is_array($resultBumi) && $resultBumi['error'])) {
                    echo json_encode(['status'=>'failed', 'message'=>'Silahkan cek data anda terlebih dahulu!']);
                } else {

                    $NOP = '12.12.' . $bumi['KD_KECAMATAN'] . '.' . $bumi['KD_KELURAHAN'] . '.' . $bumi['KD_BLOK'] . '-' . $bumi['NO_URUT'] . '.' . $bumi['KODE'];
                    $bangunan['NOP'] = $NOP;
                    $bangunan['WAJIB_PAJAK_ID'] = $subjek_pajak['NIK'];
            
                    if(isset($_FILES['KTP'])){
                        $KTP = upload($_FILES['KTP'],'ktp');
    
                        if ($KTP) {
                            $bangunan['KTP'] = $KTP['filename'];
                        }
                    }

                    if(isset($_FILES['FOTO_OBJEK'])){
                        $FOTO_OBJEK = upload($_FILES['FOTO_OBJEK'],'foto-objek');
    
                        if ($FOTO_OBJEK) {
                            $bangunan['FOTO_OBJEK'] = $FOTO_OBJEK['filename'];
                        }
                    }

                    if(isset($_FILES['SURAT_TANAH'])){
                        $SURAT_TANAH = upload($_FILES['SURAT_TANAH'],'surat-tanah');
    
                        if ($SURAT_TANAH) {
                            $bangunan['SURAT_TANAH'] = $SURAT_TANAH['filename'];
                        }
                    }

                    $bangunan['reg_code'] = $subjek_pajak['reg_code'];

                    $result = $mysql->create("DAT_OP_BANGUNAN", $bangunan)->exec();

                    if(!$result || (is_array($result) && $result['error'])) {
                        echo json_encode(['status'=>'failed', 'message'=>'Silahkan cek data anda terlebih dahulu!']);
                    } else {
                        if (filter_var($bangunan['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                            ob_start();
                            require_once('mail-template/daftar-pbb-bangunan.php');
                            $message = ob_get_contents();
                            ob_end_clean();
                            // send notif accept
                            $mail = new Mailer();
                            $mail->send($bangunan['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
                        }
                        echo json_encode(['status'=>'success', 'message'=>'Data akan diverifikasi terlebih dahulu!. Silahkan cek email anda untuk detail pendaftaran']);
                    }
                }
            }

        } else {
            // subjek pajak existing
            $bangunan['NOP'] = $_POST['NOP'];
            $subjek_pajak = $_POST['subjek_pajak'];
            $subjek_pajak['reg_code'] = 'REG-'.strtotime('now');
            $subjek_pajak['reg_status'] = 'MENUNGGU';
            $subjek_pajak['reg_type'] = 'REGISTRASI OBJEK PAJAK '.strtoupper($_GET['type']).' | '.$_POST['status'];
            
            $sp = $mysql->create("subjek_pajak", $subjek_pajak)->exec();
            
            $bangunan['WAJIB_PAJAK_ID'] = $subjek_pajak['NIK'];
            
            if(isset($_FILES['KTP'])){
                $ktp = upload($_FILES['KTP'],'ktp');
    
                if ($ktp) {
                    $bangunan['KTP'] = $ktp['filename'];
                }
            }

            if(isset($_FILES['FOTO_OBJEK'])){
                $FOTO_OBJEK = upload($_FILES['FOTO_OBJEK'],'foto-objek');
    
                if ($FOTO_OBJEK) {
                    $bangunan['FOTO_OBJEK'] = $FOTO_OBJEK['filename'];
                }
            }
            
            if(isset($_FILES['SURAT_TANAH'])){
                $SURAT_TANAH = upload($_FILES['SURAT_TANAH'],'surat-tanah');
    
                if ($SURAT_TANAH) {
                    $bangunan['SURAT_TANAH'] = $SURAT_TANAH['filename'];
                }
            }

            $bangunan['reg_code'] = $subjek_pajak['reg_code'];

            $result = $mysql->create("DAT_OP_BANGUNAN", $bangunan)->exec();

            if(!$result || (is_array($result) && $result['error'])) {
                echo json_encode(['status'=>'failed', 'message'=>'Silahkan cek data anda terlebih dahulu!']);
            } else {
                if (filter_var($bangunan['EMAIL'], FILTER_VALIDATE_EMAIL)) {
                    ob_start();
                    require_once('mail-template/daftar-pbb-bangunan.php');
                    $message = ob_get_contents();
                    ob_end_clean();
                    // send notif accept
                    $mail = new Mailer();
                    $mail->send($bangunan['EMAIL'],'PEMBERITAHUAN PENDAFTARAN PBB',$message);
                }
                echo json_encode(['status'=>'success', 'message'=>'Data akan diverifikasi terlebih dahulu!. Silahkan cek email anda untuk detail pendaftaran']);
            }
        }

        die;
    }

    // 
    if($_GET['type'] == 'terdaftar') {
        if ($_POST['jenis_op'] == "Bumi") {
            $data = $qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$_POST['ID'])->first();
            if($data) {
                echo json_encode(['status'=>'success', 'data'=>$data]);
            } else {
                echo json_encode(['status'=>'failed', 'message'=>'Silahkan cek masukan terlebih dahulu!']);
            }
        } else {
            $NOP = trim($_POST['NOP']);
            $clause = "concat(KD_PROPINSI,'.', KD_DATI2,'.',KD_KECAMATAN, '.', KD_KELURAHAN , '.' , KD_BLOK , '-' , NO_URUT , '.' , KD_JNS_OP)";
            $strQ = "Select *, $clause as NOP from DAT_OP_BUMI where $clause='$NOP' order by NO_URUT desc";
            $data = $qb->rawQuery($strQ)->first();
            $subjek_pajak = $qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$data['SUBJEK_PAJAK_ID'])->first();
            $data = array_merge($data, $subjek_pajak);
            if($data) {
                echo json_encode(['status'=>'success', 'data'=>$data]);
            } else {
                echo json_encode(['status'=>'failed', 'message'=>'Silahkan cek masukan terlebih dahulu!']);
            }
        }
        die;
    } 
}

$subjekPajakFields = $qb->columns("DAT_SUBJEK_PAJAK","KELURAHAN_WP,SUBJEK_PAJAK_ID,NM_WP,JALAN_WP,RW_WP,RT_WP,KOTA_WP,KD_POS_WP,TELP_WP,NPWP,BLOK_KAV_NO_WP");

$kecamatans = $qb->select('REF_KECAMATAN')->orderby('KD_KECAMATAN')->get();


$jenisBumis = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];

$kondisis = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
$konstruksis = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
$ataps = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
$dindings = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
$lantais = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
$langits = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];

$jpbs = $qb->select('REF_JPB')->orderBy('KD_JPB')->get();

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}
