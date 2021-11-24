<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['check'])){
    $clause = "KD_PROPINSI + '.' + KD_DATI2 + '.' + KD_KECAMATAN + '.' + KD_KELURAHAN + '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP";

    $StrQ = "Select * From DAT_OP_BANGUNAN WHERE KD_PROPINSI + '.' + KD_DATI2 + '.' + KD_KECAMATAN + '.' + KD_KELURAHAN + '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP =  '" . trim($_GET['NOP']) . "' and (NO_BNG*1='" . $_GET['NO_BNG'] * 1 . "')ORDER BY NO_BNG*1 DESC";

    $data = $qb->rawQuery($StrQ)->first();

    echo $data ? 1 : 0;

    die;
}

$kecamatans = $qb->select('REF_KECAMATAN')->get();

$jpbs = $qb->select('REF_JPB')->orderBy('KD_JPB')->get();

$subjekPajak = $qb->select("DAT_SUBJEK_PAJAK")->where('SUBJEK_PAJAK_ID',$_GET['id'])->first();

$old = get_flash_msg("old");

$kondisis = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
$konstruksis = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
$ataps = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
$dindings = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
$lantais = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
$langits = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$nYear = date("Y");

if(request() == 'POST')
{   

    if(isset($_POST['hitung'])){
        
        // init vars
        
            $nDBKB = 0;
            $nMezanine = 0;
            $LDBKB = 0;
            $nTipe_K = 0;
            
            $nDUKUNG = 0;

            $xDinding = 0;
            $xLantai = 0;
            $xAtap = 0;
            $xLangit2 = 0;

            $TPajak = 0; 
            $TRenovasi = 0; 
            $TBangun = 0; 
            $JLANTAI = 0; 
            $JGuna = 0; 
            $Umur = 0; 
            $JL = 0;
            $umur_EFF = 0;

            $X = [];
            $JPB = $_POST['KD_JPB'];

            $cTipe = 0;
            $CC = 0;

            $nMaterial = 0; 
            $nFAS1 = 0; 
            $nFAS2 = 0; 
            $nSusut = 0; 
            $nSusut1 = 0;

            $W0 = 0; 
            $W1 = 0; 
            $W2 = 0; 
            $W3 = 0; 
            $W4 = 0; 
            $W5 = 0; 
            $W6 = 0; 
            $W7 = 0; 
            $W8 = 0; 
            $W9 = 0;

            $WW0 = 0; 
            $WW1 = 0; 
            $WW2 = 0; 
            $WW3 = 0; 
            $WW4 = 0; 
            $WW5 = 0; 
            $WW6 = 0; 
            $WW7 = 0; 
            $WW8 = 0; 
            $WW9 = 0;

            $s_W0 = 0; 
            $s_W4 = 0; 
            $s_W5 = 0; 
            $s_W6 = 0; 
            $s_W7 = 0; 
            $s_W8 = 0; 
            $s_W9 = 0; 
            $s_WW0 = 0;

            $QQ1 = 0; 
            $QQ2 = 0; 
            $QQ3 = 0; 
            $QQ4 = 0; 
            $QQ5 = 0; 
            $QQ6 = 0;

            $s_QQ1 = 0; 
            $s_QQ2 = 0; 
            $s_QQ3 = 0; 
            $s_QQ4 = 0; 
            $s_QQ5 = 0; 
            $s_QQ6 = 0;

            $n_Mezanin = 0; 
            $s_nFas2 = 0;

            $DAYA_LISTRIK = 0;

            $JUM_SPLIT = 0;
            $JUM_WINDOW = 0;
            $JUM_AC_CENTRAL = 0;

            $LUAS_HRINGAN = 0;
            $LUAS_HSEDANG = 0;
            $LUAS_HBERAT = 0;
            $LUAS_HPENUTUP = 0;
            
            $JUM_LAP_BETON1 = 0;
            $JUM_LAP_ASPAL1 = 0;
            $JUM_LAP_RUMPUT1 = 0;
            $JUM_LAP_BETON2 = 0;
            $JUM_LAP_ASPAL2 = 0;
            $JUM_LAP_RUMPUT2 = 0;
            $JUM_LAP_BETON11 = 0;
            $JUM_LAP_ASPAL11 = 0;
            $JUM_LAP_RUMPUT11 = 0;
            $JUM_LAP_BETON21 = 0;
            $JUM_LAP_ASPAL21 = 0;
            $JUM_LAP_RUMPUT21 = 0;

            $BAHAN_PAGAR1 = 0;
            $BAHAN_PAGAR2 = 0;

            $LEBAR_TANGGA1 = 0;
            $LEBAR_TANGGA2 = 0;

            $BAKAR_H = 0;
            $BAKAR_S = 0;
            $BAKAR_F = 0;

            $JUM_PABX = 0;

            $DALAM_SUMUR = 0;

            $Nil_AC_Central = [];
            $Nil_Boiler_Ht = 0;
            
            $JLIFT = [0,0,0];
            $Luas_Kolam = 0;
            $JUM_GENSET = 0;

            $xKondisi = 0;
            $xSUSUT = 0;

            $ck_Ulin = 0;
            $N_BANGUNAN = 0;

            $nBangunan = 0;
            $nSistem = 0;

        
        function call_Mezz(){
            global $nMezanine;

            $qb = new QueryBuilder();
        
            $QSTR = "SELECT * FROM DBKB_MEZANIN WHERE THN_DBKB_MEZANIN='" . $_POST['THN_PAJAK'] . "'";
            $data = $qb->rawQuery($StrQ)->get();
        
            foreach ($data as $key => $value) {
                $nMezanine = $value['NILAI_DBKB_MEZANIN'] ;
            }
        
        }
        
        function call_Dukung(){
            global $nDUKUNG,$nTipe_K;

            $qb = new QueryBuilder();
        
            $QSTR = "SELECT DBKB_DAYA_DUKUNG.KD_PROPINSI, DBKB_DAYA_DUKUNG.KD_DATI2, DBKB_DAYA_DUKUNG.THN_DBKB_DAYA_DUKUNG, DBKB_DAYA_DUKUNG.TYPE_KONSTRUKSI, DAYA_DUKUNG.DAYA_DUKUNG_LANTAI_MIN_DBKB, DAYA_DUKUNG.DAYA_DUKUNG_LANTAI_MAX_DBKB, DBKB_DAYA_DUKUNG.NILAI_DBKB_DAYA_DUKUNG FROM DBKB_DAYA_DUKUNG INNER JOIN DAYA_DUKUNG ON DBKB_DAYA_DUKUNG.TYPE_KONSTRUKSI = DAYA_DUKUNG.TYPE_KONSTRUKSI WHERE DBKB_DAYA_DUKUNG.THN_DBKB_DAYA_DUKUNG='" . $_POST['THN_PAJAK'] . "'";
            
            $data = $qb->rawQuery($QSTR)->get();
        
            foreach ($data as $key => $value) {
                if( 0 * $_POST['LUAS_BNG'] >= $value['DAYA_DUKUNG_LANTAI_MIN_DBKB'] && 0 * $_POST['LUAS_BNG'] <= $value['DAYA_DUKUNG_LANTAI_MAX_DBKB'] ){
        
                    $nDUKUNG = $value['NILAI_DBKB_DAYA_DUKUNG'] * $_POST['LUAS_BNG'];
                    $nTipe_K = $value['TYPE_KONSTRUKSI'];
                }
            }
        }
        
        function CALL_DINDING($xKerja, $xNama){
            global $xDinding;
            $qb = new QueryBuilder();
        
            $StrQ = "SELECT * FROM VMATERIAL WHERE THN_DBKB_MATERIAL ='" . $_POST['THN_PAJAK'] . "' and (KD_PEKERJAAN='" . $xKerja . "' and NM_KEGIATAN='" . $xNama . "') ORDER BY KD_PEKERJAAN,KD_KEGIATAN ASC";
            
            $data = $qb->rawQuery($StrQ)->get();
        
            foreach ($data as $key => $value) {
                $xDinding = $value['NILAI_DBKB_MATERIAL'];
            }
        }
        
        function CALL_LANTAI($xKerja, $xNama){
            global $xLantai;

            $qb = new QueryBuilder();
        
            $StrQ = "SELECT * FROM VMATERIAL WHERE THN_DBKB_MATERIAL ='" . $_POST['THN_PAJAK'] . "' and (KD_PEKERJAAN='" . $xKerja . "' and NM_KEGIATAN='" . $xNama . "') ORDER BY KD_PEKERJAAN,KD_KEGIATAN ASC";
        
            $data = $qb->rawQuery($StrQ)->get();
        
            foreach ($data as $key => $value) {
                $xLantai = $value['NILAI_DBKB_MATERIAL'];
        
            }
        
        }
        
        function CALL_ATAP($xKerja, $xNama){
            global $xAtap;

            $qb = new QueryBuilder();
        
            $StrQ = "SELECT * FROM VMATERIAL WHERE THN_DBKB_MATERIAL ='" . $_POST['THN_PAJAK'] . "' and (KD_PEKERJAAN='" . $xKerja . "' and NM_KEGIATAN='" . $xNama . "') ORDER BY KD_PEKERJAAN,KD_KEGIATAN ASC";
        
            $data = $qb->rawQuery($StrQ)->get();
        
            foreach ($data as $key => $value) {
        
                $xAtap = $value['NILAI_DBKB_MATERIAL'] / $_POST['JML_LANTAI_BNG'];
        
            }
        
        }
        
        function CALL_LANGIT2($xKerja, $xNama){
            global $xLangit2;

            $qb = new QueryBuilder();
        
            $StrQ = "SELECT * FROM VMATERIAL WHERE THN_DBKB_MATERIAL ='" . $_POST['THN_PAJAK'] . "' and (KD_PEKERJAAN='" . $xKerja . "' and NM_KEGIATAN='" . $xNama . "') ORDER BY KD_PEKERJAAN,KD_KEGIATAN ASC";
        
            $data = $qb->rawQuery($StrQ)->get();
        
            foreach ($data as $key => $value) {
        
                $xLangit2 = $value['NILAI_DBKB_MATERIAL'];
        
            }
        
        }
        
        function cmdProses_Click(){

            global $nDBKB,$TPajak, $TRenovasi, $TBangun, $JLANTAI, $JGuna, $Umur, $JL, $X, $JPB, $cTipe, $CC, $Umur,$umur_EFF;
        
            $qb = new QueryBuilder();
        
            switch ($JPB) {
                case "01" || "02" || "04" || "05" || "07" || "09" || "10" || "11":
                    if($_POST['JML_LANTAI_BNG'] <= 1 ){
                        $JL = 1;
                    }
                    elseif( $_POST['JML_LANTAI_BNG'] <= 4 ){
                        $JL = 2;
                    }
                    else{
                        $JL = 3;
                    } 
        
                    if( ($JPB == "01" || $JPB == "10" || $JPB == "11") && $JL <= 2 ) $JPB = "01" ;

                    if( $JPB == "05" && $JL <= 2 ) $JPB = "05";  
                    
                    if( ($JPB == "02" || $JPB == "04" || $JPB == "07" || $JPB = "09") && $JL <= 2 ) $JPB = "02";
        
                    if($JL <= 2){
                        
                        $StrQ = "SELECT DBKB_STANDARD.THN_DBKB_STANDARD, DBKB_STANDARD.KD_JPB, TIPE_BANGUNAN.TIPE_BNG, TIPE_BANGUNAN.NM_TIPE_BNG, TIPE_BANGUNAN.LUAS_MIN_TIPE_BNG, TIPE_BANGUNAN.LUAS_MAX_TIPE_BNG, TIPE_BANGUNAN.FAKTOR_PEMBAGI_TIPE_BNG, DBKB_STANDARD.KD_BNG_LANTAI, DBKB_STANDARD.NILAI_DBKB_STANDARD FROM DBKB_STANDARD INNER JOIN TIPE_BANGUNAN ON DBKB_STANDARD.TIPE_BNG = TIPE_BANGUNAN.TIPE_BNG WHERE (((DBKB_STANDARD.THN_DBKB_STANDARD)='" . $_POST['THN_PAJAK'] . "')) AND DBKB_STANDARD.KD_JPB='" . $JPB . "'";
                        
                        $data = $qb->rawQuery($StrQ)->get();
        
                        foreach ($data as $key => $value) {
                            if( ($_POST['LUAS_BNG'] >= $value['LUAS_MIN_TIPE_BNG'] && $_POST['LUAS_BNG'] <= $value['LUAS_MAX_TIPE_BNG']) && trim($value['KD_BNG_LANTAI']) == $_POST['JML_LANTAI_BNG']){
                                $nDBKB = $value['NILAI_DBKB_STANDARD'];
                                $cTipe = $value['TIPE_BNG'];
                            }
                        }
                        
                    }
                    else{
        
                        if($JPB == 2){
                            $StrQ = "SELECT * FROM DBKB_JPB2 WHERE THN_DBKB_JPB2='" . $_POST['THN_PAJAK'] . "' AND KLS_DBKB_JPB2 ='1' ORDER BY LANTAI_MIN_JPB2,LANTAI_MAX_JPB2 ASC";
                                
                            $data = $qb->rawQuery($StrQ)->get();
        
                            foreach ($data as $key => $value) {
                                $CC = $value['KLS_DBKB_JPB2'];
        
                                if( ($_POST['JML_LANTAI_BNG'] >= $value['LANTAI_MIN_JPB2'] && $_POST['JML_LANTAI_BNG'] <= $value['LANTAI_MAX_JPB2']) ){
                                    $nDBKB = $value['NILAI_DBKB_JPB2'];
                                }
                            
                            }       
        
                        }elseif($JPB == 4){
        
                            $StrQ = "SELECT * FROM DBKB_JPB4 WHERE THN_DBKB_JPB4='" . $_POST['THN_PAJAK'] . "' ORDER BY KLS_DBKB_JPB4 ASC";
        
                            $data = $qb->rawQuery($StrQ)->get();
        
                            foreach ($data as $key => $value) {
        
                                $CC = $value['KLS_DBKB_JPB4'];
                                if( ($_POST['JML_LANTAI_BNG'] >= $value['LANTAI_MIN_JPB4'] && $_POST['JML_LANTAI_BNG'] <= $value['LANTAI_MAX_JPB4']) ){
                                    if( $CC == 1){
                                        $nDBKB = $value['NILAI_DBKB_JPB4'];
                                    }
                                }
                            }

                        }elseif($JPB == 5){
        
                            $StrQ ="SELECT * FROM DBKB_JPB5 WHERE THN_DBKB_JPB5='" . $_POST['THN_PAJAK'] . "' AND KLS_DBKB_JPB5 ='1' ORDER BY KLS_DBKB_JPB5 ASC";
        
                            $data = $qb->rawQuery($StrQ)->get();
        
                            foreach ($data as $key => $value) {
        
                                if( ($_POST['JML_LANTAI_BNG'] >= $value['LANTAI_MIN_JPB5'] && $_POST['JML_LANTAI_BNG'] <= $value['LANTAI_MAX_JPB5']) ){
                                    $nDBKB = $value['NILAI_DBKB_JPB5'];
                                }
                            }
                        }elseif($JPB == 7){
        
                            $StrQ = "SELECT * FROM DBKB_JPB7 WHERE THN_DBKB_JPB7='" . $_POST['THN_PAJAK'] . "' AND JNS_DBKB_JPB7 ='1' AND BINTANG_DBKB_JPB7 ='0' ";
        
                            $data = $qb->rawQuery($StrQ)->get();
        
                            foreach ($data as $key => $value) {
        
                                if($_POST['JML_LANTAI_BNG'] >= $value['LANTAI_MIN_JPB7'] && $_POST['JML_LANTAI_BNG'] <= $value['LANTAI_MAX_JPB7']) {
                                    $nDBKB = $value['NILAI_DBKB_JPB7'];
                                }
        
                            }
                        }
                    }
                    
                    break;
        
                case "03":
        
                    call_Mezz();
                    call_Dukung();
        
                    $StrQ = "SELECT * FROM DBKB_JPB3 WHERE THN_DBKB_JPB3='". $_POST['THN_PAJAK'] . "' ";
                    
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
        
                        if( 0 >= $value['LBR_BENT_MIN_DBKB_JPB3'] && 0 <= $value['LBR_BENT_MAX_DBKB_JPB3'] ){
                            if( 0 >= $value['TING_KOLOM_MIN_DBKB_JPB3'] && 0 <= $value['TING_KOLOM_MAX_DBKB_JPB3'] ){
                                $nDBKB = $value['NILAI_DBKB_JPB3'];
                            }
                        }
        
                    }
            
        
                    break;
        
                case "06":
                        
                    $StrQ = "SELECT * FROM DBKB_JPB6 WHERE THN_DBKB_JPB6='" . $_POST['THN_PAJAK'] . "' AND KLS_DBKB_JPB6 ='1' ORDER BY KLS_DBKB_JPB6 ASC";
                    
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
                        $nDBKB = $value['NILAI_DBKB_JPB6'];
                    }
        
                    break;
        
                case "08":
                    call_Mezz();
                    call_Dukung();
        
                    $StrQ = "SELECT * FROM DBKB_JPB8 WHERE THN_DBKB_JPB8='" . $_POST['THN_PAJAK'] . "' ORDER BY LBR_BENT_MIN_DBKB_JPB8 ASC";
                    
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
                        
                        if( 0 >= $value['LBR_BENT_MIN_DBKB_JPB8'] && 0 <= $value['LBR_BENT_MAX_DBKB_JPB8'] ){
                            if( 0 >= $value['TING_KOLOM_MIN_DBKB_JPB8'] && 0 <= $value['TING_KOLOM_MAX_DBKB_JPB8'] ){
                                $nDBKB = $value['NILAI_DBKB_JPB8'];
                            }
                        }
                        
                    }
                    
                    break;
                case "11":
                    $nDBKB = 0;
        
                    break;
        
                
                case "12":
                    $StrQ = "SELECT * FROM DBKB_JPB12 WHERE THN_DBKB_JPB12='" . $_POST['THN_PAJAK'] . "' AND TYPE_DBKB_JPB12 ='1' ORDER BY TYPE_DBKB_JPB12 ASC";
                    
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
                        $nDBKB = $value['NILAI_DBKB_JPB12'];
                    }
        
                    break;
        
                case "13":
                    $StrQ = "SELECT * FROM DBKB_JPB13 WHERE THN_DBKB_JPB13='" . $_POST['THN_PAJAK'] . "' AND KLS_DBKB_JPB13='1' ";
                    
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
                        if( ($_POST['JML_LANTAI_BNG'] >= $value['LANTAI_MIN_JPB13'] && $_POST['JML_LANTAI_BNG'] <= $value['LANTAI_MAX_JPB13']) ){
                            $nDBKB = $value['NILAI_DBKB_JPB13'];
                        }
                    }
        
                    break;
        
                case "14" :
                    $StrQ = "select * from DBKB_JPB14 where THN_DBKB_JPB14='" . $_POST['THN_PAJAK'] . "'";
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
                        $nDBKB = $value['NILAI_DBKB_JPB14'];
                    }
                    break;
        
                case "15" :
                    $StrQ = "select * from DBKB_JPB15 where THN_DBKB_JPB15='" . $_POST['THN_PAJAK'] . "' AND KLS_DBKB_JPB15='1' ";
                    
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
        
                        if( 0 >= $value['KAPASITAS_MIN_DBKB_JPB15'] && 0 <= $value['KAPASITAS_MAX_DBKB_JPB15']){
                            $nDBKB = $value['NILAI_DBKB_JPB15'];
                        }
        
                    }
        
                    break;
            
                case "16":
                    $StrQ = "select * from DBKB_JPB16 where THN_DBKB_JPB16='" . $_POST['THN_PAJAK'] .  "' AND KLS_DBKB_JPB16='1'";
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
        
                        if( $_POST['JML_LANTAI_BNG'] >= $value['LANTAI_MIN_JPB16'] && $_POST['JML_LANTAI_BNG'] <= $value['LANTAI_MAX_JPB16']){
                            $nDBKB = $value['NILAI_DBKB_JPB16'];
        
                        }
        
                    }
        
                    break;
        
                case "17" :
                    $StrQ = "select * from DBKB_JPB17 where THN_DBKB_JPB17='" . $_POST['THN_PAJAK'] . "' AND (TINGGI_MIN_JPB17*1>='0' and TINGGI_MAX_JPB17*1<='0')";
                    
                    $data = $qb->rawQuery($StrQ)->get();
        
                    foreach ($data as $key => $value) {
                        $nMenara = $value['NILAI_BNG_MENARA_JPB17'];
                        $nMekanikal = $value['BIAYA_MEKANIK_JPB17'];
                        $nPagar = $value['NILAI_BGN_PAGAR_JPB17'];
                        $nDBKB = $nMenara + $nMekanikal + $nPagar;
                    }
        
                    break;
        
                default:
                    
                    break;
            }
            
            CALL_DINDING("21", $_POST['KD_DINDING']);
            CALL_LANTAI("22", $_POST['KD_LANTAI']);
            CALL_ATAP("23", $_POST['JNS_ATAP_BNG']);
            CALL_LANGIT2("24", $_POST['KD_LANGIT_LANGIT']);

            $TPajak = $_POST['THN_PAJAK'];
            $TBangun = $_POST['THN_DIBANGUN_BNG'];
            $TRenovasi = $_POST['THN_RENOVASI_BNG'];
            $JGuna = $_POST['KD_JPB'];
            $JLANTAI = $_POST['JML_LANTAI_BNG'];
            
            if( ($JGuna == 1 || $JGuna == 3 || $JGuna == 8 || $JGuna == 10 || $JGuna == 11 || $JGuna == 2 || $JGuna == 4 || $JGuna == 5 || $JGuna == 7 || $JGuna == 9) && $JLANTAI <= 4 ){
                if( $TRenovasi > 0 ){
                    $Umur = $TPajak - $TRenovasi;
                }else{
                    $Umur = $TPajak - $TBangun;
                }
            }else{
                if( $TBangun > 0 && $TRenovasi > 0 ){
                    if( $TPajak - $TBangun > 10 ){
                        $Umur = (($TPajak - $TBangun) + (2 * 10)) / 3;
                    }else{
                        $Umur = (($TPajak - $TBangun) + 2 * ($TPajak - $TRenovasi)) / 3;
                    }
                }elseif( $TBangun > 0 && $TRenovasi <= 0 ){
                    if( $TPajak - $TBangun > 10 ){
                        $Umur = (($TPajak - $TBangun) + (2 * 10)) / 3;
                    }else{
                        $Umur = $TPajak - $TBangun;
                    }
                }
            }
            

            if( $Umur > 40 ){
                $Umur = 40;
            }
            $umur_EFF = round($Umur);
        
        }
        
        function DBKB_FAS1(){
        
            global $DAYA_LISTRIK , $JUM_SPLIT, $JUM_AC_CENTRAL, 
            $LUAS_HRINGAN, $LUAS_HSEDANG, $LUAS_HBERAT, $LUAS_HPENUTUP,
            $JUM_LAP_BETON1,$JUM_LAP_ASPAL1,$JUM_LAP_RUMPUT1,$JUM_LAP_BETON2,$JUM_LAP_ASPAL2,$JUM_LAP_RUMPUT2,$JUM_LAP_BETON11,$JUM_LAP_ASPAL11,$JUM_LAP_RUMPUT11,$JUM_LAP_BETON21,$JUM_LAP_ASPAL21,$JUM_LAP_RUMPUT21,
            $BAHAN_PAGAR1, $BAHAN_PAGAR2,
            $LEBAR_TANGGA1, $LEBAR_TANGGA2,
            $BAKAR_H, $BAKAR_S, $BAKAR_F,
            $JUM_PABX, $DALAM_SUMUR;
        
            $qb = new QueryBuilder();
            
            $QSTR = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_NON_DEP.NILAI_NON_DEP, FAS_NON_DEP.THN_NON_DEP FROM FASILITAS INNER JOIN FAS_NON_DEP ON FASILITAS.KD_FASILITAS = FAS_NON_DEP.KD_FASILITAS WHERE FAS_NON_DEP.THN_NON_DEP='" . $_POST['THN_PAJAK'] . "' ";
        
            $data = $qb->rawQuery($QSTR)->get();
        
            foreach ($data as $key => $value) {
            
                $NFAS = $value['NILAI_NON_DEP'];
                
                if(trim($value['KD_FASILITAS']) == "44" || strtoupper(trim($value['NM_FASILITAS'])) == "LISTRIK" ){
                    $DAYA_LISTRIK = $NFAS;
                }
        
                $S_Listrik = Format($DAYA_LISTRIK, "#,#0.00");
        
                if( trim($value['KD_FASILITAS']) == "01" ) $JUM_SPLIT = $NFAS;
                if( trim($value['KD_FASILITAS']) == "02" ) $JUM_WINDOW = $NFAS;
                
                if( trim($value['KD_FASILITAS']) == "11" ) $JUM_AC_CENTRAL = $NFAS;
                
                if( trim($value['KD_FASILITAS']) == "14" ) $LUAS_HRINGAN = $NFAS;
                if( trim($value['KD_FASILITAS']) == "15" ) $LUAS_HSEDANG = $NFAS;
                if( trim($value['KD_FASILITAS']) == "16" ) $LUAS_HBERAT = $NFAS;
                if( trim($value['KD_FASILITAS']) == "17" ) $LUAS_HPENUTUP = $NFAS;
                    
                if( trim($value['KD_FASILITAS']) == "18" ) $JUM_LAP_BETON1 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "19" ) $JUM_LAP_ASPAL1 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "20" ) $JUM_LAP_RUMPUT1 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "21" ) $JUM_LAP_BETON2 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "22" ) $JUM_LAP_ASPAL2 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "23" ) $JUM_LAP_RUMPUT2 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "24" ) $JUM_LAP_BETON11 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "25" ) $JUM_LAP_ASPAL11 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "26" ) $JUM_LAP_RUMPUT11 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "27" ) $JUM_LAP_BETON21 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "28" ) $JUM_LAP_ASPAL21 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "29" ) $JUM_LAP_RUMPUT21 = $NFAS;
                
                if( trim($value['KD_FASILITAS']) == "35" ) $BAHAN_PAGAR1 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "36" ) $BAHAN_PAGAR2 = $NFAS;
            
                if( trim($value['KD_FASILITAS']) == "33" ) $LEBAR_TANGGA1 = $NFAS;
                if( trim($value['KD_FASILITAS']) == "34" ) $LEBAR_TANGGA2 = $NFAS;
            
                if( trim($value['KD_FASILITAS']) == "37" ) $BAKAR_H = $NFAS;
                if( trim($value['KD_FASILITAS']) == "38" ) $BAKAR_S = $NFAS;
                if( trim($value['KD_FASILITAS']) == "39" ) $BAKAR_F = $NFAS;
        
                if( trim($value['KD_FASILITAS']) == "41" ) $JUM_PABX = $NFAS;
        
                if( trim($value['KD_FASILITAS']) == "42" ) $DALAM_SUMUR = $NFAS;
        
            }
        
        }
        
        function DBKB_FAS2(){
            global $Nil_AC_Central,$Nil_Boiler_Ht;
            
            $qb = new QueryBuilder();
        
            $QSTR = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_DEP_JPB_KLS_BINTANG.KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.NILAI_FASILITAS_KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG FROM FASILITAS INNER JOIN FAS_DEP_JPB_KLS_BINTANG ON FASILITAS.KD_FASILITAS = FAS_DEP_JPB_KLS_BINTANG.KD_FASILITAS WHERE FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG='" . $_POST['THN_PAJAK'] . "'";
            
            $data = $qb->rawQuery($QSTR)->get();
        
        
            foreach ($data as $key => $value) {
                $NFAS = $value['NILAI_FASILITAS_KLS_BINTANG'];
                $xKelas = trim($value['KLS_BINTANG']);
                
                if(trim($value['KD_FASILITAS']) == "43" ){
                    if(0 == $xKelas){
                        $Nil_Boiler_Ht = $NFAS;
                    }
                }
                
                if(trim($value['KD_FASILITAS']) == "45" ){
                    if(1 == $xKelas ){
                        $Nil_Boiler_Ap = $NFAS;
                    }
                }
                
                if(trim($value['KD_FASILITAS']) == "03" ){
                    if(1 == $xKelas){
                        $Nil_AC_Central[0] = $NFAS;
                    }
                }
                
                if(1 == $xKelas ){
                    if(trim($value['KD_FASILITAS']) == "04" ){
                        $Nil_AC_Central[1] = $NFAS * 0;
                    }elseif(trim($value['KD_FASILITAS']) == "05" ){
                        $Nil_AC_Central[2] = $NFAS * 0;
                    }
                }
                
                if(trim($value['KD_FASILITAS']) == "06" ){
                    if(1 == $xKelas ){
                        $Nil_AC_Central[3] = $NFAS;
                    }
                }
                
                
                if(1 == $xKelas ){
                    if(trim($value['KD_FASILITAS']) == "07" ){
                        $Nil_AC_Central[4] = $NFAS * 0;
                    }elseif(trim($value['KD_FASILITAS']) == "08" ){
                        $Nil_AC_Central[5] = $NFAS * 0;
                    }
                }
                
            
                if(1 == $xKelas ){
                    if(trim($value['KD_FASILITAS']) == "09" ){
                        $Nil_AC_Central[6] = $NFAS * 0;
                    }elseif(trim($value['KD_FASILITAS']) == "10" ){
                        $Nil_AC_Central[7] = $NFAS * 0 ;
                    }
                }
            }
        
        }
        
        function DBKB_FAS3(){

            global $JLIFT,$Luas_Kolam, $JUM_GENSET;
        
            $qb = new QueryBuilder();
        
            $QSTR = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_DEP_MIN_MAX.KLS_DEP_MIN, FAS_DEP_MIN_MAX.KLS_DEP_MAX, FAS_DEP_MIN_MAX.NILAI_DEP_MIN_MAX, FAS_DEP_MIN_MAX.THN_DEP_MIN_MAX FROM FASILITAS INNER JOIN FAS_DEP_MIN_MAX ON FASILITAS.KD_FASILITAS = FAS_DEP_MIN_MAX.KD_FASILITAS WHERE FAS_DEP_MIN_MAX.THN_DEP_MIN_MAX='" . $_POST['THN_PAJAK'] . "' ORDER BY FASILITAS.KD_FASILITAS,FAS_DEP_MIN_MAX.KLS_DEP_MIN,FAS_DEP_MIN_MAX.KLS_DEP_MAX ASC";
            
            $data = $qb->rawQuery($QSTR)->get();
        
            foreach ($data as $key => $value) {
        
                $NFAS = is_null($value['NILAI_DEP_MIN_MAX']);
                $xMIN = $value['KLS_DEP_MIN'];
                $xMAX = $value['KLS_DEP_MAX'];
                
                if(trim($value['KD_FASILITAS']) == "12" && $_POST['KOLAM_RENANG']['F_KOLAM'] == "01" ){
                    if($_POST['KOLAM_RENANG']['LUAS'] >= $xMIN && $_POST['KOLAM_RENANG']['LUAS'] <= $xMAX ){
                        $Luas_Kolam = $NFAS;
                    }
                }
                if(Trim($value['KD_FASILITAS']) == "13" && $_POST['KOLAM_RENANG']['F_KOLAM'] == "02" ){
                    if($_POST['KOLAM_RENANG']['LUAS'] >= $xMIN && $_POST['KOLAM_RENANG']['LUAS'] <= $xMAX ){
                        $Luas_Kolam = $NFAS;
                    }
                }
                
                
                if(Trim($value['KD_FASILITAS']) == "30" ){
                    if($_POST['J_LIFT']['PENUMPANG'] >= $xMIN && $_POST['J_LIFT']['PENUMPANG'] <= $xMAX ){
                        $JLIFT[0] = $NFAS;
                    }
                }
                elseif(Trim($value['KD_FASILITAS']) == "31" ){
                    if($_POST['J_LIFT']['KAPSUL'] >= $xMIN && $_POST['J_LIFT']['KAPSUL'] <= $xMAX ){
                        $JLIFT[1] = $NFAS;
                    }
                }
                if(Trim($value['KD_FASILITAS']) == "32" ){
                    if($_POST['J_LIFT']['BARANG'] >= $xMIN && $_POST['J_LIFT']['BARANG'] <= $xMAX ){
                        $JLIFT[2] = $NFAS;
                    }
                }
                
                
                if(Trim($value['KD_FASILITAS']) == "40" ){
                    if($_POST['OTHERS']['K_GENSET'] >= $xMIN && $_POST['OTHERS']['K_GENSET'] <= $xMAX ){
                        $JUM_GENSET = $NFAS;
                    }
                }
        
            }
        }
        
        function tampil_Susut($Nil_Bng){
            
            global $xKondisi,$xSUSUT, $umur_EFF;

            $xKondisi = $_POST['KONDISI_BNG'];
        
            $qb = new QueryBuilder();
        
            $StrQ = "SELECT PENYUSUTAN.KD_RANGE_PENYUSUTAN, PENYUSUTAN.UMUR_EFEKTIF, PENYUSUTAN.KONDISI_BNG_SUSUT, RANGE_PENYUSUTAN.NILAI_MIN_PENYUSUTAN, RANGE_PENYUSUTAN.NILAI_MAX_PENYUSUTAN, PENYUSUTAN.NILAI_PENYUSUTAN FROM PENYUSUTAN INNER JOIN RANGE_PENYUSUTAN ON PENYUSUTAN.KD_RANGE_PENYUSUTAN = RANGE_PENYUSUTAN.KD_RANGE_PENYUSUTAN ORDER BY PENYUSUTAN.UMUR_EFEKTIF";
        
            $data = $qb->rawQuery($StrQ)->get();
        
            foreach ($data as $key => $value) {
                
                if($value['UMUR_EFEKTIF'] == $umur_EFF && $xKondisi = $value['KONDISI_BNG_SUSUT'] * 1){
                
                    if($Nil_Bng >= $value['NILAI_MIN_PENYUSUTAN'] && $Nil_Bng <= $value['NILAI_MAX_PENYUSUTAN']){
                        $xSUSUT = $value['NILAI_PENYUSUTAN'];
                    }
                
                }
            }
        
        }
        
        function cmdHitung_Click(){
        
            global $nMaterial, $nFAS1, $nFAS2, $nSusut, $nSusut1,
            $W0, $W1, $W2, $W3, $W4, $W5, $W6, $W7, $W8, $W9,
            $WW0, $WW1, $WW2, $WW3, $WW4, $WW5, $WW6, $WW7, $WW8, $WW9,
            $s_W0, $s_W4, $s_W5, $s_W6, $s_W7, $s_W8, $s_W9, $s_WW0,
            $QQ1, $QQ2, $QQ3, $QQ4, $QQ5, $QQ6,
            $s_QQ1, $s_QQ2, $s_QQ3, $s_QQ4, $s_QQ5, $s_QQ6,
            $n_Mezanin, $s_nFas2, 
            $DAYA_LISTRIK, $JUM_SPLIT, $JUM_WINDOW, 
            $LUAS_HRINGAN, $LUAS_HSEDANG,$LUAS_HBERAT, $LUAS_HPENUTUP,
            $BAHAN_PAGAR1, $BAHAN_PAGAR2,
            $LEBAR_TANGGA1, $LEBAR_TANGGA2,
            $JUM_PABX, $DALAM_SUMUR,
            $BAKAR_H,$BAKAR_S,$BAKAR_F,
            $JUM_LAP_BETON1,$JUM_LAP_BETON2,
            $JUM_LAP_ASPAL1,$JUM_LAP_ASPAL2,
            $JUM_LAP_RUMPUT1,$JUM_LAP_RUMPUT2,
            $JLIFT, $Luas_Kolam, $JUM_AC_CENTRAL, $JUM_GENSET,
            $Nil_Boiler_Ht, $Nil_Boiler_Ap , $Nil_AC_Central,
            $nDUKUNG,$nMezanine, $nMaterial,
            $xAtap, $xDinding, $xLantai, $xLangit2,
            $nFAS1,$nFAS2,
            $JGuna, $JLANTAI, $ck_Ulin, $nDBKB,
            $N_BANGUNAN, $xSUSUT,
            $nBangunan,$nSistem;

            if(!is_array($JLIFT)) $JLIFT = [0,0,0];
        
            cmdProses_Click();
            DBKB_FAS1();
            DBKB_FAS2();
            DBKB_FAS3();

            $W1 = $DAYA_LISTRIK * $_POST['L_AC']['DAYA_LISTRIK'] * 1 / 1000;
        
            $W2 = $JUM_SPLIT * $_POST['L_AC']['AC_SPLIT'];
            
            $W3 = $JUM_SPLIT *$_POST['L_AC']['AC_WINDOW'];
            
            $W4 = ($LUAS_HRINGAN * $_POST['LPH']['RINGAN']) + ($LUAS_HSEDANG * $_POST['LPH']['SEDANG']) + ($LUAS_HBERAT * $_POST['LPH']['BERAT']) + ($LUAS_HPENUTUP * $_POST['LPH']['P_LANTAI']);
            
            if( $_POST['LPH']['RINGAN'] == 0 || $_POST['LPH']['RINGAN'] == "" ) $LUAS_HRINGAN = 0;
            if( $_POST['LPH']['SEDANG'] == 0 || $_POST['LPH']['SEDANG'] == "" ) $LUAS_HSEDANG = 0;
            if( $_POST['LPH']['BERAT'] == 0 || $_POST['LPH']['BERAT'] == "" ) $LUAS_HBERAT = 0;
            if( $_POST['LPH']['P_LANTAI'] == 0 || $_POST['LPH']['P_LANTAI'] == "" ) $LUAS_HPENUTUP = 0;
        
            $s_W4 = $LUAS_HRINGAN + $LUAS_HSEDANG + $LUAS_HBERAT + $LUAS_HPENUTUP ;
        
            if($_POST['PAGAR']['BP'] == "01" ){
                $W5 = $BAHAN_PAGAR1 * $_POST['PAGAR']['PP'];
                if($_POST['PAGAR']['PP'] == 0 || $_POST['PAGAR']['PP'] == "" ) $BAHAN_PAGAR1 = 0;
                $s_W5 = $BAHAN_PAGAR1;
            }else{
                $W5 = $BAHAN_PAGAR2 * $_POST['PAGAR']['PP'];
                if($_POST['PAGAR']['PP'] == 0 || $_POST['PAGAR']['PP'] == "" ) $BAHAN_PAGAR2 = 0;
                $s_W5 = $BAHAN_PAGAR2;
            }
        
            $W6 = ($LEBAR_TANGGA1 * $_POST['LTB']['LT']) + ($LEBAR_TANGGA2 * $_POST['LTB']['MT']);
        
            if($_POST['LTB']['LT'] == 0 || $_POST['LTB']['LT'] == "" ) $LEBAR_TANGGA1 = 0;
            if($_POST['LTB']['MT'] == 0 || $_POST['LTB']['MT'] == "" ) $LEBAR_TANGGA2 = 0;
        
            $W7 = ($JUM_PABX * $_POST['OTHERS']['JLH_S_PABX']) + ($DALAM_SUMUR * $_POST['OTHERS']['DLM_SUMUR_A']);
        
            if($_POST['OTHERS']['JLH_S_PABX'] == 0 || $_POST['OTHERS']['JLH_S_PABX'] == "" ) $JUM_PABX = 0;
            if($_POST['OTHERS']['DLM_SUMUR_A'] == 0 || $_POST['OTHERS']['DLM_SUMUR_A'] == "" ) $DALAM_SUMUR = 0;
        
            $s_W6 = $LEBAR_TANGGA1 + $LEBAR_TANGGA2;
            $s_W7 = $JUM_PABX + $DALAM_SUMUR;
            
            if($_POST['PK']['HYDRAN'] == "01" ){
                $HW1 = $BAKAR_H ;
            }else{
                $HW1 = 0;
            }
        
            if($_POST['PK']['SPRINGKLER'] == "01" ){ 
                $HW2 = $BAKAR_S ;
            }else{
                $HW2 = 0;
            }
        
            if($_POST['PK']['FIRE_ALARM'] == "01" ){ 
                $HW3 = $BAKAR_F ;
            }else{
                $HW3 = 0;
            }
        
            $W8 = $HW1 + $HW2 + $HW3;
            $s_W8 = $W8;
                
            if($_POST['JLT_DL']['BETON'] * 1 > 1 ){
                $QQ1 = $_POST['JLT_DL']['BETON'] * $JUM_LAP_BETON1;
                if($_POST['JLT_DL']['BETON'] == 0 || $_POST['JLT_DL']['BETON'] == "" ) $JUM_LAP_BETON1 = 0;
                $s_QQ1 = $JUM_LAP_BETON1;
            }else{
                $QQ1 = $_POST['JLT_DL']['BETON'] * $JUM_LAP_BETON1;
                if($_POST['JLT_DL']['BETON'] == 0 || $_POST['JLT_DL']['BETON'] == "" ) $JUM_LAP_BETON1 = 0;
                $s_QQ1 = $JUM_LAP_BETON1;
            }
        
            if($_POST['JLT_TL']['BETON'] * 1 > 1 ){
                $QQ2 = $_POST['JLT_TL']['BETON'] * $JUM_LAP_BETON2;
                if($_POST['JLT_TL']['BETON'] == 0 || $_POST['JLT_TL']['BETON'] == "" ) $JUM_LAP_BETON2 = 0;
                $s_QQ2 = $JUM_LAP_BETON2;
            }else{
                $QQ2 = $_POST['JLT_TL']['BETON'] * $JUM_LAP_BETON2;
                if($_POST['JLT_TL']['BETON'] == 0 || $_POST['JLT_TL']['BETON'] == "" ) $JUM_LAP_BETON2 = 0;
                $s_QQ2 = $JUM_LAP_BETON2;
            }
        
            if($_POST['JLT_DL']['ASPAL'] * 1 > 1 ){
                $QQ3 = $_POST['JLT_DL']['ASPAL'] * $JUM_LAP_ASPAL1;
                if($_POST['JLT_DL']['ASPAL'] == 0 || $_POST['JLT_DL']['ASPAL'] == "" ) $JUM_LAP_ASPAL1 = 0;
                $s_QQ3 = $JUM_LAP_ASPAL1;
            }else{
                $QQ3 = $_POST['JLT_DL']['ASPAL'] * $JUM_LAP_ASPAL1;
                if($_POST['JLT_DL']['ASPAL'] == 0 || $_POST['JLT_DL']['ASPAL'] == "" ) $JUM_LAP_ASPAL1 = 0;
                $s_QQ3 = $JUM_LAP_ASPAL1;
            }
        
            if($_POST['JLT_TL']['ASPAL'] * 1 > 1 ){
                $QQ4 = $_POST['JLT_TL']['ASPAL'] * $JUM_LAP_ASPAL2;
                if($_POST['JLT_TL']['ASPAL'] == 0 || $_POST['JLT_TL']['ASPAL'] == "" ) $JUM_LAP_ASPAL2 = 0;
                $s_QQ4 = $JUM_LAP_ASPAL2;
            }else{
                $QQ4 = $_POST['JLT_TL']['ASPAL'] * $JUM_LAP_ASPAL2;
                if($_POST['JLT_TL']['ASPAL'] == 0 || $_POST['JLT_TL']['ASPAL'] == "" ) $JUM_LAP_ASPAL2 = 0;
                $s_QQ4 = $JUM_LAP_ASPAL2;
            }
        
            if($_POST['JLT_DL']['TR'] * 1 > 1 ){
                $QQ5 = $_POST['JLT_DL']['TR'] * $JUM_LAP_RUMPUT1;
                if($_POST['JLT_DL']['TR'] == 0 || $_POST['JLT_DL']['TR'] == "" ) $JUM_LAP_RUMPUT1 = 0;
                $s_QQ5 = $JUM_LAP_RUMPUT1;
            }else{
                $QQ5 = $_POST['JLT_DL']['TR'] * $JUM_LAP_RUMPUT1;
                if($_POST['JLT_DL']['TR'] == 0 || $_POST['JLT_DL']['TR'] == "" ) $JUM_LAP_RUMPUT1 = 0;
                $s_QQ5 = $JUM_LAP_RUMPUT1;
            }
        
            if($_POST['JLT_TL']['TR'] * 1 > 1 ){
                $QQ6 = $_POST['JLT_TL']['TR'] * $JUM_LAP_RUMPUT2;
                if($_POST['JLT_TL']['TR'] == 0 || $_POST['JLT_TL']['TR'] == "" ) $JUM_LAP_RUMPUT2 = 0;
                $s_QQ6 = $JUM_LAP_RUMPUT2;
            }else{
                $QQ6 = $_POST['JLT_TL']['TR'] * $JUM_LAP_RUMPUT2;
                if($_POST['JLT_TL']['TR'] == 0 || $_POST['JLT_TL']['TR'] == "" ) $JUM_LAP_RUMPUT2 = 0;
                $s_QQ6 = $JUM_LAP_RUMPUT2;
            }
        
            $W9 = $QQ1 + $QQ2 + $QQ3 + $QQ4 + $QQ5 + $QQ6;
            $s_W9 = $s_QQ1 + $s_QQ2 + $s_QQ3 + $s_QQ4 + $s_QQ5 + $s_QQ6;
        
            $W0 = ($JLIFT[0] * $_POST['J_LIFT']['PENUMPANG']) + ($JLIFT[1] * $_POST['J_LIFT']['KAPSUL']) + ($JLIFT[2] * $_POST['J_LIFT']['BARANG']);
        
            if($_POST['J_LIFT']['PENUMPANG'] == 0 || $_POST['J_LIFT']['PENUMPANG'] == "" ) $JLIFT[0] = 0;
            if($_POST['J_LIFT']['KAPSUL'] == 0 || $_POST['J_LIFT']['KAPSUL'] == "" ) $JLIFT[1] = 0;
            if($_POST['J_LIFT']['BARANG'] == 0 || $_POST['J_LIFT']['BARANG'] == "" ) $JLIFT[2] = 0;
        
            $s_W0 = $JLIFT[0] + $JLIFT[1] + $JLIFT[2];
            
            $WW0 = $Luas_Kolam * $_POST['KOLAM_RENANG']['LUAS'];

            if($_POST['KOLAM_RENANG']['LUAS'] == 0 || $_POST['KOLAM_RENANG']['LUAS'] == "" ) $Luas_Kolam = 0;

            $s_WW0 = $Luas_Kolam;
            
            if($_POST['L_AC']['AC_CENTRAL'] == "01"){
                $WW1 = $JUM_AC_CENTRAL;
            }else{
                $WW1 = 0;
            }

            if($_POST['OTHERS']['K_GENSET'] == 0 ) $JUM_GENSET = 0;
            
            $WW2 = $JUM_GENSET;
            
            if($_POST['KD_JPB'] == 7 ){
                $WW3 = $Nil_Boiler_Ht * 0;
            }elseif($_POST['KD_JPB'] == 13 ){
                $WW3 = $Nil_Boiler_Ap * 0;
            }else{
                $WW3 = 0;
            }
                
            if(($_POST['JML_LANTAI_BNG'] > 4) ){
                if($_POST['L_AC']['AC_CENTRAL'] == "01"){
                    $WW1 = 0;
        
                    if($_POST['KD_JPB'] == 2 ){ 
                        $WW4 = $Nil_AC_Central[0];
                    }elseif($_POST['KD_JPB'] == 4 ){ 
                        $WW4 = $Nil_AC_Central[3];
                    }elseif($_POST['KD_JPB'] == 5 ){ 
                        $WW4 = $Nil_AC_Central[4];
                        $WW5 = $Nil_AC_Central[5];
                    }elseif($_POST['KD_JPB'] == 7 ){ 
                        $WW4 = $Nil_AC_Central[1];
                        $WW5 = $Nil_AC_Central[2];
                    }elseif($_POST['KD_JPB'] == 13 ){ 
                        $WW4 = $Nil_AC_Central[6];
                        $WW5 = $Nil_AC_Central[7];
                    }
        
                }else{
                    $WW4 = 0;
                    $WW5 = 0;
                }
            }
        
            if($_POST['KD_JPB'] == 3 || $_POST['KD_JPB'] == 8 ){
                $nDUKUNG = $nDUKUNG ;
                $nMezanine = $nMezanine ;
            }else{
                $nDUKUNG = 0;
                $nMezanine = 0;
            }
        
            $nMaterial = ($xAtap * 1) + ($xDinding * 1) + ($xLantai * 1) + ($xLangit2 * 1);
            $nFAS1 = $W1 + $W2 + $W3 + $WW1 + $WW2 + $WW3 + $WW4 + $WW5; 
            $nFAS2 = $W0 + $W4 + $W5 + $W6 + $W7 + $W8 + $W9 + $WW0 ;
            $s_nFas2 = $s_W0 + $s_W4 + $s_W5 + $s_W6 + $s_W7 + $s_W8 + $s_W9 + $s_WW0 ;
            
            if($_POST['JNS_KONSTRUKSI_BNG'] == 4 && $ck_Ulin == 0 ) $nDBKB = $nDBKB * 0.7;
        
            $JGuna = $_POST['KD_JPB'];
            $JLANTAI = $_POST['KONDISI_BNG'];
            
            if($_POST['LUAS_BNG'] == "" || $_POST['LUAS_BNG'] == 0 ) $_POST['LUAS_BNG'] == 1;
        
            if(0 == 0){ 
                $n_Mezanin = 0 ;
            }else{
                $n_Mezanin = $nMezanine / 0;
            }
        
            if(($JGuna == 1 || $JGuna == 3 || $JGuna == 8 || $JGuna == 10 || $JGuna == 11 || $JGuna == 2 || $JGuna == 4 || $JGuna == 5 || $JGuna == 7 || $JGuna == 9) && $JLANTAI <= 4 && ($_POST['KD_JPB'] != 14 || $_POST['KD_JPB'] != 15) ){
                $N_BANGUNAN = (($nDBKB * 1 + $nMaterial * 1)) + ($nDUKUNG * 1 / $_POST['LUAS_BNG']) + ($n_Mezanin * 1 + $s_nFas2 * 1);
            }else{
                $nMaterial = 0;
                $N_BANGUNAN = (($nDBKB * 1)) + ($nDUKUNG * 1 / $_POST['LUAS_BNG']) + ($n_Mezanin * 1 + $s_nFas2 * 1);
            }

            tampil_Susut($N_BANGUNAN * 1000);

            if($JGuna == 15 && $xSUSUT > 50 ){
                $xSUSUT = 50;
            }
        
            $nSusut1 = $xSUSUT / 100 * $nFAS2 ;
            $nBangunan = (($nDBKB * 1 + $nMaterial) * $_POST['LUAS_BNG']) + $nDUKUNG + $nMezanine;
        
            $nSusut = $nSusut1 + ($xSUSUT / 100 * $nBangunan);
            
            $nSistem = ($nFAS1 + $nFAS2 + $nBangunan) - $nSusut;

            if($_POST['KD_JPB'] == 17 ) $nSistem = $nDBKB;
            if($_POST['KD_JPB'] == 11 ) $nSistem = 0;

            return true;
            
        }

        if(cmdHitung_Click()){
            $LDBKB = $nDBKB;
    
            // set return data
                $data = [];
    
                $data['nDBKB'] = $nDBKB;
                $data['nMezanine'] = $nMezanine;
                $data['LDBKB'] = $LDBKB;
                
                $data['nDUKUNG'] = $nDUKUNG;
                $data['nTipe_K'] = $nTipe_K;
    
                $data['xDinding'] = $xDinding;
                $data['xLantai'] = $xLantai;
                $data['xAtap'] = $xAtap;
                $data['xLangit2'] = $xLangit2;
    
                $data['TPajak'] = $TPajak; 
                $data['TRenovasi'] = $TRenovasi; 
                $data['TBangun'] = $TBangun; 
                $data['JLANTAI'] = $JLANTAI; 
                $data['JGuna'] = $JGuna; 
                $data['Umur'] = $Umur; 
                $data['JL'] = $JL;
                $data['umur_EFF'] = $umur_EFF;
    
                $data['X'] = $X;
                $data['JPB'] = $JPB;
    
                $data['cTipe'] = $cTipe;
                $data['CC'] = $CC;
    
                $data['nMaterial'] = $nMaterial; 
                $data['nFAS1'] = $nFAS1; 
                $data['nFAS2'] = $nFAS2; 
                $data['nSusut'] = $nSusut; 
                $data['nSusut1'] = $nSusut1;
    
                $data['W0'] = $W0; 
                $data['W1'] = $W1;
                $data['W2'] = $W2;
                $data['W3'] = $W3;
                $data['W4'] = $W4;
                $data['W5'] = $W5;
                $data['W6'] = $W6;
                $data['W7'] = $W7;
                $data['W8'] = $W8;
                $data['W9'] = $W9;
                
                $data['WW0'] = $WW0; 
                $data['WW1'] = $WW1;
                $data['WW2'] = $WW2;
                $data['WW3'] = $WW3;
                $data['WW4'] = $WW4;
                $data['WW5'] = $WW5;
                $data['WW6'] = $WW6;
                $data['WW7'] = $WW7;
                $data['WW8'] = $WW8;
                $data['WW9'] = $WW9;
                
                $data['s_W0'] = $s_W0;
                $data['s_W4'] = $s_W4;
                $data['s_W5'] = $s_W5;
                $data['s_W6'] = $s_W6;
                $data['s_W7'] = $s_W7;
                $data['s_W8'] = $s_W8;
                $data['s_W9'] = $s_W9;
                $data['s_WW0'] = $s_WW0;
                
                $data['QQ1'] = $QQ1;
                $data['QQ2'] = $QQ2; 
                $data['QQ3'] = $QQ3;
                $data['QQ4'] = $QQ4;
                $data['QQ5'] = $QQ5;
                $data['QQ6'] = $QQ6;
                
                $data['s_QQ1'] = $s_QQ1; 
                $data['s_QQ2'] = $s_QQ2;
                $data['s_QQ3'] = $s_QQ3;
                $data['s_QQ4'] = $s_QQ4;
                $data['s_QQ5'] = $s_QQ5;
                $data['s_QQ6'] = $s_QQ6;
                
                $data['n_Mezanin'] = $n_Mezanin; 
                $data['s_nFas2'] = $s_nFas2;
    
                $data['DAYA_LISTRIK'] = $DAYA_LISTRIK;
                $data['JUM_SPLIT'] = $JUM_SPLIT;
                $data['JUM_WINDOW'] = $JUM_WINDOW;
                $data['JUM_AC_CENTRAL'] = $JUM_AC_CENTRAL;
    
                $data['LUAS_HRINGAN'] = $LUAS_HRINGAN;
                $data['LUAS_HSEDANG'] = $LUAS_HSEDANG;
                $data['LUAS_HBERAT'] = $LUAS_HBERAT;
                $data['LUAS_HPENUTUP'] = $LUAS_HPENUTUP;
                
                $data['JUM_LAP_BETON1'] = $JUM_LAP_BETON1;
                $data['JUM_LAP_ASPAL1'] = $JUM_LAP_ASPAL1;
                $data['JUM_LAP_RUMPUT1'] = $JUM_LAP_RUMPUT1;
                $data['JUM_LAP_BETON2'] = $JUM_LAP_BETON2;
                $data['JUM_LAP_ASPAL2'] = $JUM_LAP_ASPAL2;
                $data['JUM_LAP_RUMPUT2'] = $JUM_LAP_RUMPUT2;
                $data['JUM_LAP_BETON11'] = $JUM_LAP_BETON11;
                $data['JUM_LAP_ASPAL11'] = $JUM_LAP_ASPAL11;
                $data['JUM_LAP_RUMPUT11'] = $JUM_LAP_RUMPUT11;
                $data['JUM_LAP_BETON21'] = $JUM_LAP_BETON21;
                $data['JUM_LAP_ASPAL21'] = $JUM_LAP_ASPAL21;
                $data['JUM_LAP_RUMPUT21'] = $JUM_LAP_RUMPUT21;
    
                $data['BAHAN_PAGAR1'] = $BAHAN_PAGAR1;
                $data['BAHAN_PAGAR2'] = $BAHAN_PAGAR2;
    
                $data['LEBAR_TANGGA1'] = $LEBAR_TANGGA1;
                $data['LEBAR_TANGGA2'] = $LEBAR_TANGGA2;
    
                $data['BAKAR_H'] = $BAKAR_H;
                $data['BAKAR_S'] = $BAKAR_S;
                $data['BAKAR_F'] = $BAKAR_F;
    
                $data['JUM_PABX'] = $JUM_PABX;
    
                $data['DALAM_SUMUR'] = $DALAM_SUMUR;
    
                $data['Nil_AC_Central'] = $Nil_AC_Central;
                $data['Nil_Boiler_Ht'] = $Nil_Boiler_Ht;
                
                $data['JLIFT'] = $JLIFT;
                $data['Luas_Kolam'] = $Luas_Kolam;
                $data['JUM_GENSET'] = $JUM_GENSET;
    
                $data['xKondisi'] = $xKondisi;
                $data['xSUSUT'] = $xSUSUT;
    
                $data['ck_Ulin'] = $ck_Ulin;
                $data['N_BANGUNAN'] = $N_BANGUNAN;
    
                $data['nBangunan'] = $nBangunan;
                $data['nSistem'] = $nSistem;
    
            echo json_encode($data);
            die;
        }

    }

    if(isset($_POST['insert'])){
    
        extract($_POST);

        $xxKec = substr($NOP,6,3);
        $xxKel = substr($NOP,10,3);
        $xxBlok = substr($NOP,14,3);
        $xxUrut = substr($NOP,18,4);
        $xxJenis = substr($NOP,23,1);

        function CALL_FASILITAS(){

            global $xxKec,$xxKel,$xxBlok,$xxUrut,$xxJenis;

            extract($_POST);

            $qb = new QueryBuilder();

            if(substr($BKF_PAGAR_HASIL,3) > 1 ){
                $iSQL4 = "INSERT INTO DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','" . substr($PAGAR['BP'],0,2) . "','" . round($PAGAR['PP']) . "')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_PH_RINGAN_HASIL ,3)> 1 ){ 
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','14','" . round($LPH['RINGAN']) . "')";
                
                $qb->rawQuery($iSQL4)->exec();
            }
            
            if(substr($BKF_PH_SEDANG_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','15','" . round($LPH['SEDANG']) . "')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_PH_BERAT_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','16','" . round($LPH['BERAT']) . "')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_PH_PL_HASIL ,3)> 1 ){ 
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','17','" . round($LPH['P_LANTAI']) . "')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_KG_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','40','" . round($OTHERS['K_GENSET']) . "')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_SA_HASIL ,3)> 1 ){ 
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','42','" . round($OTHERS['DLM_SUMUR_A']) . "')";
                
                $qb->rawQuery($iSQL4)->exec();
            }
            
            if(substr($BKF_JSP_HASIL ,3)> 1 ){ 
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','41','" . round($OTHERS['JLH_S_PABX']) . "')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_KR_HASIL ,3)> 1 ){ 
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','" . $KOLAM_RENANG['F_KOLAM'] . "','" . round($KOLAM_RENANG['LUAS']) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_PK_HYDRAN_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','37','" . round($LUAS_BNG) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_PK_SPRINGKLER_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','39','" . round($LUAS_BNG) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_PK_FIRE_AL_HASIL ,3)> 1 ){ 
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','38','" . round($LUAS_BNG) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            
            if(substr($BKF_LT_DL_BETON_HASIL ,3)> 1 ){ 
                if(FLK1(36).Text == 1 ){
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','18','" . round($JLT_DL['BETON']) . " ')";
                }else{
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','24','" . round($JLT_DL['BETON']) . " ')";
                }
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_LT_DL_ASPAL_HASIL,3) > 1 ){
                if(FLK1(39).Text == 1 ){
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','19','" . round($JLT_DL['ASPAL']) . " ')";
                }else{
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','25','" . round($JLT_DL['ASPAL']) . " ')";
                }
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_LT_DL_TANAH_HASIL ,3)> 1 ){ 
                if(FLK1(42).Text == 1 ){
                        $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','20','" . round($JLT_DL['TR']) . " ')";
                }else{
                        $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','26','" . round($JLT_DL['TR']) . " ')";
                }
                
                $qb->rawQuery($iSQL4)->exec();
                
            }

            if(substr($BKF_LT_TL_BETON_HASIL,3) > 1 ){
                if(FLK1(45).Text == 1 ){
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','21','" . round($JLT_TL['BETON']) . " ')";
                }else{
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','27','" . round($JLT_TL['BETON']) . " ')";
                }
                    
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_LT_TL_ASPAL_HASIL,3) > 1 ){
                if(FLK1(48).Text == 1 ){
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','22','" . round($JLT_TL['ASPAL']) . " ')";
                }else{
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','28','" . round($JLT_TL['ASPAL']) . " ')";
                }
                    
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_LT_TL_TANAH_HASIL,3) > 1 ){
                if(FLK1(51).Text == 1 ){
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','23','" . round($JLT_TL['TR']) . " ')";
                }else{
                    $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','29','" . round($JLT_TL['TR']) . " ')";
                }
                    
                $qb->rawQuery($iSQL4)->exec();
            }
            
            if(substr($BKF_LIFT_PENUMPANG_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','30','" . round($J_LIFT['PENUMPANG']) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_LIFT_KAPSUL_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','31','" . round($J_LIFT['KAPSUL']) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_LIFT_BARANG_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','32','" . round($J_LIFT['BARANG']) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }
            
            if(substr($BKF_ESKALATOR_KD_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','33','" . round($LTB['LT']) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_ESKALATOR_LD_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','34','" . round($LTB['MT']) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }
            
            if(substr($BKF_AC_BNG_LAIN_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','" . substr(trim($AC1),0, 2) . "','" . round($FLK169) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_AC_KAMAR_HASIL,3) > 1 ){

                if(xLK(0).Text == "05" ) $xFas = "07" ;

                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','" . substr(trim($AC2),0, 2) . "','" . round($FLK172) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_AC_RUANGAN_LAIN_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','" . substr(trim($AC3),0, 2) . "','" . round($FLK175) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_AC_BOILER_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','" . substr(trim($LBOILER),0, 2) . "','" . round($FLK178) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

            if(substr($BKF_TD_DL_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','44','" . round($L_AC['DAYA_LISTRIK'] * 1000) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }
            
            if(substr($BKF_TD_JAS_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','01','" . round($L_AC['AC_SPLIT']) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }
            
            if(substr($BKF_TD_JAW_HASIL,3) > 1 ){
                $iSQL4 = "insert into DAT_FASILITAS_BANGUNAN(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KD_FASILITAS,JML_SATUAN) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $NO_BNG . "','02','" . round($L_AC['AC_SPLIT']) . " ')";
                
                $qb->rawQuery($iSQL4)->exec();
            }

        }

        function CALL_TAMBAHAN(){

            global $xxKec,$xxKel,$xxBlok,$xxUrut,$xxJenis;

            extract($_POST);

            $xJPB = $_POST['KD_JPB'];

            if( ($xJPB == 1 || $xJPB == 10 || $xJPB == 11) || (($xJPB == 2 || $xJPB == 4 || $xJPB == 5 || $xJPB == 7 || $xJPB == 9) && $_POST['JML_LANTAI_BNG'] <= 4) ){

                // DATA TIDAK BENAR

            }elseif( $xJPB == "02" ){ 
                $iSQL5 = "insert into DAT_JPB2(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KLS_JPB2) " & "Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','1')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "03" ){ 

                $iSQL5 = "insert into DAT_JPB3(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,TYPE_KONSTRUKSI,TING_KOLOM_JPB3,LBR_BENT_JPB3,LUAS_MEZZANINE_JPB3,KELILING_DINDING_JPB3,DAYA_DUKUNG_LANTAI_JPB3) " . "Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "','" . $_POST['NO_BNG'] . "','" . $nTipe_K . "','" . round(0) . " ','" . round(0) . "','" . round(0) . "','" . round(0) . "','" . round(0) . "')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "04" ){ 

                $iSQL5 = "insert into DAT_JPB4(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KLS_JPB4) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . 1 . " ')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "05" ){

                $iSQL5 = "insert into DAT_JPB5(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KLS_JPB5,LUAS_KMR_JPB5_DGN_AC_SENT,LUAS_RNG_LAIN_JPB5_DGN_AC_SENT) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . 1 . " ','" . round(0) . " ','" . round(0) . " ')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "06" ){ 

                $iSQL5 = "insert into DAT_JPB6(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KLS_JPB6) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . 1 . " ')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "07" ){ 

                $iSQL5 = "insert into DAT_JPB7(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,JNS_JPB7,BINTANG_JPB7,JML_KMR_JPB7,LUAS_KMR_JPB7_DGN_AC_SENT,LUAS_KMR_LAIN_JPB7_DGN_AC_SENT)" . "Values ('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "','" . $_POST['NO_BNG'] . "','" . 1 . "','" . 0 . "','" . round(0) . "','" . round(0) . "','" . round(0) . "')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "08" ){ 

                $iSQL5 = "insert into DAT_JPB8(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,TYPE_KONSTRUKSI,TING_KOLOM_JPB8,LBR_BENT_JPB8,LUAS_MEZZANINE_JPB8,KELILING_DINDING_JPB8,DAYA_DUKUNG_LANTAI_JPB8) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "','" . $_POST['NO_BNG'] . "','" . $nTipe_K . "','" . round(0) . " ','" . round(0) . "','" . round(0) . "','" . round(0) . "','" . round(0) . "')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "09" ){

                $iSQL5 = "insert into DAT_JPB9(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KLS_JPB9) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . 1 . " ')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "12" ){

                $iSQL5 = "insert into DAT_JPB12(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,TYPE_JPB12) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . 1 . " ')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "13" ){

                $iSQL5 = "insert into DAT_JPB13(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KLS_JPB13,JML_JPB13,LUAS_JPB13_DGN_AC_SENT,LUAS_JPB13_LAIN_DGN_AC_SENT) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "','" . $_POST['NO_BNG'] . "','" . 1 . "','" . round(0) . "','" . round(0) . "','" . round(0) . "')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "14" ){

                $iSQL5 = "insert into DAT_JPB14(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,LUAS_KANOPI_JPB14) " . "Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . round(xLK(1).Text, 0) . " ')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "15" ){ 

                $iSQL5 = "insert into DAT_JPB15(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,LETAK_TANGKI_JPB15,KAPASITAS_TANGKI_JPB15)  Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . 1 . " ', '" . round(0) . " ')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "16" ){

                $iSQL5 = "insert into DAT_JPB16(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,KLS_JPB16) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . 1 . "')";

                $qb->rawQuery($iSQL5)->exec();

            }elseif( $xJPB == "17" ){ 

                $iSQL5 = "insert into DAT_JPB17(KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,NO_BNG,TINGGI_BNG_JPB17) Values('12', '12', '" . $xxKec . "', '" . $xxKel . "', '" . $xxBlok . "', '" . $xxUrut . "', '" . $xxJenis . "', '" . $_POST['NO_BNG'] . "','" . round(0) . "')";

                $qb->rawQuery($iSQL5)->exec();

            }
        }

        $sql = "INSERT_BANGUNAN '12','12','" . $xxKec . "','" . $xxKel . "','" . $xxBlok . "','" . $xxUrut . "','" . $xxJenis . "'," ."'" . $NO_BNG . "','" . $KD_JPB . "','" . $NO_FORMULIR_LSPOP . "','" . $THN_DIBANGUN_BNG . "','" . $THN_RENOVASI_BNG . "'," ."'" . round($LUAS_BNG). "','" . $JML_LANTAI_BNG . "','" . $KONDISI_BNG . "','" . $JNS_KONSTRUKSI_BNG . "'," . "'" . $JNS_ATAP_BNG . "','" . $KD_DINDING . "','" . $KD_LANTAI . "','" . $KD_LANGIT_LANGIT . "','" . round($tTotal1) . "','1'," .
                "'" . $TGL_PENDATAAN_BNG . "','" . $NIP_PENDATA_BNG . "','" . $TGL_PEMERIKSAAN_BNG . "','" . $NIP_PEMERIKSA_BNG . "'," .
                "'" . $TGL_PEREKAM_BNG . "','" . $NIP_PEREKAM_BNG . "','" . round($JUM1) . "','" . round($JUM2) . "'," .
                "'" . round($JUM3) . "','" . round($JUM4) . "','" . round($JUM5) . "','" . round($xSUSUT) . "','" . round($NILAI_INDIVIDU) . "','0'";

        $insert = $qb->rawQuery($sql)->exec();
        
        if($insert){

            CALL_FASILITAS();
            CALL_TAMBAHAN();

            set_flash_msg(['success'=>'Data Saved']);
            header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
            return;

        }


    }

}