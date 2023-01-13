<?php

$parent_path = '../';
if (in_array(php_sapi_name(),["cli","cgi-fcgi"])) {
    $parent_path = '';
}

require $parent_path . 'config/main.php';
require $parent_path . 'helpers/Builder.php';
require $parent_path . 'helpers/Form.php';
require $parent_path . 'helpers/Mailer.php';
require_once $parent_path . 'config/database.php';

if(file_exists($parent_path . 'vendor/autoload.php'))
{
    require $parent_path . 'vendor/autoload.php';
}

function conn(){
    global $conn;

    return $conn;
}

function getModules(){
    return require '../config/modules.php';
}

function stringContains($string,$val){
    if(!is_array($val)){
        if (strpos($string, $val) !== false) {
            return true;
        }
    }else{
        if (arrStringContains($string, $val) !== false) {
            return true;
        }
    }

    return false;
}

function arrStringContains($string,$arr){

    $result = [];

    foreach ($arr as $key => $value) {
        if(!is_array($arr[$key])){
            $result[] = stringContains($string,$arr[$key]);
        }else{
            $result[] = arrStringContains($string,$arr[$key]);
        }
    }

    return in_array(true,$result);
}

function isBuilder(){
    if(isset($_GET['page'])){
        $curr_page = $_GET['page'] == 'builder/crud/index';
    
        return $curr_page;
    }
}

function getCurrentPageDataNav($str){
    if(!isBuilder()){
        $curr_page = $_GET['page'] == 'builder/'.$str.'/index';
        return $curr_page ? 'bg-purple-700 text-white' : '';
    }else{
        $data = $_GET['data'];
        return (isset($data) ? $data : false) == $str ? 'bg-purple-700 text-white' : '';
    }
}

function isJson($string) {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}

function url(){
    $server_name = $_SERVER['SERVER_NAME'];

    if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
        $port = ":$_SERVER[SERVER_PORT]";
    } else {
        $port = '';
    }

    if (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
        $scheme = 'https';
    } else {
        $scheme = 'http';
    }
    return $scheme.'://'.$server_name.$port;
}

