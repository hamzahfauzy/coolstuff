<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_OP_BUMI","NO_URUT,KD_JNS_OP,LUAS_BUMI,NILAI_SISTEM_BUMI,NO_FORMULIR,STATUS_JADI");

$kecamatans = $qb->select('REF_KECAMATAN')->get();

$subjekPajak = $qb->select("DAT_SUBJEK_PAJAK")->where('SUBJEK_PAJAK_ID',$_GET['id'])->first();

$old = get_flash_msg("old");

if($old){
    $opBumi = $qb->select("DAT_OP_BUMI")->where("SUBJEK_PAJAK_ID",$_GET['id'])->first();
    
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->get();
    $bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->get();
    $znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->where('KD_BLOK',$opBumi['KD_BLOK'])->get();
}


$jenisBumis = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];


$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;
    $_POST['NO_BUMI'] = 1;
    $_POST['SUBJEK_PAJAK_ID'] = $_GET['id'];

    // $insert = $qb->create('DAT_OP_BUMI',$_POST)->exec();

    if(isset($_POST["TGL_PENDATAAN"])){
        $result = $_POST["TGL_PENDATAAN"]." 00:00:00";
        $_POST["TGL_PENDATAAN"] = $result;
    }

    if(isset($_POST["TGL_PEMERIKSAAN"])){
        $result = $_POST["TGL_PEMERIKSAAN"]." 00:00:00";
        $_POST["TGL_PEMERIKSAAN"] = $result;
    }

    if(isset($_POST["TGL_PEREKAMAN"])){
        $result = $_POST["TGL_PEREKAMAN"]." 00:00:00";
        $_POST["TGL_PEREKAMAN"] = $result;
    }

    extract($_POST);

    $kelasTanah = $qb->select("KELAS_TANAH")->where('THN_AWAL_KLS_TANAH',$TAHUN)->first();

    $nilaiKelas = $kelasTanah && $kelasTanah['NILAI_PER_M2_TANAH'] ? $kelasTanah['NILAI_PER_M2_TANAH'] : 1;

    $tBumi3 = $LUAS_TANAH * $nilaiKelas;

    $sql =  "INSERT_BUMI '12', '12', '" . $KD_KECAMATAN . "', '" . $KD_KELURAHAN . "', '" . $KD_BLOK . "', '" . $NO_URUT . "', '" . $KODE . "', '1', '" . $KD_ZNT . "', '" . round($LUAS_TANAH) . "', '" . $JNS_BUMI . "', '" . round($tBumi3) . "','" . $NO_SPOP . "', '0'," . "'12', '12', '" . $KD_KECAMATAN . "', '" . $KD_KELURAHAN . "', '" . $KD_BLOK . "', '" . $NO_URUT . "', '" . $KODE . "', '" . $SUBJEK_PAJAK_ID . "', '" . $NO_SPOP . "', '" . $NO_PERSIL . "', '" . $JALAN . "', '" . $KD_BLOK . "', '" . $RW . "', '" . $RT . "', '" . $STATUS_WP . "', '" . $LUAS_TANAH . "', '" . $tBumi3 * 1000 . "', '1', '" . $TGL_PENDATAAN . "', '" . $NIP_PENDATA . "', '" . $TGL_PEMERIKSAAN . "', '" . $NIP_PEMERIKSA . "', '" . $TGL_PEREKAMAN . "', '" . $NIP_PEREKAM . "','0',0,0,'1'";

    $insert = $qb->rawQuery($sql)->exec();

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
        return;
    }else{
        set_flash_msg(["old"=>$_POST]);

        header('location:index.php?page=builder/subjek-pajak/objek-pajak-bumi/create&id='.$_GET['id']);
        return;
    }
}