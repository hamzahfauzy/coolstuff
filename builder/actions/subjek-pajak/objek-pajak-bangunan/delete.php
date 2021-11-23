<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

if(isset($_GET['NOP']) && isset($_GET['KD_JPB']))
{  

    extract($_GET);

    $xxJPB = $KD_JPB;

    $xxKec = substr($NOP,6,3);
    $xxKel = substr($NOP,10,3);
    $xxBlok = substr($NOP,14,3);
    $xxUrut = substr($NOP,18,4);
    $xxJenis = substr($NOP,23,1);

    $C_STR = "HAPUS_BANGUNAN '" . $xxKec . "','" . $xxKel . "','" . $xxBlok . "','" . $xxUrut . "','" . $xxJenis . "'," . "'" . trim($NOP) . "','" . $NO_BNG . "'," . "'" . trim($NOP) . "','" . $NO_BNG . "'," . "'" . trim($NOP) . "','" . $NO_BNG . "'," . "'" . $xxJPB . "','" . trim($NOP) . "','" . $NO_BNG . "'," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," . "'" . trim($NOP) . "','" . $NO_BNG . "' ," .     "'" . trim($NOP) . "','" . $NO_BNG . "' ," .     "'" . trim($NOP) . "','" . $NO_BNG . "'";

    $delete = $qb->rawQuery($C_STR)->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
        return;
    }
}