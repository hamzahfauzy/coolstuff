<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$opBumi = $qb->select("DAT_OP_BUMI")->where("SUBJEK_PAJAK_ID",$_GET['id'])->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_BLOK',$_GET['blok'])->where('KD_ZNT',$_GET['znt'])->first();

if(isset($_GET['kecamatan']) && isset($_GET['kelurahan']) && isset($_GET['blok']) && isset($_GET['znt']) && isset($_GET['id']))
{  

    $delete = $qb->delete('DAT_OP_BUMI')->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_BLOK',$_GET['blok'])->where('KD_ZNT',$_GET['znt'])->where("SUBJEK_PAJAK_ID",$_GET['id'])->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
        return;
    }
}