<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
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

    $xSQL = "DELETE From SPPT where KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "' ";
    $qb->rawQuery($xSQL)->exec();

    call_data();
    sv_SPPT();

    // $C_STR = "iSPPT_MASSAL '" . $_POST['KD_KECAMATAN'] . "','" . $_POST['KD_KELURAHAN'] . "','" . $_POST['YEAR'] . "','" . $xTT . "','" . $xTB . "','" . $_POST['TGL_TEMPO'] . "', '" . $_POST['PENGURANG'] . "'," . "'0', '0', '0','" . $_POST['TGL_TERBIT'] . "','" . $_POST['TGL_TERBIT'] . "', '000000',1, '01', '16', '04', '01','" . $_POST['KD_BAYAR'] . "', 'M','3'";

    // $qb->rawQuery($C_STR)->exec();

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

function call_data()
{
    global $vOP,$xTT,$xTB,$cMin,$cMax,$cTarif,$cTKP,$NMIN,$xTarif;
    $qb = qb();
    $JTotal = null;

    $StrQ1 = "Select * From QOBJEKPAJAK WHERE KD_KECAMATAN=  '" .$_POST['KD_KECAMATAN']. "' AND KD_KELURAHAN=  '" .$_POST['KD_KELURAHAN']. "'ORDER BY NOPQ asc";
    $qObjPajak = $qb->rawQuery($StrQ1)->get();
    $i = 0;
    foreach($qObjPajak as $obPajak)
    {
        $i = $i + 1;
        $xNOP = $obPajak['KD_PROPINSI'] . "." . $obPajak['KD_DATI2'] . "." . $obPajak['KD_KECAMATAN'] . "." . $obPajak['KD_KELURAHAN'] . "." . $obPajak['KD_BLOK'] . "-" . $obPajak['NO_URUT'] . "." . $obPajak['KD_JNS_OP'];
        $vOP[$i][0] = "";
        $vOP[$i][1] = $i;
        $vOP[$i][2] = $obPajak['KD_PROPINSI'];
        $vOP[$i][3] = $obPajak['KD_DATI2'];
        $vOP[$i][4] = $obPajak['KD_KECAMATAN'];
        $vOP[$i][5] = $obPajak['KD_KELURAHAN'];
        $vOP[$i][6] = $obPajak['KD_BLOK'];
        $vOP[$i][7] = $obPajak['NO_URUT'];
        $vOP[$i][8] = $obPajak['KD_JNS_OP'];
        $vOP[$i][9] = $_POST['YEAR'];
        $vOP[$i][10] = 1;
        $vOP[$i][11] = "01";
        $vOP[$i][12] = "16";
        $vOP[$i][13] = "04";
        $vOP[$i][14] = "01";
        $vOP[$i][15] = $_POST['KD_BAYAR'];
        $vOP[$i][16] = $obPajak['NM_WP'];
        $vOP[$i][17] = $obPajak['JALAN_WP'];
        if(empty($obPajak['BLOK_KAV_NO_WP'])) $obPajak['BLOK_KAV_NO_WP'] = "00";
        $vOP[$i][18] = $obPajak['BLOK_KAV_NO_WP'];
        if(empty($obPajak['RW_WP'])) $obPajak['RW_WP'] = "00";
        $vOP[$i][19] = $obPajak['RW_WP'];
        if(empty($obPajak['RT_WP'])) $obPajak['RT_WP'] = "00";
        $vOP[$i][20] = $obPajak['RT_WP'];
        if(empty($obPajak['KELURAHAN_WP'])) $obPajak['KELURAHAN_WP'] = "-";
        $vOP[$i][21] = $obPajak['KELURAHAN_WP'];
        if(empty($obPajak['KOTA_WP'])) $obPajak['KOTA_WP'] = "-";
        $vOP[$i][22] = $obPajak['KOTA_WP'];
        if(empty($obPajak['KD_POS_WP'])) $obPajak['KD_POS_WP'] = "00000";
        $vOP[$i][23] = $obPajak['KD_POS_WP'];
        if(empty($obPajak['NPWP'])) $obPajak['NPWP'] = "-";
        $vOP[$i][24] = $obPajak['NPWP'];
       
        if(empty($obPajak['NO_PERSIL'])) $obPajak['NO_PERSIL'] = "00";
        $vOP[$i][25] = $obPajak['NO_PERSIL'];
        $vOP[$i][26] = "00";
        $vOP[$i][27] = $xTT;
        $vOP[$i][28] = "00";
        $vOP[$i][29] = $xTB;
        $vOP[$i][30] = $_POST['TGL_TEMPO'];
        $vOP[$i][31] = $obPajak['TOTAL_LUAS_BUMI'];
        $vOP[$i][32] = $obPajak['TOTAL_LUAS_BNG'];
        $vOP[$i][33] = $obPajak['NJOP_BUMI'];
        $vOP[$i][34] = $obPajak['NJOP_BNG'];
        $vOP[$i][35] = ($obPajak['NJOP_BUMI'] * 1) + ($obPajak['NJOP_BNG'] * 1);
        $vOP[$i][36] = 0;
        $vOP[$i][37] = 0;
        $vOP[$i][38] = 0;
        $vOP[$i][39] = $_POST['PENGURANG'];
        $vOP[$i][40] = 0;
        $vOP[$i][41] = 0;
        $vOP[$i][42] = 0;
        $vOP[$i][43] = 0;
        $vOP[$i][44] = $_POST['TGL_TERBIT'];
        $vOP[$i][45] = "01/01/1900";
        $vOP[$i][46] = "0000000000";
        $vOP[$i][47] = "M";
        $vOP[$i][48] = 0;
        $vOP[$i][49] = $xNOP;
        $vOP[$i][50] = $obPajak['JNS_BUMI'];
    }
    K_BUMI();
    K_BANGUNAN();
    CEK_NJOPTKP();
    
    foreach($vOP as $key => $value)
    {
        CALL_NJOPTKP();
        if($value[35] * 1 >= $cMin[1] && $value[35] * 1 <= $cMax[1])
        {
            $vOP[$key][36] = $cTKP[1];
            $cTarif = $xTarif[1];
        }
        else
        {
            $vOP[$key][36] = $cTKP[2];
            $cTarif = $xTarif[2];
        }
        if($value[48] == 0) $vOP[$key][36] = 0;
        $vOP[$key][37] = ($vOP[$key][35] * 1) - ($vOP[$key][36] * 1);
        if($vOP[$key][37] * 1 < 0 ) $vOP[$key][37] = 0;
        $vOP[$key][38] = ($vOP[$key][37] * $cTarif * 1 / 100);
        $vOP[$key][40] = ($vOP[$key][38] * 1) - ($_POST['PENGURANG'] * 1);
    
        Call_MIN();
        
        if(($vOP[$key][40] * 1) < ($NMIN * 1)):
            $vOP[$key][40] = $NMIN;
        endif;
        $JTotal = $JTotal + ($vOP[$key][40] * 1);
    }
}

