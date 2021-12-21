<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');

global $qb;

$qb = new QueryBuilder();
$vOP = [];
$cMin = [];
$cMax = [];
$cTKP = [];
$xTarif = [];
$cTarif = 0;
$NMIN = 0;

if(isset($_GET['check'])){
    $sql = "Select * FROM DAT_SUBJEK_PAJAK_NJOPTKP WHERE THN_NJOPTKP='" . trim($_GET['year']) . "'";

    $pbb = $qb->rawQuery($sql)->first();

    echo $pbb ? 1 : 0;
    die;
}

if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->orderby('KD_KELURAHAN')->get();

    echo json_encode($kelurahans);
    die;
}

$tBayars = $qb->select("TEMPAT_BAYAR")->orderBy('KD_TP')->get();
$kecamatans = $qb->select("REF_KECAMATAN")->orderby('KD_KECAMATAN')->get();

if(request() == 'POST'){
    
    $xTTs = $qb->select("KELAS_TANAH")->orderBy('THN_AWAL_KLS_TANAH','DESC')->first();
    $xTBs = $qb->select("KELAS_BANGUNAN")->orderBy('THN_AWAL_KLS_BNG','DESC')->first();
    
    global $xTT,$xTB;

    $xTT = $xTTs['THN_AWAL_KLS_TANAH'];
    $xTB = $xTBs['THN_AWAL_KLS_BNG'];
    
    if(isset($_POST['KD_KELURAHAN']) && $_POST['KD_KELURAHAN']){
        $sql = "Select * From SPPT where (KD_KECAMATAN='" . trim($_POST['KD_KECAMATAN']) . "' AND KD_KELURAHAN='" . trim($_POST['KD_KELURAHAN']) . "') and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "' ";
    }else{
        $sql = "Select * From SPPT where (KD_KECAMATAN='" . trim($_POST['KD_KECAMATAN']) . "') and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "' ";
    }

    // $Pesan1 = "KEC: " . $_POST['KD_KECAMATAN'] . ", KEL: " . $_POST['KD_KELURAHAN'] . ", sudah ditetapkan Anda ingin membuat ulang?";

    $data = $qb->rawQuery($sql)->first();

    if(!$data){
        $message = "Objek pajak belum dinilai...! Kemungkinan ada data tidak valid";

        set_flash_msg(['failed'=>$message]);
        header("location:index.php?page=builder/penetapan-sppt/index");
        return;
    }

    $C_STR = "iSPPT_MASSAL '" . $_POST['KD_KECAMATAN'] . "','" . $_POST['KD_KELURAHAN'] . "','" . $_POST['YEAR'] . "','" . $xTT . "','" . $xTB . "','" . $_POST['TGL_TEMPO'] . "', '" . $_POST['PENGURANG'] . "'," . "'0', '0', '0','" . $_POST['TGL_TERBIT'] . "','" . $_POST['TGL_TERBIT'] . "', '000000',1, '01', '16', '04', '01','" . $_POST['KD_BAYAR'] . "', 'M','3'";

    $qb->rawQuery($C_STR)->exec();

    $strLOG = "iLOG '" . $_POST['YEAR'] . "'";

    $qb->rawQuery($strLOG)->exec();
    
    set_flash_msg(['success'=>'Penetapan SPPT Massal: Sukses!']);
    header("location:index.php?page=builder/penetapan-sppt/index");
    return;
}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");