function mime_icon_name($mime)
{
    $mimet = array( 
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'file-archive' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'video' => 'video/mp4',

        // adobe
        'file-pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',


        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    $key = array_search($mime, $mimet);
    return $key;
}

function load($path, $action = false)
{   
    $default_action_path = '../actions/'; 
    $default_view_path = '../resources/views/'; 
    if (strpos($path, 'builder') === 0) {
        $path = substr($path,8);
        $default_action_path = '../builder/actions/'; 
        $default_view_path = '../builder/views/'; 
    }

    if(is_string($action)) $action = $default_action_path.$action.'.php';
    if(is_bool($action) || $action == 1) $action = $default_action_path.$path.'.php';

    if($action && file_exists($action))
        require $action;
    
    $view   = $default_view_path.$path.'.php';
    if(file_exists($view))
        require $view;

    return;
}

function load_action($path)
{
    $view   = '../actions/'.$path.'.php';
    if (strpos($path, 'builder') === 0) {
        $path = substr($path,8);
        $view = '../builder/actions/'.$path.'.php'; 
    }
    if(file_exists($view))
        require $view;

    return;
}

function upload($file, $dest, $filename = false)
{
    $original_name = $file['name'];
    $folder = '../storage/'.$dest;
    if(!file_exists($folder))
        if (!@mkdir($folder)) {
            $error = error_get_last();
            echo $error['message'];
        }
    $fname = $filename ? $filename : strtotime('now') . '_' . $file['name'];
    $filename = $folder.'/'.$fname;
    if(move_uploaded_file($file['tmp_name'],$filename))
    {
        $mime = mime_content_type($filename);
        $mime = mime_icon_name($mime);
        return ["status"=>"success","msg"=>"Upload ".$original_name." Berhasil","filename"=>$fname,"original_name"=>$original_name,"mime"=>$mime];
    }
    else
        return ["status"=>"fail","msg"=>"Upload ".$original_name." Gagal\n".$file['error']];
}

function request($method = false)
{
    if(!$method)
        return $_SERVER['REQUEST_METHOD'];

    if(strtolower($method) == 'post')
        return $_POST;

    return $_GET;
}

function get_file_storage($file)
{
    return 'storage/'.$file;
}

function set_flash_msg($data)
{
    $_SESSION['flash'] = $data;
}

function get_flash_msg($key)
{
    if(isset($_SESSION['flash'][$key]))
    {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }     		
    return ucwords($hasil);
}

function tanggal_indo($tanggal)
{
	$bulan = array (1 =>   'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember'
			);
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}


function startWith($str, $cmp)
{
    return substr($str, 0, strlen($cmp)) === $cmp;
}

function numberToRomanRepresentation($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

function createObjekPajakBangunan($dt){

    $qb = new QueryBuilder();

    $_POST = $dt;

    $_POST['L_AC'] = (array) json_decode($dt['L_AC']);
    $_POST['LPH'] = (array) json_decode($dt['LPH']);
    $_POST['JLT_DL'] = (array) json_decode($dt['JLT_DL']);
    $_POST['JLT_TL'] = (array) json_decode($dt['JLT_TL']);
    $_POST['PAGAR'] = (array) json_decode($dt['PAGAR']);
    $_POST['LTB'] = (array) json_decode($dt['LTB']);
    $_POST['PK'] = (array) json_decode($dt['PK']);
    $_POST['J_LIFT'] = (array) json_decode($dt['J_LIFT']);
    $_POST['OTHERS'] = (array) json_decode($dt['OTHERS']);
    $_POST['KOLAM_RENANG'] = (array) json_decode($dt['KOLAM_RENANG']);

    // HITUNG

        global $nDBKB, $nMezanine, $LDBKB, $nTipe_K, $nDUKUNG
        , $xDinding,$xLantai,$xAtap,$xLangit2
        , $TPajak,$TRenovasi,$TBangun,$JLANTAI,$JGuna,$Umur,$JL,$umur_EFF
        , $X,$JPB
        , $cTipe,$CC
        , $nMaterial,$nFAS1,$nFAS2,$nSusut,$nSusut1
        , $W0,$W1,$W2,$W3,$W4,$W5,$W6,$W7,$W8,$W9
        , $WW0,$WW1,$WW2,$WW3,$WW4,$WW5,$WW6,$WW7,$WW8,$WW9
        , $s_W0,$s_W4,$s_W5,$s_W6,$s_W7,$s_W8,$s_W9,$s_WW0
        , $QQ1,$QQ2,$QQ3,$QQ4,$QQ5,$QQ6
        , $s_QQ1,$s_QQ2,$s_QQ3,$s_QQ4,$s_QQ5,$s_QQ6
        , $n_Mezanin,$s_nFas2
        , $DAYA_LISTRIK
        , $JUM_SPLIT,$JUM_WINDOW,$JUM_AC_CENTRAL
        , $LUAS_HRINGAN,$LUAS_HSEDANG,$LUAS_HBERAT,$LUAS_HPENUTUP
        , $JUM_LAP_BETON1,$JUM_LAP_ASPAL1,$JUM_LAP_RUMPUT1,$JUM_LAP_BETON2,$JUM_LAP_ASPAL2,$JUM_LAP_RUMPUT2,$JUM_LAP_BETON11,$JUM_LAP_ASPAL11,$JUM_LAP_RUMPUT11,$JUM_LAP_BETON21,$JUM_LAP_ASPAL21,$JUM_LAP_RUMPUT21
        , $BAHAN_PAGAR1,$BAHAN_PAGAR2
        , $LEBAR_TANGGA1,$LEBAR_TANGGA2
        , $BAKAR_H,$BAKAR_S,$BAKAR_F
        , $JUM_PABX
        , $DALAM_SUMUR
        , $Nil_AC_Central,$Nil_Boiler_Ht
        , $JLIFT,$Luas_Kolam,$JUM_GENSET
        , $xKondisi,$xSUSUT
        , $ck_Ulin,$N_BANGUNAN
        , $nBangunan,$nSistem;

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
        
                $S_Listrik = number_format($DAYA_LISTRIK, 2);
        
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
        
                $NFAS = $value['NILAI_DEP_MIN_MAX'];
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

            $_POST['nDBKB'] = $nDBKB;
            $_POST['nMezanine'] = $nMezanine;
            $_POST['LDBKB'] = $LDBKB;
            
            $_POST['nDUKUNG'] = $nDUKUNG;
            $_POST['nTipe_K'] = $nTipe_K;

            $_POST['xDinding'] = $xDinding;
            $_POST['xLantai'] = $xLantai;
            $_POST['xAtap'] = $xAtap;
            $_POST['xLangit2'] = $xLangit2;

            $_POST['TPajak'] = $TPajak; 
            $_POST['TRenovasi'] = $TRenovasi; 
            $_POST['TBangun'] = $TBangun; 
            $_POST['JLANTAI'] = $JLANTAI; 
            $_POST['JGuna'] = $JGuna; 
            $_POST['Umur'] = $Umur; 
            $_POST['JL'] = $JL;
            $_POST['umur_EFF'] = $umur_EFF;

            $_POST['X'] = $X;
            $_POST['JPB'] = $JPB;

            $_POST['cTipe'] = $cTipe;
            $_POST['CC'] = $CC;

            $_POST['nMaterial'] = $nMaterial; 
            $_POST['nFAS1'] = $nFAS1; 
            $_POST['nFAS2'] = $nFAS2; 
            $_POST['nSusut'] = $nSusut; 
            $_POST['nSusut1'] = $nSusut1;
            
            $_POST['n_Mezanin'] = $n_Mezanin; 
            $_POST['s_nFas2'] = $s_nFas2;

            $_POST['DAYA_LISTRIK'] = $DAYA_LISTRIK;
            $_POST['JUM_SPLIT'] = $JUM_SPLIT;
            $_POST['JUM_WINDOW'] = $JUM_WINDOW;
            $_POST['JUM_AC_CENTRAL'] = $JUM_AC_CENTRAL;

            $_POST['LUAS_HRINGAN'] = $LUAS_HRINGAN;
            $_POST['LUAS_HSEDANG'] = $LUAS_HSEDANG;
            $_POST['LUAS_HBERAT'] = $LUAS_HBERAT;
            $_POST['LUAS_HPENUTUP'] = $LUAS_HPENUTUP;
            
            $_POST['JUM_LAP_BETON1'] = $JUM_LAP_BETON1;
            $_POST['JUM_LAP_ASPAL1'] = $JUM_LAP_ASPAL1;
            $_POST['JUM_LAP_RUMPUT1'] = $JUM_LAP_RUMPUT1;
            $_POST['JUM_LAP_BETON2'] = $JUM_LAP_BETON2;
            $_POST['JUM_LAP_ASPAL2'] = $JUM_LAP_ASPAL2;
            $_POST['JUM_LAP_RUMPUT2'] = $JUM_LAP_RUMPUT2;
            $_POST['JUM_LAP_BETON11'] = $JUM_LAP_BETON11;
            $_POST['JUM_LAP_ASPAL11'] = $JUM_LAP_ASPAL11;
            $_POST['JUM_LAP_RUMPUT11'] = $JUM_LAP_RUMPUT11;
            $_POST['JUM_LAP_BETON21'] = $JUM_LAP_BETON21;
            $_POST['JUM_LAP_ASPAL21'] = $JUM_LAP_ASPAL21;
            $_POST['JUM_LAP_RUMPUT21'] = $JUM_LAP_RUMPUT21;

            $_POST['BAHAN_PAGAR1'] = $BAHAN_PAGAR1;
            $_POST['BAHAN_PAGAR2'] = $BAHAN_PAGAR2;

            $_POST['LEBAR_TANGGA1'] = $LEBAR_TANGGA1;
            $_POST['LEBAR_TANGGA2'] = $LEBAR_TANGGA2;

            $_POST['BAKAR_H'] = $BAKAR_H;
            $_POST['BAKAR_S'] = $BAKAR_S;
            $_POST['BAKAR_F'] = $BAKAR_F;

            $_POST['JUM_PABX'] = $JUM_PABX;

            $_POST['DALAM_SUMUR'] = $DALAM_SUMUR;

            $_POST['Nil_AC_Central'] = $Nil_AC_Central;
            $_POST['Nil_Boiler_Ht'] = $Nil_Boiler_Ht;
            
            $_POST['JLIFT'] = $JLIFT;
            $_POST['Luas_Kolam'] = $Luas_Kolam;
            $_POST['JUM_GENSET'] = $JUM_GENSET;

            $_POST['xKondisi'] = $xKondisi;
            $_POST['xSUSUT'] = $xSUSUT;

            $_POST['ck_Ulin'] = $ck_Ulin;
            $_POST['N_BANGUNAN'] = $N_BANGUNAN;

            $_POST['nBangunan'] = $nBangunan;
            $_POST['nSistem'] = $nSistem;

            // INSERT

                $_POST['JUM1'] = ($_POST['LUAS_BNG'] * $LDBKB) + ($_POST['LUAS_BNG'] * $nDUKUNG);
                $_POST['JUM2'] = ($_POST['LUAS_BNG'] * $xAtap ) + ($_POST['LUAS_BNG'] * $xDinding) + ($_POST['LUAS_BNG'] * $xLantai) + ($_POST['LUAS_BNG'] * $xLangit2);

                $JUM3 = 0;
                $_POST['BKF_PAGAR_HASIL'] = 0;

                // PAGAR

                if($_POST['PAGAR']['PP'] == "01"){
                    $_POST['BKF_PAGAR_HASIL'] += $_POST['PAGAR']['PP'] * $BAHAN_PAGAR1;
                }else{
                    $_POST['BKF_PAGAR_HASIL'] += $_POST['PAGAR']['PP'] * $BAHAN_PAGAR2;
                }

                $JUM3 += $_POST['BKF_PAGAR_HASIL'];

                // PH

                $_POST['BKF_PH_RINGAN_HASIL'] = $_POST['LPH']['RINGAN'] * $LUAS_HRINGAN;
                $_POST['BKF_PH_SEDANG_HASIL'] = $_POST['LPH']['SEDANG'] * $LUAS_HSEDANG;
                $_POST['BKF_PH_BERAT_HASIL'] = $_POST['LPH']['BERAT'] * $LUAS_HBERAT;
                $_POST['BKF_PH_PL_HASIL'] = $_POST['LPH']['P_LANTAI'] * $LUAS_HPENUTUP;

                $JUM3 += $_POST['BKF_PH_RINGAN_HASIL'];
                $JUM3 += $_POST['BKF_PH_SEDANG_HASIL'];
                $JUM3 += $_POST['BKF_PH_BERAT_HASIL'];
                $JUM3 += $_POST['BKF_PH_PL_HASIL'];
                
                // GENSET
                $_POST['BKF_KG_HASIL'] = $_POST['OTHERS']['K_GENSET'] * $JUM_GENSET;

                $JUM3 += $_POST['BKF_KG_HASIL'];
                
                // SUMUR
                $_POST['BKF_SA_HASIL'] = $_POST['OTHERS']['DLM_SUMUR_A'] * $DALAM_SUMUR;

                $JUM3 += $_POST['BKF_SA_HASIL'];
                
                // PABX
                $_POST['BKF_JSP_HASIL'] = $_POST['OTHERS']['JLH_S_PABX'] * $JUM_PABX;
                $JUM3 += $_POST['BKF_JSP_HASIL'];
                
                // KOLAM
                $_POST['BKF_KR_HASIL'] = $_POST['KOLAM_RENANG']['LUAS'] * $Luas_Kolam;
                $JUM3 += $_POST['BKF_KR_HASIL'];
                
                // PEMADAM

                $_POST['BKF_PK_HYDRAN_HASIL'] = $_POST['LUAS_BNG'] * $BAKAR_H;
                $_POST['BKF_PK_SPRINGKLER_HASIL'] = $_POST['LUAS_BNG'] * $BAKAR_S;
                $_POST['BKF_PK_FIRE_AL_HASIL'] = $_POST['LUAS_BNG'] * $BAKAR_F;

                $JUM3 += $_POST['BKF_PK_HYDRAN_HASIL'];
                $JUM3 += $_POST['BKF_PK_SPRINGKLER_HASIL'];
                $JUM3 += $_POST['BKF_PK_FIRE_AL_HASIL'];

                // LIFT

                $_POST['BKF_LIFT_PENUMPANG_HASIL'] = $_POST['J_LIFT']['PENUMPANG'] * $JLIFT[0];
                $_POST['BKF_LIFT_KAPSUL_HASIL'] = $_POST['J_LIFT']['KAPSUL'] * $JLIFT[1];
                $_POST['BKF_LIFT_BARANG_HASIL'] = $_POST['J_LIFT']['BARANG'] * $JLIFT[2];

                $JUM3 +=  $_POST['BKF_LIFT_PENUMPANG_HASIL'];
                $JUM3 +=  $_POST['BKF_LIFT_KAPSUL_HASIL'];
                $JUM3 +=  $_POST['BKF_LIFT_BARANG_HASIL'];

                // ESKALATOR

                $_POST['BKF_ESKALATOR_LD_HASIL'] = $_POST['LTB']['LT'] * $LEBAR_TANGGA1;
                $_POST['BKF_ESKALATOR_KD_HASIL'] = $_POST['LTB']['MT'] * $LEBAR_TANGGA2;

                $JUM3 += $_POST['BKF_ESKALATOR_LD_HASIL'];
                $JUM3 += $_POST['BKF_ESKALATOR_KD_HASIL'];

                // LAPANGAN TENIS

                // Dengan Lampu
                
                $_POST['BKF_LT_DL_BETON_HASIL'] = $_POST['JLT_DL']['BETON'] * $JUM_LAP_BETON1;
                $_POST['BKF_LT_DL_ASPAL_HASIL'] = $_POST['JLT_DL']['ASPAL'] * $JUM_LAP_ASPAL1;
                $_POST['BKF_LT_DL_TANAH_HASIL'] = $_POST['JLT_DL']['TR'] * $JUM_LAP_RUMPUT1;
                
                $JUM3 += $_POST['BKF_LT_DL_BETON_HASIL'];
                $JUM3 += $_POST['BKF_LT_DL_ASPAL_HASIL'];
                $JUM3 += $_POST['BKF_LT_DL_TANAH_HASIL'];

                // Tanpa Lampu

                $_POST['BKF_LT_TL_BETON_HASIL'] = $_POST['JLT_TL']['BETON'] * $JUM_LAP_BETON2;
                $_POST['BKF_LT_TL_ASPAL_HASIL'] = $_POST['JLT_TL']['ASPAL'] * $JUM_LAP_ASPAL2;
                $_POST['BKF_LT_TL_TANAH_HASIL'] = $_POST['JLT_TL']['TR'] * $JUM_LAP_RUMPUT2;

                $JUM3 += $_POST['BKF_LT_TL_BETON_HASIL'];
                $JUM3 += $_POST['BKF_LT_TL_ASPAL_HASIL'];
                $JUM3 += $_POST['BKF_LT_TL_TANAH_HASIL'];

                // AC

                $_POST['BKF_AC_BNG_LAIN_HASIL'] = 0;
                $_POST['BKF_AC_KAMAR_HASIL'] = 0;
                $_POST['BKF_AC_RUANGAN_LAIN_HASIL'] = 0;

                if($_POST['KD_JPB'] == "02"){
                    $_POST['BKF_AC_BNG_LAIN_HASIL'] = 0 * $Nil_AC_Central[1];
                    $JUM3 += $_POST['BKF_AC_BNG_LAIN_HASIL'];
                }else if($_POST['KD_JPB'] == "04"){
                    $JUM3 += $_POST['BKF_AC_BNG_LAIN_HASIL'] = 0 * $Nil_AC_Central[4];
                }else if($_POST['KD_JPB'] == "05"){
                    $_POST['BKF_AC_KAMAR_HASIL'] = 0 * $Nil_AC_Central[5];
                    $_POST['BKF_AC_RUANGAN_LAIN_HASIL'] = 0 * $Nil_AC_Central[6];

                    $JUM3 += $_POST['BKF_AC_KAMAR_HASIL'];
                    $JUM3 += $_POST['BKF_AC_RUANGAN_LAIN_HASIL'];
                }else if($_POST['KD_JPB'] == "07"){
                    $_POST['BKF_AC_KAMAR_HASIL'] = 0 * $Nil_AC_Central[2];
                    $_POST['BKF_AC_RUANGAN_LAIN_HASIL'] = 0 * $Nil_AC_Central[3];

                    $JUM3 += $_POST['BKF_AC_KAMAR_HASIL'];
                    $JUM3 += $_POST['BKF_AC_RUANGAN_LAIN_HASIL'];
                }else if($_POST['KD_JPB'] == "13"){
                    $_POST['BKF_AC_KAMAR_HASIL'] = 0 * $Nil_AC_Central[7];
                    $_POST['BKF_AC_RUANGAN_LAIN_HASIL'] = 0 * $Nil_AC_Central[8];

                    $JUM3 += $_POST['BKF_AC_KAMAR_HASIL'];
                    $JUM3 += $_POST['BKF_AC_RUANGAN_LAIN_HASIL'];
                }else{

                    if($_POST['L_AC']['AC_CENTRAL'] == "01"){
                        $_POST['BKF_AC_BNG_LAIN_HASIL'] = $_POST['LUAS_BNG'] * $JUM_AC_CENTRAL;
                        $JUM3 += $_POST['BKF_AC_BNG_LAIN_HASIL'];
                    }
                }
                
                if($_POST['KD_JPB'] == "07"){
                $_POST['BKF_AC_BOILER_HASIL'] = 0 * $Nil_Boiler_Ht;
                }else if($_POST['KD_JPB'] == "13"){
                   $_POST['BKF_AC_BOILER_HASIL'] = 0 * $Nil_Boiler_Ap;
                }else{
                    $_POST['BKF_AC_BOILER_HASIL'] = 0 * 0;
                }

                $JUM3 += $_POST['BKF_AC_BOILER_HASIL'];

                $_POST['JUM3'] = $JUM3;

                $_POST['JUM4'] = $xSUSUT * ($_POST['JUM1']+$_POST['JUM2']+$_POST['JUM3']);

                $JUM5 = 0;

                $_POST['BKF_TD_DL_HASIL'] = $_POST['L_AC']['DAYA_LISTRIK'] * $DAYA_LISTRIK;
                $_POST['BKF_TD_JAS_HASIL'] = $_POST['L_AC']['AC_SPLIT'] * $JUM_SPLIT;
                $_POST['BKF_TD_JAW_HASIL'] = $_POST['L_AC']['AC_WINDOW'] * $JUM_WINDOW;

                $JUM5 += $_POST['BKF_TD_DL_HASIL'];
                $JUM5 += $_POST['BKF_TD_JAS_HASIL'];
                $JUM5 += $_POST['BKF_TD_JAW_HASIL'];

                $_POST['JUM5'] = $JUM5;

                $_POST['tTotal1'] = ($_POST['JUM1'] + $_POST['JUM2'] + $_POST['JUM3'] + $_POST['JUM5']) - $_POST['JUM4'];

                $reg_code = str_replace('REG-','',$_POST['reg_code']);

                $_POST["TGL_PENDATAAN_BNG"] = date('Y-m-d',$reg_code);
                $_POST["TGL_PEMERIKSAAN_BNG"] = date('Y-m-d H:i:s');
                $_POST["TGL_PEREKAM_BNG"] = date('Y-m-d',$reg_code);

                $NIP_PENDATA_BNG = '0';
                $NIP_PEMERIKSA_BNG = '0';
                $NIP_PEREKAM_BNG = '0';

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

                if($insert)
                {
                    CALL_FASILITAS();
                    CALL_TAMBAHAN();
                    
                    return ['status'=>'success','data'=>$_POST];
                }

                return ['status'=>'failed','message'=>'insert fail','data'=>$_POST];
        }
        
}

function createObjekPajakBumi($data)
{
    $qb = new QueryBuilder();

    $reg_code = str_replace('REG-','',$data['reg_code']);

    $data['KD_PROPINSI'] = 12;
    $data['KD_DATI2'] = 12;
    $data['NO_BUMI'] = 1;
    $data["TGL_PENDATAAN"] = date('Y-m-d',$reg_code);
    $data["TGL_PEMERIKSAAN"] = date('Y-m-d H:i:s');
    $data["TGL_PEREKAMAN"] = date('Y-m-d',$reg_code);
    $NIP_PENDATA = '0';
    $NIP_PEMERIKSA = '0';
    $NIP_PEREKAM = '0';

    extract($data);

    $kelasTanah = $qb->select("KELAS_TANAH")->where('THN_AWAL_KLS_TANAH',$TAHUN)->first();

    $nilaiKelas = $kelasTanah && $kelasTanah['NILAI_PER_M2_TANAH'] ? $kelasTanah['NILAI_PER_M2_TANAH'] : 1;

    $tBumi3 = $LUAS_TANAH * $nilaiKelas;

    $sql =  "INSERT_BUMI '12', '12', '" . $KD_KECAMATAN . "', '" . $KD_KELURAHAN . "', '" . $KD_BLOK . "', '" . $NO_URUT . "', '" . $KODE . "', '1', '" . $KD_ZNT . "', '" . round($LUAS_TANAH) . "', '" . $JNS_BUMI . "', '" . round($tBumi3) . "','" . $NO_SPOP . "', '0'," . "'12', '12', '" . $KD_KECAMATAN . "', '" . $KD_KELURAHAN . "', '" . $KD_BLOK . "', '" . $NO_URUT . "', '" . $KODE . "', '" . $SUBJEK_PAJAK_ID . "', '" . $NO_SPOP . "', '" . $NO_PERSIL . "', '" . $JALAN . "', '" . $KD_BLOK . "', '" . $RW . "', '" . $RT . "', '" . $STATUS_WP . "', '" . $LUAS_TANAH . "', '" . $tBumi3 * 1000 . "', '1', '" . $TGL_PENDATAAN . "', '" . $NIP_PENDATA . "', '" . $TGL_PEMERIKSAAN . "', '" . $NIP_PEMERIKSA . "', '" . $TGL_PEREKAMAN . "', '" . $NIP_PEREKAM . "','0',0,0,'1'";

    $insert = $qb->rawQuery($sql)->exec();

    if($insert)
    {
        return ['status'=>'success','data'=>$data];
    }

    return ['status'=>'failed','message'=>'insert fail','data'=>$data];
}

function createSubjekPajak($data)
{
    $fields = [
        'SUBJEK_PAJAK_ID',
        'NM_WP',
        'JALAN_WP',
        'BLOK_KAV_NO_WP',
        'RW_WP',
        'RT_WP',
        'KELURAHAN_WP',
        'KOTA_WP',
        'KD_POS_WP',
        'TELP_WP',
        'NPWP',
        'STATUS_PEKERJAAN_WP',
    ];

    $create_fields = [];
    foreach($fields as $field)
    {
        $create_fields[$field] = $data[$field];
    }

    $qb = new QueryBuilder();

    $insert = $qb->create('DAT_SUBJEK_PAJAK',$create_fields)->exec();

    if( $insert === false ) {
        return ['status'=>'failed','message' => sqlsrv_errors()];
    }

    if($insert)
    {
        return ['status'=>'success','data'=>$insert];
    }

    return ['status'=>'failed','message' => 'error'];
}