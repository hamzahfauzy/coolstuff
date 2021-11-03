<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

if(isset($_GET['filter-blok']) && isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->where('KD_BLOK',$_GET['filter-blok'])->get();

    echo json_encode($znts);
    die;
}

if(isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->get();

    echo json_encode($bloks);
    die;
}

if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->get();

    echo json_encode($kelurahans);
    die;
}

$data = $qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$_GET['id'])->first();

$opBumi = $qb->select("DAT_OP_BUMI")->where("SUBJEK_PAJAK_ID",$_GET['id'])->first();

if($opBumi){
    
    $fields = $qb->columns("DAT_OP_BUMI","NO_URUT,KD_JNS_OP,LUAS_BUMI,JNS_BUMI,NILAI_SISTEM_BUMI,NO_FORMULIR,STATUS_JADI");
    
    $kecamatans = $qb->select('REF_KECAMATAN')->get();
    
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->get();
    $bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->get();
    $znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->where('KD_BLOK',$opBumi['KD_BLOK'])->get();
    
    if(request() == 'POST')
    {   
        $_POST['KD_PROPINSI'] = 12;
        $_POST['KD_DATI2'] = 12;
        $_POST['NO_BUMI'] = 1;
    
        $insert = $qb->create('DAT_OP_BUMI',$_POST)->where("SUBJEK_PAJAK_ID",$_GET['id'])->exec();
    
        if($insert)
        {
            set_flash_msg(['success'=>'Data Saved']);
            header('location:index.php?page=builder/objek-pajak-bumi/index');
            return;
        }
    }

}