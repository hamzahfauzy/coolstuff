<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();


if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->get();

    echo json_encode($kelurahans);
    die;
}

if(request() == 'POST'){

    function qb(){
        return new QueryBuilder();
    }
    
    $vBangunan = [];
    $vBng = [];
    $vFAS = [];
    $vOP = [];

    $xTB;
    $xTT;

    $tb = "SELECT THN_AWAL_KLS_BNG FROM KELAS_BANGUNAN order by THN_AWAL_KLS_BNG desc";
    $kl = "SELECT THN_AWAL_KLS_TANAH FROM KELAS_TANAH order by THN_AWAL_KLS_TANAH desc";

    $pbb_min = "Select * From PBB_MINIMAL Where THN_PBB_MINIMAL >='" . $_POST['YEAR'] . "'";

    $PMin = $qb->rawQuery($pbb_min)->first();

    $t_kls = $qb->rawQuery($kl)->first();

    $bng = $qb->rawQuery($tb)->first();

    $PBBMin = $PMin['NILAI_PBB_MINIMAL'] ?? 0;

    $xTB = $bng['THN_AWAL_KLS_BNG'] ?? 0;

    $xTT = $t_kls['THN_AWAL_KLS_TANAH'] ?? 0;

    $ccProses = 3;

    function call_kelas(){
        global $vBangunan;

        $qb = qb();

        $QSTR = "SELECT * FROM KELAS_TANAH WHERE THN_AWAL_KLS_TANAH='" . $xTT . "'";

        $kt = $qb->rawQuery($QSTR)->first();

        if($kt){
            foreach ($vBangunan as $key => $value) {
                
                if($value[11] * 1 >= $kt['NILAI_MIN_TANAH'] && $value[11] * 1 <= $kt['NILAI_MAX_TANAH']){
                    $vBangunan[$key][15] = $value['KD_KLS_TANAH'];
                    $vBangunan[$key][16] = $kt['NILAI_PER_M2_TANAH'] * $value[12] * 1000;
                }

            }
        }

    }

    function nilai_bumi(){
        global $vBangunan;

        $qb = qb();

        $bumi = "SELECT DAT_OP_BUMI.KD_PROPINSI, DAT_OP_BUMI.KD_DATI2, DAT_OP_BUMI.KD_KECAMATAN, DAT_OP_BUMI.KD_KELURAHAN, DAT_OP_BUMI.KD_BLOK, DAT_OP_BUMI.NO_URUT, DAT_OP_BUMI.KD_JNS_OP, DAT_OP_BUMI.NO_BUMI, DAT_OP_BUMI.KD_ZNT, DAT_NIR.NIR, DAT_OP_BUMI.LUAS_BUMI, DAT_OP_BUMI.JNS_BUMI, DAT_OP_BUMI.NILAI_SISTEM_BUMI, DAT_NIR.[THN_NIR_ZNT]" . "FROM DAT_NIR INNER JOIN DAT_OP_BUMI ON (DAT_NIR.KD_ZNT = DAT_OP_BUMI.KD_ZNT) AND (DAT_NIR.KD_KELURAHAN = DAT_OP_BUMI.KD_KELURAHAN) AND (DAT_NIR.KD_KECAMATAN = DAT_OP_BUMI.KD_KECAMATAN) WHERE DAT_NIR.[THN_NIR_ZNT]='" . $_POST['YEAR'] . "' AND DAT_OP_BUMI.KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND DAT_OP_BUMI.KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $results = $qb->rawQuery($bumi)->get();

        foreach ($results as $key => $data) {
            
            $vBangunan[$key][1] = $key;

            $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);
            
            $vBangunan[$key][2] = trim($data['KD_PROPINSI']);
            $vBangunan[$key][3] =trim($data['KD_DATI2']);
            $vBangunan[$key][4] =trim($data['KD_KECAMATAN']);
            $vBangunan[$key][5] =trim($data['KD_KELURAHAN']);
            $vBangunan[$key][6] =trim($data['KD_BLOK']);
            $vBangunan[$key][7] =trim($data['NO_URUT']);
            $vBangunan[$key][8] =trim($data['KD_JNS_OP']);
            $vBangunan[$key][9] =trim($data['NO_BUMI']);
            $vBangunan[$key][10] = trim($data['KD_ZNT']);
            $vBangunan[$key][11] = trim($data['NIR']);
            $vBangunan[$key][12] = trim($data['LUAS_BUMI']);
            $vBangunan[$key][13] = trim($data['JNS_BUMI']);
            $vBangunan[$key][14] = trim($data['NIR']) * trim($data['LUAS_BUMI']);
            $vBangunan[$key][15] = 0 ;
            $vBangunan[$key][16] = 0 ;
            $vBangunan[$key][17] = $xNOP;

        
        }

        call_kelas();

    }

    function nilai_bangunan(){
        global $vBng;

        $qb = qb();

        $bangunan = "SELECT * FROM DAT_OP_BANGUNAN WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $results = $qb->rawQuery($bangunan)->get();

        foreach ($results as $key => $data) {
            
            $vBangunan[$key][1] = $key;

            $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);

            $vBng[$key][2] = trim($data['KD_PROPINSI']);
            $vBng[$key][3] = trim($data['KD_DATI2']);
            $vBng[$key][4] = trim($data['KD_KECAMATAN']);
            $vBng[$key][5] = trim($data['KD_KELURAHAN']);
            $vBng[$key][6] = trim($data['KD_BLOK']);
            $vBng[$key][7] = trim($data['NO_URUT']);
            $vBng[$key][8] = trim($data['KD_JNS_OP']);
            $vBng[$key][9] = trim($data['NO_BNG']);
            $vBng[$key][10] = trim($data['KD_JPB']);
            $vBng[$key][11] = trim($data['THN_DIBANGUN_BNG']);

            $xTahun = trim($data['THN_RENOVASI_BNG']);

            if(is_null($xTahun) || $xTahun == "" || $xTahun == "-"){
                $xTahun = 0;
            }
            
            $vBng[$key][12] = $xTahun;
            
            if(is_null($data['LUAS_BNG']) || trim($data['LUAS_BNG']) == ""){
                $vBng[$key][13] = 0;
            }else{
                $vBng[$key][13] = trim($data['LUAS_BNG']);
            }
            if(is_null($data['JML_LANTAI_BNG']) || trim($data['JML_LANTAI_BNG']) == ""){
                $vBng[$key][14] = 0;
                $XLT = 1;
            }else{
                $vBng[$key][14] = trim($data['JML_LANTAI_BNG']);
                $XLT = trim($data['JML_LANTAI_BNG']);
            }
            if(is_null($data['KONDISI_BNG']) || trim($data['KONDISI_BNG']) == ""){
                $vBng[$key][15] = 0;
            }else{
                $vBng[$key][15] = trim($data['KONDISI_BNG']);
            }
            if(is_null($data['JNS_KONSTRUKSI_BNG']) || trim($data['JNS_KONSTRUKSI_BNG']) == ""){
                $vBng[$key][16] = 0;
            }else{
                $vBng[$key][16] = trim($data['JNS_KONSTRUKSI_BNG']);
            }
            if(is_null($data['JNS_ATAP_BNG']) || trim($data['JNS_ATAP_BNG']) == ""){
                $vBng[$key][17] = 0;
            }else{
                $vBng[$key][17] = trim($data['JNS_ATAP_BNG']);
            }
            if(is_null($data['KD_DINDING']) || trim($data['KD_DINDING']) == ""){
                $vBng[$key][18] = 0;
            }else{
                $vBng[$key][18] = trim($data['KD_DINDING']);
            }
            if(is_null($data['KD_LANTAI']) || trim($data['KD_LANTAI']) == ""){
                $vBng[$key][19] = 0;
            }else{
                $vBng[$key][19] = trim($data['KD_LANTAI']);
            }
            if(is_null($data['KD_LANGIT_LANGIT']) || trim($data['KD_LANGIT_LANGIT']) == ""){
                $vBng[$key][20] = 0;
            }else{
                $vBng[$key][20] = trim($data['KD_LANGIT_LANGIT']);
            }

            $vBng[$key][21] = $data['NILAI_SISTEM_BNG'];
            $vBng[$key][22] = 0;
            $vBng[$key][23] = 0;
            $vBng[$key][24] = 0;
            $vBng[$key][25] = 0;
            $vBng[$key][26] = 0;
            $vBng[$key][27] = 0;
            $vBng[$key][28] = 0;
            $vBng[$key][29] = 0;
            $vBng[$key][30] = 0;
            $vBng[$key][31] = 0;
            $vBng[$key][32] = 0;
            $vBng[$key][33] = 0;
            $vBng[$key][34] = 0;
            $vBng[$key][35] = 0;
            $vBng[$key][36] = 0;
            $vBng[$key][37] = 0;
            $vBng[$key][38] = 0;
            $vBng[$key][39] = 0;
            $vBng[$key][40] = 0;
            $vBng[$key][41] = 0;
            $vBng[$key][42] = 0;
            $vBng[$key][43] = 0;
            $vBng[$key][44] = 0;
            $vBng[$key][45] = 0;
            $vBng[$key][46] = 0;
            $vBng[$key][47] = 0;
            $vBng[$key][48] = 0;
            $vBng[$key][49] = 0;
            $vBng[$key][50] = 0;
            $vBng[$key][51] = 0;
            $vBng[$key][52] = 0;
            $vBng[$key][53] = 0;
            $vBng[$key][54] = 0;
            $vBng[$key][55] = 0;
            $vBng[$key][56] = 0;
            $vBng[$key][57] = 0;
            $vBng[$key][58] = 0;
            $vBng[$key][59] = 0;
            $vBng[$key][60] = 0;
            $vBng[$key][61] = 0;
            $vBng[$key][62] = 0;
            
            $vBng[$key][63] = 0;
            $vBng[$key][64] = 0;
            
            $vBng[$key][65] = 0;
            
            $vBng[$key][66] = 0;
            $vBng[$key][67] = 0;
            $vBng[$key][68] = 0;
            $vBng[$key][69] = "SISTEM";
            $vBng[$key][70] = 0;
            $vBng[$key][71] = 0;
            
            $vBng[$key][72] = $data['NO_FORMULIR_LSPOP'];
            $vBng[$key][73] = $data['JNS_TRANSAKSI_BNG'];

            if(is_null($data['NIP_PENDATA_BNG']) || $data['NIP_PENDATA_BNG'] = "" ) $data['NIP_PENDATA_BNG'] = "-";
            if(is_null($data['NIP_PEMERIKSA_BNG']) || $data['NIP_PEMERIKSA_BNG'] = "" ) $data['NIP_PEMERIKSA_BNG'] = "-";
            if(is_null($data['NIP_PEREKAM_BNG']) || $data['NIP_PEREKAM_BNG'] = "" ) $data['NIP_PEREKAM_BNG'] = "-";


            $vBng[$key][74] = $data['TGL_PENDATAAN_BNG'];
            $vBng[$key][75] = $data['NIP_PENDATA_BNG'];
            $vBng[$key][76] = $data['TGL_PEMERIKSAAN_BNG'];
            $vBng[$key][77] = $data['NIP_PEMERIKSA_BNG'];
            $vBng[$key][78] = $data['TGL_PEREKAMAN_BNG'];
            $vBng[$key][79] = $data['NIP_PEREKAM_BNG'];
            $vBng[$key][80] = 0;
            $vBng[$key][81] = 0;
            $vBng[$key][82] = 0;
            $vBng[$key][83] = 0;
            $vBng[$key][84] = 0;
            $vBng[$key][85] = 0;
            $vBng[$key][86] = 0;

        }
    }

    function nilai_fasilitas(){
        global $vFAS;

        $qb = qb();

        $sql = "SELECT * FROM DAT_FASILITAS_BANGUNAN WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $results = $qb->rawQuery($sql)->get();

        foreach ($results as $key => $data) {

            $vFAS[$key][1] = $key;
            
            $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);

            $vFAS[$key][2] = trim($value['KD_PROPINSI']);
            $vFAS[$key][3] = trim($value['KD_DATI2']);
            $vFAS[$key][4] = trim($value['KD_KECAMATAN']);
            $vFAS[$key][5] = trim($value['KD_KELURAHAN']);
            $vFAS[$key][6] = trim($value['KD_BLOK']);
            $vFAS[$key][7] = trim($value['NO_URUT']);
            $vFAS[$key][8] = trim($value['KD_JNS_OP']);
            $vFAS[$key][9] = trim($value['NO_BNG']);
            $vFAS[$key][10] = trim($value['KD_FASILITAS']);
            $vFAS[$key][11] = trim($value['JML_SATUAN']);
            
            $vFAS[$key][12] = 0;
            $vFAS[$key][13] = 0;
            $vFAS[$key][14] = 0;
            $vFAS[$key][15] = 0;
            $vFAS[$key][16] = 0;
            $vFAS[$key][17] = 0;
            $vFAS[$key][18] = 0;
            $vFAS[$key][19] = 0;
            $vFAS[$key][20] = 0;
            $vFAS[$key][21] = 0;
            $vFAS[$key][22] = 0;
            $vFAS[$key][23] = 0;
            $vFAS[$key][24] = 0;
            $vFAS[$key][25] = 0;
            $vFAS[$key][26] = 0;
            $vFAS[$key][27] = 0;
            $vFAS[$key][28] = 0;
            $vFAS[$key][29] = 0;
            $vFAS[$key][30] = 0;
            $vFAS[$key][31] = 0;
            $vFAS[$key][32] = 0;
            $vFAS[$key][33] = 0;
            $vFAS[$key][34] = 0;
            $vFAS[$key][35] = 0;
            $vFAS[$key][36] = 0;
            $vFAS[$key][37] = 0;
            $vFAS[$key][38] = 0;
            $vFAS[$key][39] = 0;
            $vFAS[$key][40] = 0;
            $vFAS[$key][41] = 0;
            $vFAS[$key][42] = 0;
            $vFAS[$key][43] = 0;
            $vFAS[$key][44] = 0;
            $vFAS[$key][45] = 0;
            $vFAS[$key][46] = 0;
            $vFAS[$key][47] = 0;
            $vFAS[$key][48] = 0;
            $vFAS[$key][49] = 0;
            $vFAS[$key][50] = 0;
            $vFAS[$key][51] = 0;
            $vFAS[$key][52] = 0;
            $vFAS[$key][53] = 0;
            $vFAS[$key][54] = 0;
            $vFAS[$key][55] = 0;
            $vFAS[$key][56] = 0;
            $vFAS[$key][57] = 0;
            $vFAS[$key][58] = 0;
            $vFAS[$key][59] = 0;
        }

    }

    function dbkb_fas1a(){
       global $vFAS;

       $qb = qb();

        $dbkb_fas1a = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_NON_DEP.NILAI_NON_DEP, FAS_NON_DEP.THN_NON_DEP FROM FASILITAS INNER JOIN FAS_NON_DEP ON FASILITAS.KD_FASILITAS = FAS_NON_DEP.KD_FASILITAS WHERE FAS_NON_DEP.THN_NON_DEP='" . $_POST['YEAR'] . "' ";

        $dbkb = $qb->rawQuery($dbkb_fas1a)->first();

        if($dbkb){
            foreach ($vFAS as $key => $value) {
                if($vFAS[$key][10] == $dbkb['KD_FASILITAS']){
                    $vFAS[$key][12] = $dbkb['NILAI_NON_DEP'];

                    if($vFAS[$key][10] == 44){
                        $vFAS[$key][12] = $dbkb["NILAI_NON_DEP"] / 1000;
                    }
    
                    if($dbkb["KD_FASILITAS"] == "01" || $dbkb["KD_FASILITAS"] == "02" || $dbkb["KD_FASILITAS"] == "11" || $dbkb["KD_FASILITAS"] == "44"){
                        $vFAS[$key][13] = $vFAS[$key][11] * $vFAS[$key][12];
                    }else{
                        $vFAS[$key][15] = $vFAS[$key][11] * $vFAS[$key][12];
                        $vFAS[$key][19] = $vFAS[$key][12];
                    }
                }

            }
        }
    }

    function dbkb_fas2a(){
        global $vFAS;

        $qb = qb();

        $dbkb_fas2a = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_DEP_JPB_KLS_BINTANG.KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.NILAI_FASILITAS_KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG FROM FASILITAS INNER JOIN FAS_DEP_JPB_KLS_BINTANG ON FASILITAS.KD_FASILITAS = FAS_DEP_JPB_KLS_BINTANG.KD_FASILITAS WHERE FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG='" . $_POST['YEAR'] . "'";

        if($dbkb){
            foreach ($vFAS as $key => $value) {

                if($vFAS[$key][10] == $dbkb['KD_FASILITAS']){

                    if($vFAS[$key][11] == trim($dbkb['KLS_BINTANG'])){
                        $vFAS[$key][12] = $dbkb['NILAI_FASILITAS_KLS_BINTANG'];

                        if($vFAS[$key][10] == "03" || $vFAS[$key][10] == "04" || $vFAS[$key][10] == "06" || $vFAS[$key][10] == "07" || $vFAS[$key][10] == "03"){
                            $vFAS[$key][16] = $vFAS[$key][12];
                        }elseif($vFAS[$key][10] == "05" || $vFAS[$key][10] == "08" || $vFAS[$key][10] == "10"){
                            $vFAS[$key][17] = $vFAS[$key][12];
                        }else{
                            $vFAS[$key][18] = $vFAS[$key][12];
                        }
                    }
                    
                }

            }
        }
    }

    function dbkb_fas3a(){
        global $vFAS;

        $qb = qb();

        $dbkb_fas3a = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_DEP_MIN_MAX.KLS_DEP_MIN, FAS_DEP_MIN_MAX.KLS_DEP_MAX, FAS_DEP_MIN_MAX.NILAI_DEP_MIN_MAX, FAS_DEP_MIN_MAX.THN_DEP_MIN_MAX FROM FASILITAS INNER JOIN FAS_DEP_MIN_MAX ON FASILITAS.KD_FASILITAS = FAS_DEP_MIN_MAX.KD_FASILITAS WHERE FAS_DEP_MIN_MAX.THN_DEP_MIN_MAX='" . $_POST['YEAR'] . "' ORDER BY FASILITAS.KD_FASILITAS,FAS_DEP_MIN_MAX.KLS_DEP_MIN,FAS_DEP_MIN_MAX.KLS_DEP_MAX ASC";

        $dbkb = $qb->rawQuery($dbkb_fas3a)->first();

        if($dbkb){
            foreach ($vFAS as $key => $value) {

                if($vFAS[$key][10] == $dbkb['KD_FASILITAS']){
                    
                    if($vFAS[$key][11] >= $dbkb['KLS_DEP_MIN'] && $vFAS[$key][11] <= $dbkb['KLS_DEP_MAX']){
                        $vFAS[$key][12] = $dbkb['NILAI_DEP_MIN_MAX'];
                    }
    
                    if($dbkb["KD_FASILITAS"] == "40"){
                        $vFAS[$key][13] = $vFAS[$key][11] * $vFAS[$key][12];
                    }else{
                        $vFAS[$key][15] = $vFAS[$key][11] * $vFAS[$key][12];
                        $vFAS[$key][19] = $vFAS[$key][12];
                    }
                }

            }
        }
    }

    function nilai_individu(){
        global $vBng;

        $qb = qb();

        $nilai_individu = "SELECT * FROM DAT_NILAI_INDIVIDU";

        $kt = $qb->rawQuery($nilai_individu)->first();

        if($kt){
            foreach ($vBng as $key => $value) {
                $NOP1 = trim($kt['KD_PROPINSI']). ".". trim($kt['KD_DATI2']). ".". trim($kt['KD_KECAMATAN']). ".". trim($kt['KD_KELURAHAN']). ".". trim($kt['KD_BLOK']). "-". trim($kt['NO_URUT']). ".". trim($kt['KD_JNS_OP']);

                $NOP2 = $vBng[$key][2]. ".". $vBng[$key][3]. ".". $vBng[$key][4]. ".". $vBng[$key][5]. ".". $vBng[$key][6]. "-". $vBng[$key][7]. ".". $vBng[$key][8];
                 
                if ($NOP1 == $NOP2 && trim($kt['NO_BNG']) == $vBng[$key][9] ){
                    $vBng[$key][80] = $kt['NILAI_INDIVIDU'];
                    $vBng[$key][69] = "INDIVIDU";
                }
            }

        }

    }

    function call_op(){

        global $vBangunan,$vBng,$vOP;

        $qb = qb();

        foreach ($vBangunan as $key => $value) {
            $vOP[$key][1] = $key;
            $vOP[$key][2] = $value[2];
            $vOP[$key][3] = $value[3];
            $vOP[$key][4] = $value[4];
            $vOP[$key][5] = $value[5];
            $vOP[$key][6] = $value[6];
            $vOP[$key][7] = $value[7];
            $vOP[$key][8] = $value[8];
            $vOP[$key][9] = $value[17];
            $vOP[$key][10] = 0;
            $vOP[$key][11] = 0;
            $vOP[$key][12] = 0;
            $vOP[$key][13] = 0;
            $vOP[$key][14] = 0;
            $vOP[$key][15] = 0;
            $vOP[$key][16] = 0;
            $vOP[$key][17] = 0;
            $vOP[$key][18] = "SISTEM";
            $vOP[$key][19] = 0;
            $vOP[$key][20] = $value[13];
            $vOP[$key][21] = 0;
            $vOP[$key][22] = 0;
            $vOP[$key][23] = 0;
            $vOP[$key][24] = 0;
            $vOP[$key][25] = 0;
            $vOP[$key][26] = 0;
            $vOP[$key][27] = 0;
            $vOP[$key][28] = 0;
            $vOP[$key][29] = 0;
            $vOP[$key][30] = 0;
            $vOP[$key][31] = 0;
            $vOP[$key][32] = 0;
            $vOP[$key][33] = 0;
            $vOP[$key][34] = 0;
            $vOP[$key][35] = 0;
            $vOP[$key][36] = 0;
            $vOP[$key][37] = 0;
            $vOP[$key][38] = 0;
            $vOP[$key][39] = 0;
            $vOP[$key][40] = 0;
            $vOP[$key][41] = 0;
            $vOP[$key][42] = 0;
            $vOP[$key][43] = 0;
            $vOP[$key][44] = 0;
            $vOP[$key][45] = 0;
            $vOP[$key][46] = 0;
            $vOP[$key][47] = 0;
            $vOP[$key][48] = 0;
            $vOP[$key][49] = 0;

            
            $NOP1 = $vOP[$key][2] . "." .$vOP[$key][3] . "." .$vOP[$key][4] . "." .$vOP[$key][5] . "." .$vOP[$key][6] . "-" .$vOP[$key][7] . "." .$vOP[$key][8];
                
            $vOP[$key][10] = $value[12];
            $vOP[$key][11] = $value[15];
            $vOP[$key][12] = $value[16]; 
            
            $QJum1 = 0; 
            $QJum2 = 0;
            $QJum3 = 0;
            $xKet = "SISTEM";

            foreach ($vBng as $key => $value) {
                if($vOP[$key][9] == $value[64]){
                    
                    $QJum1 = $QJum1 + $vBng[13];

                    if($vBng[69] = "INDIVIDU" ){
                        $QJum2 = $QJum2 + $vBng[80];
                    }else{
                        $QJum2 = $QJum2 + $vBng[63];
                    }

                    $QJum3 = $QJum3 + $vBng[24];

                    $xKet = $value[69];
                    
                }
            }

            $vOP[13] = $QJum1;
            $vOP[14] = number_format($QJum2, 2);
            $vOP[18] = $xKet;
        }

        $kb = "SELECT * FROM KELAS_BANGUNAN WHERE THN_AWAL_KLS_BNG ='" & $xTB & "'";
        $kb_single = $qb->rawQuery($kb)->first();

        if($kb_single){
            foreach ($vOP as $key => $value) {
                if($vOP[$key][14] != 0 || $vOP[$key][13] != 0){
                    if($vOP[$key][14] / $vOP[$key][13] >= $kb_single['NILAI_MIN_BNG'] && $vOP[$key][14] / $vOP[$key][13] >= $kb_single['NILAI_MAX_BNG']){
                        $vOP[$key][15] = $kb_single['KD_KLS_BNG'];
                        $vOP[$key][16] = $kb_single['NILAI_PER_M2_BNG'];

                        $vOP[$key][17] = $kb_single['NILAI_PER_M2_BNG'] * $vOP[$key][13] * 1000;
                        
                    }
                }

                if($vOP[$key][14] <= 0){
                    $vOP[$key][17] = 0;
                }

                $vOP[$key][31] = $vOP[$key][12]+ $vOP[$key][17];

                if($vOP[$key][31] * 1 >= ccMin(1) And $vOP[$key][31] * 1 <= ccMax(1) ){
                    $vOP[$key][32] = ccTarif(1);
                    $vOP[$key][33] = ccTKP(1);
                }else{
                    $vOP[$key][32] = ccTarif(2);
                    $vOP[$key][33] = ccTKP(2);
                }

                if($vOP[$key][20] != 1 || $vOP[$key][17] == 0 ) $vOP[$key][33] = 0;
                $vOP[$key][34] = $PBBMin;
                $vOP[$key][35] = ($vOP[$key][31] - $vOP[$key][33]) * ($vOP[$key][32] / 100);

                if($vOP[$key][35] < 0) $vOP[$key][35] = 0;
            }
        }

        $Q_SPPT = "SELECT * FROM QOBJEKPAJAK WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "' ORDER BY NOPQ ASC";

        $SPPT = $qb->rawQuery($Q_SPPT)->first();

        if($SPPT){

            foreach ($vOP as $key => $value) {
                if($SPPT['NOPQ'] == $vOP[$key][9]){
                    if(is_null($SPPT['NM_WP'])){
                        $vOP[$key][21] = "";
                    }else{
                        $vOP[$key][21] = $SPPT['NM_WP'];
                    }

                    if(is_null($SPPT['JALAN_WP'])){
                        $vOP[$key][22] = "-";
                    }else{
                        $vOP[$key][22] = $SPPT['JALAN_WP'];
                    }

                    if(is_null($SPPT['BLOK_KAV_NO_WP'])){
                        $vOP[$key][23] = "00";
                    }else{
                        $vOP[$key][23] = $SPPT['BLOK_KAV_NO_WP'];
                    }

                    if(is_null($SPPT['RW_WP'])){
                        $vOP[$key][24] = "00";
                    }else{
                        $vOP[$key][24] = $SPPT['RW_WP'];
                    }

                    if(is_null($SPPT['RT_WP'])){
                        $vOP[$key][25] = "00";
                    }else{
                        $vOP[$key][25] = $SPPT['RT_WP'];
                    }

                    if(is_null($SPPT['KELURAHAN_WP'])){
                        $vOP[$key][26] = "-";
                    }else{
                        $vOP[$key][26] = $SPPT['KELURAHAN_WP'];
                    }

                    if(is_null($SPPT['KOTA_WP'])){
                        $vOP[$key][27] = "-";
                    }else{
                        $vOP[$key][27] = $SPPT['KOTA_WP'];
                    }

                    if(is_null($SPPT['KD_POS_WP'])){
                        $vOP[$key][28] = "00000";
                    }else{
                        $vOP[$key][28] = $SPPT['KD_POS_WP'];
                    }

                    if(is_null($SPPT['NPWP'])){
                        $vOP[$key][29] = "-";
                    }else{
                        $vOP[$key][29] = $SPPT['NPWP'];
                    }

                    if(is_null($SPPT['NO_PERSIL'])){
                        $vOP[$key][30] = "00";
                    }else{
                        $vOP[$key][30] = $SPPT['NO_PERSIL'];
                    }

                    if(is_null($SPPT['SUBJEK_PAJAK_ID'])){
                        $vOP[$key][36] = "-";
                    }else{
                        $vOP[$key][36] = $SPPT['SUBJEK_PAJAK_ID'];
                    }

                    $vOP[$key][37] = $SPPT['NO_FORMULIR_SPOP'];
                    $vOP[$key][38] = $SPPT['KD_STATUS_WP'];
                    $vOP[$key][39] = $SPPT['JNS_TRANSAKSI_OP'];

                    if(is_null($SPPT['NIP_PENDATA']) || $SPPT['NIP_PENDATA'] == "" ){
                        $SPPT['NIP_PENDATA'] = "-";
                    }

                    if(is_null($SPPT['NIP_PEMERIKSA_OP']) || $SPPT['NIP_PEMERIKSA_OP'] == "" ){
                        $SPPT['NIP_PEMERIKSA_OP'] = "-";
                    }

                    if(is_null($SPPT['NIP_PEREKAM_OP']) || $SPPT['NIP_PEREKAM_OP'] == "" ){
                        $SPPT['NIP_PEREKAM_OP'] = "-";
                    }

                    $vOP[$key][40] = $SPPT['TGL_PENDATAAN_OP'];
                    $vOP[$key][41] = $SPPT['NIP_PENDATA'];
                    $vOP[$key][42] = $SPPT['TGL_PEMERIKSAAN_OP'];
                    $vOP[$key][43] = $SPPT['NIP_PEMERIKSA_OP'];
                    $vOP[$key][44] = $SPPT['TGL_PEREKAMAN_OP'];
                    $vOP[$key][45] = $SPPT['NIP_PEREKAM_OP'];

                    if(is_null($SPPT['JALAN_OP'])){
                        $vOP[$key][46] = "-";
                    }else{
                        $vOP[$key][46] = $SPPT['JALAN_OP'];
                    }

                    if(is_null($SPPT['BLOK_KAV_NO_OP'])){
                        $vOP[$key][47] = "00";
                    }else{
                        $vOP[$key][47] = $SPPT['BLOK_KAV_NO_OP'];
                    }

                    if(is_null($SPPT['RW_OP'])){
                        $vOP[$key][48] = "00";
                    }else{
                        $vOP[$key][48] = $SPPT['RW_OP'];
                    }

                    if(is_null($SPPT['RT_OP'])){
                        $vOP[$key][49] = "00";
                    }else{
                        $vOP[$key][49] = $SPPT['RT_OP'];
                    }

               }
            }
        }
    }

    function sv_bumi(){
        global $vBangunan;

        $qb = qb();

        $sv_bumi = "Select * From DAT_OP_BUMI WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $data = $qb->rawQuery($sv_bumi)->first();

        if($data){
            foreach ($vBangunan as $key => $value) {
                $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);
                if($data['NO_BUMI'] == $value[9] && $xNOP == $value[17]){
                    $data['LUAS_BUMI'] = $value[12];
                    $data['JNS_BUMI'] = $value[13];
                    $data['NILAI_SISTEM_BUMI'] = $value[14];

                    $qb->update("DAT_OP_BUMI",$data)->where("KD_KECAMATAN",$_POST['KD_KECAMATAN'])->where("KD_KELURAHAN",$_POST['KD_KELURAHAN'])->exec();
                }
            }
        }
    }

    function sv_bangunan(){
        global $vBng;

        $qb = qb();

        $sv_bangunan = "Select * From DAT_OP_BANGUNAN WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $data = $qb->rawQuery($sv_bangunan)->first();

        if($data){
            foreach ($vBng as $key => $value) {
                $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);

                if($value[64] == $xNOP && $data['NO_BNG'] == $value[9] && $data['KD_JPB'] == $value[10]){
                    $data['K_UTAMA'] = $value[81];
                    $data['K_MATERIAL'] = $value[82];
                    $data['K_FASILITAS'] = $value[83];
                    $data['J_SUSUT'] = $value[84];
                    $data['K_SUSUT'] = $value[85];
                    $data['K_NON_SUSUT'] = $value[86];
                    $data['NILAI_SISTEM_BNG'] = $value[63];

                    $qb->update("DAT_OP_BANGUNAN",$data)->where("KD_KECAMATAN",$_POST['KD_KECAMATAN'])->where("KD_KELURAHAN",$_POST['KD_KELURAHAN'])->exec();
                }
            }
        }
    }

    function sv_individu(){
        global $vBng;

        $qb = qb();

        $sv_individu = "Select * From DAT_NILAI_INDIVIDU WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";
        
        $data = $qb->rawQuery($sv_individu)->first();

        if($data){
            foreach ($vBng as $key => $value) {

                $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);

                if($value[64] == $xNOP && $data['NO_BNG'] == $value[9]){
                    $data['NILAI_INDIVIDU'] = $value[80];

                    $qb->update("DAT_NILAI_INDIVIDU",$data)->where("KD_KECAMATAN",$_POST['KD_KECAMATAN'])->where("KD_KELURAHAN",$_POST['KD_KELURAHAN'])->exec();
                }
            }
        }
    
    }

    function sv_objek(){
        global $vOP;

        $qb = qb();

        $b_sv_objek = "B_OP '" . $ccProses . "','" . $_POST['KD_KECAMATAN'] . "','" . $_POST['KD_KELURAHAN'] . "'";
        $sv_objek = "Select * From DAT_OBJEK_PAJAK WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $qb->rawQuery($b_sv_objek)->exec();
        
        $data = $qb->rawQuery($sv_objek)->first();

        if($data){
            foreach ($vOP as $key => $value) {
                $data['KD_PROPINSI'] = $value[2];
                $data['KD_DATI2'] = $value[3];
                $data['KD_KECAMATAN'] = $value[4];
                $data['KD_KELURAHAN'] = $value[5];
                $data['KD_BLOK'] = $value[6];
                $data['NO_URUT'] = $value[7];
                $data['KD_JNS_OP'] = $value[28];

                $data['NO_PERSIL'] = $value[30];
                $data['SUBJEK_PAJAK_ID'] = $value[36];
                $data['NO_FORMULIR_SPOP'] = $value[37];
                $data['JALAN_OP'] = $value[46];
                $data['BLOK_KAV_NO_OP'] = $value[47];
                $data['RW_OP'] = $value[48];
                $data['RT_OP'] = $value[49];
                $data['KD_STATUS_CABANG'] = 0;
                $data['KD_STATUS_WP'] = $value[38];

                $data['TOTAL_LUAS_BUMI'] = $value[10];
                $data['TOTAL_LUAS_BNG'] = $value[13];
                $data['NJOP_BUMI'] = $value[12];
                $data['NJOP_BNG'] = $value[17];

                $data['STATUS_PETA_OP'] = 1;
                $data['JNS_TRANSAKSI_OP'] = $value[39];
                $data['TGL_PENDATAAN_OP'] = $value[40];
                $data['NIP_PENDATA'] = $value[41];
                $data['TGL_PEMERIKSAAN_OP'] = $value[42];
                $data['NIP_PEMERIKSA_OP'] = $value[43];
                $data['TGL_PEREKAMAN_OP'] = $value[44];
                $data['NIP_PEREKAM_OP'] = $value[45];

                $qb->update("DAT_OBJEK_PAJAK",$data)->where("KD_KECAMATAN",$_POST['KD_KECAMATAN'])->where("KD_KELURAHAN",$_POST['KD_KELURAHAN'])->exec();
            }
        }

        $sppt = "select * from SPPT WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KECAMATAN'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'] . "'";
    
        if($sppt){

            foreach ($vOP as $key => $value) {
                $xxProp = $value[2];
                $xxKab = $value[3];
                $xxKec = $value[4];
                $xxKel = $value[5];
                $xxBlok = $value[6];
                $xxUrut = $value[7];
                $xxJenis = $value[8];
                $xNOP1 = $xxProp . "." . $xxKab . "." . $xxKec . "." . $xxKel . "." . $xxBlok . "-" . $xxUrut . "." . $xxJenis;
                $xxKelas1 = $value[11];
                $xxKelas2 = $value[15];
                $xxJatuh = date("dd/mm/yyyy");
                $LBumi = $value[10];
                $LBng = $value[13];
                $NBumi = $value[12];
                $NBng = $value[17];
                $t_NJOP = $value[31];


                $xNJOPTKP = $value[33];
                $xNJKP = 0;
                $xxPBBMin = $value[34];
                $xHutang = $value[35];
                $xKurang = 0;
                $xBayar = $xHutang - $xKurang;

                if($xBayar < $xxPBBMin) $xBayar = $xxPBBMin;

                if($value[20] != "4" ){

                    $new_data['KD_PROPINSI'] = "12";
                    $new_data['KD_DATI2'] = "12";
                    $new_data['KD_KECAMATAN'] = $xxKec;
                    $new_data['KD_KELURAHAN'] = $xxKel;
                    $new_data['KD_BLOK'] = $xxBlok;
                    $new_data['NO_URUT'] = $xxUrut;
                    $new_data['KD_JNS_OP'] = $xxJenis;
                    $new_data['THN_PAJAK_SPPT'] = $_POST['YEAR'];
                    $new_data['NM_WP_SPPT'] = "-";
                    $new_data['JLN_WP_SPPT'] = "-";
                    $new_data['BLOK_KAV_NO_WP_SPPT'] = "00";
                    $new_data['RW_WP_SPPT'] = "00";
                    $new_data['RT_WP_SPPT'] = "00";
                    $new_data['KELURAHAN_WP_SPPT'] = "-";
                    $new_data['KOTA_WP_SPPT'] = "-";
                    $new_data['KD_POS_WP_SPPT'] = "-";
                    $new_data['NPWP_SPPT'] = "0";
                    $new_data['NO_PERSIL_SPPT'] = "00";
                    $new_data['KD_KLS_TANAH'] = $xxKelas1;
                    $new_data['THN_AWAL_KLS_TANAH'] = $xTT;
                    $new_data['KD_KLS_BNG'] = $xxKelas2;
                    $new_data['THN_AWAL_KLS_BNG'] = $xTB;
                    $new_data['TGL_JATUH_TEMPO_SPPT'] = $xxJatuh;
                    $new_data['LUAS_BUMI_SPPT'] = $LBumi;
                    $new_data['LUAS_BNG_SPPT'] = $LBng;
                    $new_data['NJOP_BUMI_SPPT'] = $NBumi;
                    $new_data['NJOP_BNG_SPPT'] = $NBng;
                    $new_data['NJOP_SPPT'] = $t_NJOP;
                    $new_data['NJOPTKP_SPPT'] = $xNJOPTKP;
                    $new_data['NJKP_SPPT'] = $xNJKP;
                    $new_data['PBB_TERHUTANG_SPPT'] = $xHutang;
                    $new_data['FAKTOR_PENGURANG_SPPT'] = $xKurang;
                    $new_data['PBB_YG_HARUS_DIBAYAR_SPPT'] = $xBayar;
                    $new_data['STATUS_PEMBAYARAN_SPPT'] = "0";
                    $new_data['STATUS_TAGIHAN_SPPT'] = "0";
                    $new_data['STATUS_CETAK_SPPT'] = "0";
                    $new_data['TGL_TERBIT_SPPT'] = $xxJatuh;
                    $new_data['TGL_CETAK_SPPT'] = $xxJatuh;
                    $new_data['NIP_PENCETAK_SPPT'] = "000000";
                    $new_data['SIKLUS_SPPT'] = 1;
                    $new_data['KD_KANWIL_BANK'] = "01";
                    $new_data['KD_KPPBB_BANK'] = "16";
                    $new_data['KD_BANK_TUNGGAL'] = "04";
                    $new_data['KD_BANK_PERSEPSI'] = "01";
                    $new_data['KD_TP'] = "93";
                    $new_data['PROSES'] = "N";

                    $qb->insert("SPPT",$new_data)->where("KD_KECAMATAN",$_POST['KD_KECAMATAN'])->where("KD_KELURAHAN",$_POST['KD_KELURAHAN'])->where('THN_PAJAK_SPPT',$_POST['YEAR'])->exec();

                }

            }

            $sppt_del = "DELETE FROM SPPT WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KECAMATAN'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'];
        
            $pembayaran_del = "DELETE FROM PEMBAYARAN_SPPT WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KECAMATAN'] . "' and THN_PAJAK_SPPT='" . $_POST['YEAR'];
        }
    }
    
    nilai_bumi();
    nilai_fasilitas();
    dbkb_fas1a();
    dbkb_fas3a();
    dbkb_fas2a();
    nilai_individu();

    sv_bumi();
    sv_individu();
    sv_objek();
    
    if($_POST['CEK_PROSES'] == 'on'){
        // $sql1 = "H_SATUAN '" . $_POST['YEAR'] . "' ";
        // $insert1 = $qb->rawQuery($sql1)->exec();

        // $sql2 = "H_KEGIATAN '" . $_POST['YEAR'] . "' ";
        // $insert2 = $qb->rawQuery($sql2)->exec();

        // $sql3 = "HITUNG_DBKB_STANDARD '" . $_POST['YEAR'] . "' ";
        // $insert3 = $qb->rawQuery($sql3)->exec();

        // $sql4 = "HITUNG_DBKB_FINAL '" . $_POST['YEAR'] . "' ";
        // $insert4 = $qb->rawQuery($sql4)->exec();
    }

    // if(($insert1 .. $insert2 .. $insert3 .. $insert4) || ($insert5 .. $insert6 .. $insert7)){
    //     set_flash_msg(['success'=>'Data Saved']);
    //     header("location:index.php?page=builder/penilaian-massal/index");
    //     return;
    // }

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");

$kecamatans = $qb->select("REF_KECAMATAN")->get();