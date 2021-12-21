<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$clauseBumi = "DAT_OP_BUMI.KD_PROPINSI + '.' + DAT_OP_BUMI.KD_DATI2 + '.' + DAT_OP_BUMI.KD_KECAMATAN + '.' + DAT_OP_BUMI.KD_KELURAHAN + '.' + DAT_OP_BUMI.KD_BLOK + '-' + DAT_OP_BUMI.NO_URUT + '.' + DAT_OP_BUMI.KD_JNS_OP";

$fields = $qb->columns("DAT_OP_BUMI","NO_URUT,KD_JNS_OP,LUAS_BUMI,NILAI_SISTEM_BUMI,NO_FORMULIR,STATUS_JADI");

$kecamatans = $qb->select('REF_KECAMATAN')->orderby('KD_KECAMATAN')->get();

$subjekPajak = $qb->select("DAT_SUBJEK_PAJAK")->where('SUBJEK_PAJAK_ID',$_GET['id'])->first();

$opBumi = $qb->select("DAT_OP_BUMI")->where($clauseBumi,$_GET['NOP'])->first();

$datOP = $qb->select("DAT_OBJEK_PAJAK")->where("SUBJEK_PAJAK_ID",$_GET['id'])->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->where('KD_BLOK',$opBumi['KD_BLOK'])->first();

$old = get_flash_msg("old");

if($old){

    $timePendataan = strtotime($old['TGL_PENDATAAN']);
    $pendataan = date('Y-m-d',$timePendataan);
    $old['TGL_PENDATAAN'] = $pendataan;

    $timePemeriksaan = strtotime($old['TGL_PEMERIKSAAN']);
    $pemeriksaan = date('Y-m-d',$timePemeriksaan);
    $old['TGL_PEMERIKSAAN'] = $pemeriksaan;

    $timePerekaman = strtotime($old['TGL_PEREKAMAN']);
    $perekaman = date('Y-m-d',$timePerekaman);
    $old['TGL_PEREKAMAN'] = $perekaman;

}
    
$kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->orderby('KD_KELURAHAN')->get();
$bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->orderby('KD_BLOK')->get();
$znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->where('KD_BLOK',$opBumi['KD_BLOK'])->orderby('KD_ZNT')->get();
$jalans = $qb->select("JALAN")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->orderby('KD_ZNT')->get();

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

    $NOP = $_GET['NOP']; // "12.12.$opBumi[KD_KECAMATAN].$opBumi[KD_KELURAHAN].$opBumi[KD_BLOK]-$opBumi[NO_URUT].$opBumi[KD_JNS_OP]";

    $tBumi3 = $LUAS_TANAH * $nilaiKelas;

    $sql = "UPDATE_BUMI '12', '12', '" . $KD_KECAMATAN . "', '" . $KD_KELURAHAN . "', '" . $KD_BLOK . "', '" . $NO_URUT . "', '" . $KODE . "', '1', '" . $KD_ZNT . "', '" . round($LUAS_TANAH) . "', '" . $JNS_BUMI . "', '" . round($tBumi3) . "','" . $NO_SPOP . "', '0','" . $NOP . "'," . "'12', '12', '" . $KD_KECAMATAN . "', '" . $KD_KELURAHAN . "', '" . $KD_BLOK . "', '" . $NO_URUT . "', '" . $KODE . "', '" . $SUBJEK_PAJAK_ID . "', '" . $NO_SPOP . "', '" . $NO_PERSIL . "', '" . $JALAN . "', '" . $KD_BLOK . "', '" . $RW . "', '" . $RT . "', '" . $STATUS_WP * 1 . "', '" . $LUAS_TANAH . "', '" . $tBumi3 * 1000 . "', '1', '" . $TGL_PENDATAAN . "', '" . $NIP_PENDATA . "', '" . $TGL_PEMERIKSAAN . "', '" . $NIP_PEMERIKSA . "', '" . $TGL_PEREKAMAN . "', '" . $NIP_PEREKAM . "','0',0,0,'1','" . $NOP . "'";

    $update = $qb->rawQuery($sql)->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
        return;
    }else{
        set_flash_msg(["old"=>$_POST]);

        header('location:index.php?page=builder/subjek-pajak/objek-pajak-bumi/edit&id='.$_GET['id']."&kecamatan=$_GET[kecamatan]&kelurahan=$_GET[kelurahan]&blok=$_GET[blok]&znt=$_GET[znt]");
        return;
    }
}