function K_BUMI()
{
    global $vOP,$xTT,$xTB;
    $qb = qb();
    $L_BUMI = null;
    $xxSTR = "select * from Kelas_TANAH WHERE THN_AWAL_KLS_TANAH='" .$xTT. "'";
    $datas = $qb->rawQuery($xxSTR)->get();
    
    $J = 0;
    foreach($datas as $data)
    {
        $J = $J + 1;
        
        foreach($vOP as $i => $_vOP)
        {
            $L_BUMI = $vOP[$i][31] * 1;
            if($L_BUMI <= 0) $L_BUMI = 1;
            if(($vOP[$i][33] * 1 / $L_BUMI) == ($data['NILAI_PER_M2_TANAH'] * 1000))
            {
                $vOP[$i][26] = $data['KD_KLS_TANAH'];
            }
        }
    }
}

function K_BANGUNAN()
{
    global $vOP,$xTT,$xTB;
    $qb = qb();
    $L_BNG = null;
    $xxSTR = "select * from Kelas_BANGUNAN WHERE THN_AWAL_KLS_BNG='" . $xTB . "'";
    $datas = $qb->rawQuery($xxSTR)->get();
    $J = 0;
    foreach($datas as $data)
    {
        $J = $J + 1;
        foreach($vOP as $i => $value)
        {
            $L_BNG = $vOP[$i][32] * 1;
            if($L_BNG <= 0) $L_BNG = 1;
            if(($vOP[$i][34] * 1 / $L_BNG * 1) == ($data['NILAI_PER_M2_BNG'] * 1000))
                $vOP[$i][28] = $data['KD_KLS_BNG'];
        }
    }
}

function CEK_NJOPTKP()
{
    global $vOP;
    $qb = qb();
    $n_STR = "select * from DAT_SUBJEK_PAJAK_NJOPTKP where KD_KECAMATAN='" .$_POST['KD_KECAMATAN']. "' AND KD_KELURAHAN='" .$_POST['KD_KELURAHAN']. "' ORDER BY SUBJEK_PAJAK_ID ASC";

    $datas = $qb->rawQuery($n_STR)->get();
    $J = 0;
    foreach($datas as $i => $data)
    {
        foreach($vOP as $key => $value):
            If ($data['KD_KECAMATAN'] == $value[4] && $data['KD_KELURAHAN'] == $value[5] && $data['KD_BLOK'] == $value[6] && $data['NO_URUT'] == $value[7] && $data['KD_JNS_OP'] = $value[8]):
                $vPO[$Key][48] = 1;
            endif;
        endforeach;
    }
}

