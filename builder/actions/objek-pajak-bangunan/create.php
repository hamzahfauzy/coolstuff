<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_OP_BUMI","NO_URUT,KD_JNS_OP,LUAS_BUMI,JNS_BUMI,NILAI_SISTEM_BUMI,NO_FORMULIR,STATUS_JADI");

$kecamatans = $qb->select('REF_KECAMATAN')->get();
$sps = $qb->select("DAT_SUBJEK_PAJAK","SUBJEK_PAJAK_ID, NM_WP")->orderBy('SUBJEK_PAJAK_ID')->get();

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;
    $_POST['NO_BUMI'] = 1;

    $insert = $qb->create('DAT_OP_BUMI',$_POST)->exec();

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/objek-pajak-bumi/index');
        return;
    }
}