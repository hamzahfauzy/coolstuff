<?php

require '../helpers/QueryBuilder.php';

$qb    = new QueryBuilder();

$msg   = get_flash_msg('success');

$datas = [];
$fields = [];

if(isset($_GET['tampilkan']))
{   
    $fields = require 'fields/'.$_GET['jpb'].'.php';
    $tahun  = $_GET['tahun'];
    $datas = $qb->select($fields['table'])->where($fields['clause'],$tahun)->orderby($fields['order'])->get();
    // if(empty($datas))
    // {
    //     $tahun  = $_GET['tahun'] - 1;
    //     $datas = $qb->select($fields['table'])->where($fields['clause'],$tahun)->orderby($fields['order'])->get();
    // }
    if(request() == 'POST')
    {
        $column = array_key_last($fields['columns']);
        foreach($datas as $key => $data)
        {
            $clause = $data;
            unset($clause[$column]);
            $data[$column] = $_POST['NILAI_BARU'][$key];
            $qb->update($fields['table'],$data); //->where()->exec();
            foreach($clause as $f => $val)
            {
                $qb->where($f, $val);
            }
            $qb->exec();
        }
    
        set_flash_msg(['success'=>'Success']);
        header('location:index.php?page=builder/dbkb-non-standar/index&tahun='.$tahun.'&jpb='.$_GET['jpb'].'&tampilkan=');
        return;
    }
}


$jpbs = $qb->select("REF_JPB")->where("KD_JPB",'01','<>')->where('KD_JPB','10', '<>')->where('KD_JPB','11','<>')->orderby('KD_JPB')->get();