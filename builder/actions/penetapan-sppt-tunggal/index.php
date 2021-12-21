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
    $StrQ1 = "Select * From QOBJEKPAJAK WHERE NOPQ =  '" . $_GET['NOP'] . "' ORDER BY nopq asc";

    $dt = $qb->rawQuery($StrQ1)->first();

    echo json_encode($dt);
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

    if(isset($_POST['NOP'])){

        function sv_SPPT(){

            global $qb,$xTT,$xTB;

            $StrQ1 = "Select * From QOBJEKPAJAK WHERE NOPQ =  '" . $_POST['NOP'] . "' ORDER BY nopq asc";

            $dt = $qb->rawQuery($StrQ1)->first();

            if(!$dt){
                $message = "Objek pajak belum dinilai...! Kemungkinan ada data tidak valid";
        
                set_flash_msg(['failed'=>$message]);
                header("location:index.php?page=builder/penetapan-sppt/index");
                return;
            }

            $xxKec = substr($_POST['NOP'], 7, 3);
            $xxKel = substr($_POST['NOP'], 11, 3);
            $xxBlok = substr($_POST['NOP'], 15, 3);
            $xxUrut = substr($_POST['NOP'], 19, 4);
            $xxJenis = $_POST['NOP'][strlen($_POST['NOP'])-1];
            $xHutang = round($_POST['TARIF'] / 100 * $_POST['NJKP']);
            $xKurang = round($_POST['FAKTOR_PENGURANG']);
            $xBayar = round($_POST['PBB'] - $xKurang);
            $xxTerbit = $_POST['TGL_TERBIT'];
            $xxJTempo = $_POST['TGL_TEMPO'];;

            $ssql = "Select * From SPPT where ('12.12.' + KD_KECAMATAN + '.' + KD_KELURAHAN + '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP)='" . $_POST["NOP"] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "'";

            $dt2 = $qb->rawQuery($ssql)->get();

            $CPP = "";

            foreach ($dt2 as $key => $value) {
                $CPP = $value['PROSES'];
            }
            
            $xSQL = "Delete From SPPT where ('12.12.' + KD_KECAMATAN + '.' + KD_KELURAHAN+ '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP)='" . $_POST['NOP'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "' AND PROSES='" . $CPP . "'";

            $qb->rawQuery($xSQL)->exec();

            $iSQL = "Select * From SPPT where ('12.12.' + KD_KECAMATAN + '.' + KD_KELURAHAN+ '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP)='" . $_POST['NOP'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "' AND PROSES='" . $CPP . "'";

            $dts = [];

            $dts['KD_PROPINSI'] = "12";
            $dts['KD_DATI2'] = "12";
            $dts['KD_KECAMATAN'] = $xxKec;
            $dts['KD_KELURAHAN'] = $xxKel;
            $dts['KD_BLOK'] = $xxBlok;
            $dts['NO_URUT'] = $xxUrut;
            $dts['KD_JNS_OP'] = $xxJenis;
            $dts['THN_PAJAK_SPPT'] = $_POST['YEAR'];
            $dts['NO_PERSIL_SPPT'] = $_POST['NO_PERSIL'];

            $dts["KD_KLS_TANAH"] = $_POST['KELAS_BUMI'];
            $dts["KD_KLS_BNG"] = $_POST['KELAS_BNG'];
            
            $dts["NJOP_BUMI_SPPT"] = $_POST['NJOP_BUMI'];
            $dts["NJOP_BNG_SPPT"] = $_POST['NJOP_BNG'];

            $dts["NJOPTKP_SPPT"] = $_POST['NJOPTKP'];
            $dts["PBB_TERUTANG1"] = $_POST['PBB'];

            $dts['THN_AWAL_KLS_TANAH'] = $xTT;

            $dts['THN_AWAL_KLS_BNG'] = $xTB;

            $dts['TGL_JATUH_TEMPO_SPPT'] = $xxJTempo;

            $dts['LUAS_BUMI_SPPT'] = $_POST['LUAS_BUMI'];
            $dts['LUAS_BNG_SPPT'] = $_POST['LUAS_BNG'];
            
            $dts['NJOP_SPPT'] = $_POST['TOTAL_NJOP'];
            $dts['NJKP_SPPT'] = $_POST['NJKP'];

            $dts['PBB_TERHUTANG_SPPT'] = $xHutang;
            $dts['FAKTOR_PENGURANG_SPPT'] = $xKurang;
            $dts['PBB_YG_HARUS_DIBAYAR_SPPT'] = $xBayar;
            $dts['STATUS_PEMBAYARAN_SPPT'] = "0";
            $dts['STATUS_TAGIHAN_SPPT'] = "0";
            $dts['STATUS_CETAK_SPPT'] = "0";
            $dts['TGL_TERBIT_SPPT'] = $xxTerbit;
            $dts['TGL_CETAK_SPPT'] = $xxTerbit;
            $dts['NIP_PENCETAK_SPPT'] = "000000";
            $dts['SIKLUS_SPPT'] = 1;
            $dts['KD_KANWIL_BANK'] = "01";
            $dts['KD_KPPBB_BANK'] = "16";
            $dts['KD_BANK_TUNGGAL'] = "04";
            $dts['KD_BANK_PERSEPSI'] = "01";

            $dts['KD_TP'] = $_POST['KD_BAYAR'];

            $dts['PROSES'] = "T";

            $qb->update("SPPT",$dts)
                ->where("'12.12.' + KD_KECAMATAN + '.' + KD_KELURAHAN+ '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP",$_POST['NOP'])
                ->where("THN_PAJAK_SPPT",$_POST['YEAR'])
                ->where("PROSES",$CPP)
                ->exec();

        }

        $data = [];

        $data["KD_KLS_TANAH"] = $_POST['KELAS_BUMI'];
        $data["KD_KLS_BNG"] = $_POST['KELAS_BNG'];
        $data["NJOP_BUMI1"] = $_POST['NJOP_BUMI'];
        $data["NJOP_BNG1"] = $_POST['NJOP_BNG'];
        $data["NJOPTKP1"] = $_POST['NJOPTKP'];
        $data["PBB_TERUTANG1"] = $_POST['PBB'];


        $qb->update("LOGUTAMA",$data)->where("NOP1",$_POST['NOP'])->exec();

        sv_SPPT();

        set_flash_msg(['success'=>'Penetapan SPPT Tunggal: Sukses!']);
        header("location:index.php?page=builder/penetapan-sppt/index");
        return;
    }

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");