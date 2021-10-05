<?php
require '../config/main.php';
require '../helpers/Builder.php';
require '../helpers/Form.php';

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