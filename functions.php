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