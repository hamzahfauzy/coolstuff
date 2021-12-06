<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();


if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->orderby('KD_KELURAHAN')->get();

    foreach ($kelurahans as $key => $value) {
        $T_SQL = "select * from SPPT WHERE KD_KECAMATAN='" . $_GET['filter-kecamatan'] . "' AND KD_KELURAHAN='" . $value['KD_KELURAHAN'] . "' and THN_PAJAK_SPPT='" . $_GET['YEAR'] . "'";

        $sppt = $qb->rawQuery($T_SQL)->first();

        $kelurahans[$key]['sppt'] = $sppt ? 1 : 0;
    }

    echo json_encode($kelurahans);
    die;
}

if(isset($_GET['sppt']) && isset($_GET['KD_KECAMATAN']) && isset($_GET['KD_KELURAHAN']) && isset($_GET['YEAR'])){
    $T_SQL = "select * from SPPT WHERE KD_KECAMATAN='" . $_GET['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_GET['KD_KELURAHAN'] . "' and THN_PAJAK_SPPT='" . $_GET['YEAR'] . "'";

    $sppt = $qb->rawQuery($T_SQL)->first();

    echo json_encode(["result"=>$sppt ? true : false]);

    die;
}

if(request() == 'POST' && $_POST['KD_KECAMATAN'] && $_POST['KD_KELURAHAN'] && $_POST['YEAR']){

    $T_SQL = "select * from SPPT WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "'";

    $sppt = $qb->rawQuery($T_SQL)->first();

    if($sppt){

        $sppt_del = "DELETE FROM SPPT WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KECAMATAN'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR']. "'";
        
        $pembayaran_del = "DELETE FROM PEMBAYARAN_SPPT WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KECAMATAN'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "'";

        $qb->rawQuery($sppt_del)->exec();
        $qb->rawQuery($pembayaran_del)->exec();
    }

    require '../builder/actions/penilaian-massal/functions.php';
    
    nilai_bumi();
    nilai_bangunan();
    nilai_fasilitas();
    dbkb_fas1a();
    dbkb_fas3a();
    dbkb_fas2a();
    NFAS();
    nilai_individu();
    TIDAK_KENA_PAJAK();
    call_op();
    sv_bumi();
    sv_bangunan();
    sv_individu();
    sv_objek();

    set_flash_msg(['success'=>'Data Saved']);
    header("location:index.php?page=builder/penilaian-massal/index");
    return;
}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");

$kecamatans = $qb->select("REF_KECAMATAN")->orderby('KD_KECAMATAN')->get();