function CALL_NJOPTKP()
{
    global $cMin,$cMax,$cTKP,$xTarif;
    $qb = qb();
    $xxSTR = "Select * From Tarif order by NJOP_MIN";
    $datas = $qb->rawQuery($xxSTR)->get();
    foreach($datas as $i => $data)
    {
        $i = $i+1;
        $cMin[$i] = $data['NJOP_MIN'];
        $cMax[$i] = $data['NJOP_MAX'];
        $cTKP[$i] = $data['NJOPTKP'];
        $xTarif[$i] = $data['NILAI_TARIF'];
    }
}

function Call_MIN()
{
    global $NMIN;
    $qb = qb();
    $xxSTR = "Select * From  PBB_MINIMAL WHERE THN_PBB_MINIMAL ='" . $_POST['YEAR'] . "'order by THN_PBB_MINIMAL DESC ";
    $datas = $qb->rawQuery($xxSTR)->get();
    foreach($datas as $data)
    {
        $NMIN = $data['NILAI_PBB_MINIMAL'];
    }
}

function sv_SPPT()
{
    global $vOP;
    $qb = qb();
        
    foreach($vOP as $key => $value)
    {
        if($value[50] != 4)
        {
            $newdata= [];
            $new_data['KD_PROPINSI'] = $value[2];
            $new_data['KD_DATI2'] = $value[3];
            $new_data['KD_KECAMATAN'] = $value[4];
            $new_data['KD_KELURAHAN'] = $value[5];
            $new_data['KD_BLOK'] = $value[6];
            $new_data['NO_URUT'] = $value[7];
            $new_data['KD_JNS_OP'] = $value[8];
            $new_data['THN_PAJAK_SPPT'] = $_POST['YEAR'];
            $new_data['NM_WP_SPPT'] = $value[16];
            $new_data['JLN_WP_SPPT'] = $value[17];
            $new_data['BLOK_KAV_NO_WP_SPPT'] = $value[18];
            $new_data['RW_WP_SPPT'] = $value[19];
            $new_data['RT_WP_SPPT'] = $value[20];
            $new_data['KELURAHAN_WP_SPPT'] = $value[21];
            $new_data['KOTA_WP_SPPT'] = $value[22];
            $new_data['KD_POS_WP_SPPT'] = $value[23];
            $new_data['NPWP_SPPT'] = $value[24];
            $new_data['NO_PERSIL_SPPT'] = $value[25];
            $new_data['KD_KLS_TANAH'] = $value[26];
            $new_data['THN_AWAL_KLS_TANAH'] = $value[27];
            $new_data['KD_KLS_BNG'] = $value[28];
            $new_data['THN_AWAL_KLS_BNG'] = $value[29];
            $new_data['TGL_JATUH_TEMPO_SPPT'] = $value[30];
            $new_data['LUAS_BUMI_SPPT'] = $value[31];
            $new_data['LUAS_BNG_SPPT'] = $value[32];
            $new_data['NJOP_BUMI_SPPT'] = $value[33];
            $new_data['NJOP_BNG_SPPT'] = $value[34];
            $new_data['NJOP_SPPT'] = $value[35];
            $new_data['NJOPTKP_SPPT'] = $value[36];
            $new_data['NJKP_SPPT'] = $value[37];
            $new_data['PBB_TERHUTANG_SPPT'] = $value[38];
            $new_data['FAKTOR_PENGURANG_SPPT'] = $value[39];
            $new_data['PBB_YG_HARUS_DIBAYAR_SPPT'] = $value[40];
            $new_data['STATUS_PEMBAYARAN_SPPT'] = $value[41];
            $new_data['STATUS_TAGIHAN_SPPT'] = $value[42];
            $new_data['STATUS_CETAK_SPPT'] = $value[43];
            $new_data['TGL_TERBIT_SPPT'] = $value[44];
            $new_data['TGL_CETAK_SPPT'] = $value[45];
            $new_data['NIP_PENCETAK_SPPT'] = $value[46];
            $new_data['SIKLUS_SPPT'] = $value[10];
            $new_data['KD_KANWIL_BANK'] = $value[11];
            $new_data['KD_KPPBB_BANK'] = $value[12];
            $new_data['KD_BANK_TUNGGAL'] = $value[13];
            $new_data['KD_BANK_PERSEPSI'] = $value[14];
            $new_data['KD_TP'] = $_POST['KD_BAYAR'];
            $new_data['PROSES'] = "M";
            $qb->create('SPPT',$new_data)->exec();
        }
    }
}

function qb(){
    return new QueryBuilder();
}