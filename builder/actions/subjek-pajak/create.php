<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_SUBJEK_PAJAK","SUBJEK_PAJAK_ID,NM_WP,JALAN_WP,RW_WP,RT_WP,KOTA_WP,KD_POS_WP,TELP_WP,NPWP,STATUS_PEKERJAAN_WP");

$kelurahans = $qb->select('REF_KELURAHAN')->get();

if(request() == 'POST')
{   
    // $_POST['KD_PROPINSI'] = 12;
    // $_POST['KD_DATI2'] = 12;

    $kels = explode("-",$_POST['KELURAHAN_WP']);

    $_POST['KELURAHAN_WP'] = trim($kels[1]);

    $insert = $qb->create('DAT_SUBJEK_PAJAK',$_POST)->exec();

    if( $insert === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/subjek-pajak/index');
        return;
    }
}