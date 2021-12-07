<?php

    $vBangunan = [];
    $vBng = [];
    $vFAS = [];
    $vOP = [];

    $ccMin = [];
    $ccMax = [];
    $ccTarif = [];
    $ccTKP = [];

    $strTarif = "Select * From TARIF order by NJOP_MIN Asc";

    $tarif = $qb->rawQuery($strTarif)->get();

    if($tarif){
        foreach($tarif as $key => $value){
            $ccMin[$key][] = $value['NJOP_MIN'];
            $ccMax[$key][]= $value['NJOP_MAX'];
            $ccTarif[$key][] = $value['NILAI_TARIF'];
            $ccTKP[$key][] = $value['NJOPTKP'];
        }
    }

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

    $mz = "SELECT * FROM DBKB_MEZANIN WHERE THN_DBKB_MEZANIN='". $_POST['YEAR'] . "'";

    $nMz = $qb->rawQuery($mz)->get();

    foreach($nMz as $_nMz)
        $nMezanin = $_nMz['NILAI_DBKB_MEZANIN'];

    $Qulin = "Select * From KAYU_ULIN where THN_STATUS_KAYU_ULIN='" . $_POST['YEAR'] .  "'";

    $ulin = $qb->rawQuery($Qulin)->first();

    $ck_Ulin = $ulin['STATUS_KAYU_ULIN'] ?? 0;

    function qb(){
        return new QueryBuilder();
    }

    function call_kelas(){
        global $vBangunan,$xTT;

        $qb = qb();

        $QSTR = "SELECT * FROM KELAS_TANAH WHERE THN_AWAL_KLS_TANAH='" . $xTT . "'";

        $kt = $qb->rawQuery($QSTR)->get();

        foreach($kt as $kelas_tanah)
        {
            foreach ($vBangunan as $key => $value) {
                
                if($value[10] >= $kelas_tanah['NILAI_MIN_TANAH'] && $value[10] <= $kelas_tanah['NILAI_MAX_TANAH']){
                    $vBangunan[$key][14] = $value['KD_KLS_TANAH'];
                    $vBangunan[$key][15] = $kelas_tanah['NILAI_PER_M2_TANAH'] * $value[11] * 1000;
                }
    
            }
        }


    }

    function CALL_DBKB_STANDARD(){
        global $vBng;

        $qb = qb();

        $sql = "SELECT DBKB_STANDARD.THN_DBKB_STANDARD, DBKB_STANDARD.KD_JPB, TIPE_BANGUNAN.TIPE_BNG, TIPE_BANGUNAN.NM_TIPE_BNG, TIPE_BANGUNAN.LUAS_MIN_TIPE_BNG, TIPE_BANGUNAN.LUAS_MAX_TIPE_BNG, TIPE_BANGUNAN.FAKTOR_PEMBAGI_TIPE_BNG, DBKB_STANDARD.KD_BNG_LANTAI, DBKB_STANDARD.NILAI_DBKB_STANDARD FROM DBKB_STANDARD INNER JOIN TIPE_BANGUNAN ON DBKB_STANDARD.TIPE_BNG = TIPE_BANGUNAN.TIPE_BNG WHERE (((DBKB_STANDARD.THN_DBKB_STANDARD)='" . $_POST['YEAR'] . "')) order by KD_JPB,KD_BNG_LANTAI ASC";

        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                $JPB = trim($value[9]);
                $LUAS = $value[12];
                $JLANTAI = $value[13];
                $xJPB = $_dbkb['KD_JPB'];
                $XJLANTAI = trim($_dbkb['KD_BNG_LANTAI']);
                $XBAGI = $_dbkb['FAKTOR_PEMBAGI_TIPE_BNG'];
                $LMIN = $_dbkb['LUAS_MIN_TIPE_BNG'];
                $LMAX = $_dbkb['LUAS_MAX_TIPE_BNG'];

            //     Select Case JPB
            // Case "01", "02", "04", "05", "07", "09", "10", "11"

                if( $JLANTAI <= 2){
                    $JL = 1;
                }
                elseif( $JLANTAI <= 4){
                    $JL = 2;
                }
                else
                    $JL = 3;
                }

                if( ($JPB == "01" || $JPB == "10" || $JPB == "11") && $JL <= 2 ) $JPB = "01";

                if($JPB == "05" && $JL <= 2 ){ $JPB = "05"; }

                if(($JPB == "02" || $JPB == "04" || $JPB == "07" || $JPB == "09") && $JL <= 2 ){
                    $JPB = "02";
                }

                if($JL <= 2 ){
                    if($_dbkb['KD_JPB'] == $JPB && ($LUAS >= $_dbkb['LUAS_MIN_TIPE_BNG'] && $LUAS <= $_dbkb['LUAS_MAX_TIPE_BNG']) && trim($_dbkb['KD_BNG_LANTAI']) == $JLANTAI ){ 

                        $nDBKB = $_dbkb['NILAI_DBKB_STANDARD'];

                        $cTipe = $_dbkb['TIPE_BNG'] . "_" . trim($_dbkb['KD_BNG_LANTAI']) . "-" . $JL;

                        $vBng[$key][25] = $nDBKB;
                        $vBng[$key][26] = $cTipe;
                        $vBng[$key][27] = $nDBKB;
                        $xNOP = $vBng[$key][65];
                    }
                }
        }
    }

    function DAYA_DUKUNG_JPB3(){

        global $vBng;
        
        $qb = qb();

        $sql = "Select * FROM DAT_JPB3";

        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                $NOP1 = trim($_dbkb['KD_PROPINSI']) . "." . trim($_dbkb['KD_DATI2']) . "." . trim($_dbkb['KD_KECAMATAN']) . "." . trim($_dbkb['KD_KELURAHAN']) . "." . trim($_dbkb['KD_BLOK']) . "-" . trim($_dbkb['NO_URUT']) . "." . trim($_dbkb['KD_JNS_OP']);

                $NOP2 = $value[1] . "." . $value[2] . "." . $value[3] . "." . $value[4] . "." . $value[5] . "-" . $value[6] . "." . $value[7];
                
                if($NOP1 == $NOP2){

                    $XTIPE = $_dbkb['TYPE_KONSTRUKSI'];
                    $xKOLOM = $_dbkb['TING_KOLOM_JPB3'];
                    $xBENTANG = $_dbkb['LBR_BENT_JPB3'];
                    $xMEZZ = $_dbkb['LUAS_MEZZANINE_JPB3'];
                    $xKELILING = $_dbkb['KELILING_DINDING_JPB3'];
                    $xDUKUNG = $_dbkb['DAYA_DUKUNG_LANTAI_JPB3'];

                    $vBng[$key][44] = $xMEZZ;
                    $vBng[$key][46] = $xDUKUNG;
                    $vBng[$key][48] = $xBENTANG;
                    $vBng[$key][49] = $xKOLOM;
                    $vBng[$key][70] = $xKELILING;

                }
            }
        }
    }

    function CALL_DAYA_DKUNG_JPB3(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT DBKB_DAYA_DUKUNG.KD_PROPINSI, DBKB_DAYA_DUKUNG.KD_DATI2, DBKB_DAYA_DUKUNG.THN_DBKB_DAYA_DUKUNG, DBKB_DAYA_DUKUNG.TYPE_KONSTRUKSI, DAYA_DUKUNG.DAYA_DUKUNG_LANTAI_MIN_DBKB, DAYA_DUKUNG.DAYA_DUKUNG_LANTAI_MAX_DBKB, DBKB_DAYA_DUKUNG.NILAI_DBKB_DAYA_DUKUNG FROM DBKB_DAYA_DUKUNG INNER JOIN DAYA_DUKUNG ON DBKB_DAYA_DUKUNG.TYPE_KONSTRUKSI = DAYA_DUKUNG.TYPE_KONSTRUKSI WHERE DBKB_DAYA_DUKUNG.THN_DBKB_DAYA_DUKUNG='" . $_POST['YEAR'] . "'";

        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if($value[46] * $value[12] >= $_dbkb['DAYA_DUKUNG_LANTAI_MIN_DBKB'] && $value[46] * $value[12] <= $_dbkb['DAYA_DUKUNG_LANTAI_MAX_DBKB']){
                    $nDUKUNG = $_dbkb['NILAI_DBKB_DAYA_DUKUNG'];
                    $vBng[$key][45] = $value[44] * $nMezanin;
                    $vBng[$key][47] = $nDUKUNG * $value[12];
                }
            }
        }
    }

    function DAYA_DUKUNG_JPB8(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "Select * FROM DAT_JPB8";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                $NOP1 = trim($_dbkb['KD_PROPINSI']) . "." . trim($_dbkb['KD_DATI2']) . "." . trim($_dbkb['KD_KECAMATAN']) . "." . trim($_dbkb['KD_KELURAHAN']) . "." . trim($_dbkb['KD_BLOK']) . "-" . trim($_dbkb['NO_URUT']) . "." . trim($_dbkb['KD_JNS_OP']);

                $NOP2 = $value[1] . "." . $value[2] . "." . $value[3] . "." . $value[4] . "." . $value[5] . "-" . $value[6] . "." . $value[7];

                if($NOP1 == $NOP2){
                    $XTIPE = $_dbkb['TYPE_KONSTRUKSI'];
                    $xKOLOM = $_dbkb['TING_KOLOM_JPB8'];
                    $xBENTANG = $_dbkb['LBR_BENT_JPB8'];
                    $xMEZZ = $_dbkb['LUAS_MEZZANINE_JPB8'];
                    $xKELILING = $_dbkb['KELILING_DINDING_JPB8'];
                    $xDUKUNG = $_dbkb['DAYA_DUKUNG_LANTAI_JPB8'];

                    $vBng[$key][44] = $xMEZZ;
                    $vBng[$key][46] = $xDUKUNG ;
                    $vBng[$key][48] = $xBENTANG;
                    $vBng[$key][49] = $xKOLOM;
                    $vBng[$key][70] = $xKELILING;
                }
            }
        }

    }

    function CALL_DBKB_JPB3(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB3 WHERE THN_DBKB_JPB3='". $_POST['YEAR']. "' ORDER BY LBR_BENT_MIN_DBKB_JPB3 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "03" ){
                    if( ($value[48]  >= $_dbkb['LBR_BENT_MIN_DBKB_JPB3'] && $value[48]  <= $_dbkb['LBR_BENT_MAX_DBKB_JPB3'] )&& ($value[49]  >= $_dbkb['TING_KOLOM_MIN_DBKB_JPB3'] && $value[49]  <= $_dbkb['TING_KOLOM_MAX_DBKB_JPB3'] ) ){

                        $nDBKB = $_dbkb['NILAI_DBKB_JPB3'];
                        $vBng[$key][29] = $_dbkb['NILAI_DBKB_JPB3'];

                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB2(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB2 WHERE THN_DBKB_JPB2='" . $_POST['YEAR'] . "' ORDER BY KLS_DBKB_JPB2 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "02" ){
                    if($value[50] == $_dbkb['KLS_DBKB_JPB2'] && ($value[13] >= $_dbkb['LANTAI_MIN_JPB2'] && $value[13] <= $_dbkb['LANTAI_MAX_JPB2']) ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(29).ForeColor = vbRed

                        $vBng[$key][28] = $_dbkb['NILAI_DBKB_JPB2'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB4(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB4 WHERE THN_DBKB_JPB4='" . $_POST['YEAR'] . "' ORDER BY KLS_DBKB_JPB4 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "04" ){
                    if($value[50] == $_dbkb['KLS_DBKB_JPB4'] && ($value[13] >= $_dbkb['LANTAI_MIN_JPB4'] && $value[13] <= $_dbkb['LANTAI_MAX_JPB4']) ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(29).ForeColor = vbRed

                        $vBng[$key][30] = $_dbkb['NILAI_DBKB_JPB4'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB5(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB5 WHERE THN_DBKB_JPB5='" . $_POST['YEAR'] . "' ORDER BY KLS_DBKB_JPB5 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "05" ){
                    if($value[50] == $_dbkb['KLS_DBKB_JPB5'] && ($value[13] >= $_dbkb['LANTAI_MIN_JPB5'] && $value[13] <= $_dbkb['LANTAI_MAX_JPB5']) ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(29).ForeColor = vbRed

                        $vBng[$key][31] = $_dbkb['NILAI_DBKB_JPB5'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB6(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB6 WHERE THN_DBKB_JPB6='" . $_POST['YEAR'] . "' ORDER BY KLS_DBKB_JPB6 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "06" ){
                    if($value[50] == $_dbkb['KLS_DBKB_JPB6']){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(29).ForeColor = vbRed

                        $vBng[$key][32] = $_dbkb['NILAI_DBKB_JPB6'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB7(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB7 WHERE THN_DBKB_JPB7='" . $_POST['YEAR'] . "' ORDER BY JNS_DBKB_JPB7 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "07" ){
                    if($value[50] == $_dbkb['JNS_DBKB_JPB7'] && $value[51] == $_dbkb['BINTANG_DBKB_JPB7'] && ($value[13] >= $_dbkb['BINTANG_DBKB_JPB7'] && $value[13] <= $_dbkb['LANTAI_MAX_JPB7']) ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(29).ForeColor = vbRed

                        $vBng[$key][33] = $_dbkb['NILAI_DBKB_JPB7'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB8(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB8 WHERE THN_DBKB_JPB8='" . $_POST['YEAR'] . "' ORDER BY LBR_BENT_MIN_DBKB_JPB8 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "08" ){

                    if( ($value[48] >= $_dbkb['LBR_BENT_MIN_DBKB_JPB8'] && $value[48] <= $_dbkb['LBR_BENT_MAX_DBKB_JPB8']) && ($value[49] >= $_dbkb['TING_KOLOM_MIN_DBKB_JPB8'] && $value[49] <= $_dbkb['TING_KOLOM_MAX_DBKB_JPB8'])){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(29).ForeColor = vbRed

                        $vBng[$key][34] = $_dbkb['NILAI_DBKB_JPB8'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB9(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB9 WHERE THN_DBKB_JPB9='" . $_POST['YEAR'] . "' ORDER BY KLS_DBKB_JPB9 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "09" ){
                    if($value[50] == $_dbkb['KLS_DBKB_JPB9'] && ($value[13] >= $_dbkb['LANTAI_MIN_JPB9'] && $value[13] <= $_dbkb['LANTAI_MAX_JPB9']) ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(29).ForeColor = vbRed

                        $vBng[$key][35] = $_dbkb['NILAI_DBKB_JPB9'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB12(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB12 WHERE THN_DBKB_JPB12='" . $_POST['YEAR'] . "' ORDER BY TYPE_DBKB_JPB12 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "12" ){
                    if($value[50] == $_dbkb['TYPE_DBKB_JPB12'] ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(212).ForeColor = vbRed

                        $vBng[$key][38] = $_dbkb['NILAI_DBKB_JPB12'];
                    }
                }
            }

        }
    }
    
    function CALL_DBKB_JPB13(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB13 WHERE THN_DBKB_JPB13='" . $_POST['YEAR'] . "' ORDER BY KLS_DBKB_JPB13 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "13" ){
                    if($value[50] == $_dbkb['KLS_DBKB_JPB13'] && ($value[13] >= $_dbkb['LANTAI_MIN_JPB13'] && $value[13] <= $_dbkb['LANTAI_MAX_JPB13']) ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(213).ForeColor = vbRed

                        $vBng[$key][39] = $_dbkb['NILAI_DBKB_JPB13'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB14(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB14 WHERE THN_DBKB_JPB14='" . $_POST['YEAR'] . "'";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "14" ){
                    $vBng[$key][40] = $_dbkb['NILAI_DBKB_JPB14'];
                }
            }

        }
    }

    function CALL_DBKB_JPB15(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB15 WHERE THN_DBKB_JPB15='" . $_POST['YEAR'] . "'";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "15" ){
                    if( ($value[46] >= $_dbkb['KAPASITAS_MIN_DBKB_JPB15'] && $value[46] <= $_dbkb['KAPASITAS_MAX_DBKB_JPB15']) && ($value[45] == $_dbkb['JNS_TANGKI_DBKB_JPB15']) ){
                        $vBng[$key][41] = $_dbkb['NILAI_DBKB_JPB15'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB16(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB16 WHERE THN_DBKB_JPB16='" . $_POST['YEAR'] . "' ORDER BY KLS_DBKB_JPB16 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "16" ){

                    if(($value[13] >= $_dbkb['LANTAI_MIN_JPB16'] && $value[13] <= $_dbkb['LANTAI_MAX_JPB16']) ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(216).ForeColor = vbRed

                        $vBng[$key][42] = $_dbkb['NILAI_DBKB_JPB16'];
                    }
                }
            }

        }
    }

    function CALL_DBKB_JPB17(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_JPB17 WHERE THN_DBKB_JPB17='" . $_POST['YEAR'] . "' ORDER BY TINGGI_MIN_JPB17,TINGGI_MAX_JPB17 ASC";
        $dbkb = $qb->rawQuery($sql)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vBng as $key => $value) {
                if( $value[9] == "17" ){

                    if($value[50] >= $_dbkb['TINGGI_MIN_JPB17'] && $value[14] <= $_dbkb['TINGGI_MAX_JPB17'] ){

                        // If vBng.ListItems.Item(J).ListSubItems(26).Text > 0 Then vBng.ListItems.Item(J).ListSubItems(217).ForeColor = vbRed

                        $vBng[$key][43] = $_dbkb['NILAI_DBKB_JPB17'];
                    }
                }
            }

        }
    }

    function MATERIAL(){
        global $vBng,$nMezanin;
        
        $qb = qb();

        $sql = "SELECT * FROM DBKB_MATERIAL WHERE THN_DBKB_MATERIAL='" . $_POST['YEAR'] . "' ORDER BY KD_PEKERJAAN ASC";
        $material = $qb->rawQuery($sql)->get();

        foreach($material as $_material){
            foreach ($vBng as $key => $value) {

                if( $_material['KD_PEKERJAAN'] == "21" ){
                    $XX1 = $vBng[$key][17];
                    $XX2 = $_material['KD_KEGIATAN'];

                    if( $XX1 <= 3 ){
                        $XX1 = $vBng[$key][17];
                    }else{ 
                        $XX1 = $vBng[$key][17] + 3;
                    }

                    if( $XX1 == $XX2 ){ $vBng[$key][56] = $_material['NILAI_DBKB_MATERIAL']; }

                }

                if( $_material['KD_PEKERJAAN'] == "22" && $vBng[$key][18] == $_material['KD_KEGIATAN'] ){
                    $vBng[$key][57] = $_material['NILAI_DBKB_MATERIAL'];
                }

                if( $_material['KD_PEKERJAAN'] == "23" && $vBng[$key][16] == $_material['KD_KEGIATAN'] ){
                    $jumLT = $vBng[$key][13];

                    if( $jumLT = "" || $jumLT = 0 ){
                        $jumLT = 1;
                    }
                    
                    $vBng[$key][55] = $_material['NILAI_DBKB_MATERIAL'] / $jumLT;
                }

                if( $_material['KD_PEKERJAAN'] == "24" && $vBng[$key][19] == $_material['KD_KEGIATAN'] ){
                    $vBng[$key][58] = $_material['NILAI_DBKB_MATERIAL'];
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
            
            $vBangunan[$key][] = $key;

            $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);
            
            $vBangunan[$key][] = trim($data['KD_PROPINSI']);
            $vBangunan[$key][] = trim($data['KD_DATI2']);
            $vBangunan[$key][] = trim($data['KD_KECAMATAN']);
            $vBangunan[$key][] = trim($data['KD_KELURAHAN']);
            $vBangunan[$key][] = trim($data['KD_BLOK']);
            $vBangunan[$key][] = trim($data['NO_URUT']);
            $vBangunan[$key][] = trim($data['KD_JNS_OP']);
            $vBangunan[$key][] = trim($data['NO_BUMI']);
            $vBangunan[$key][] = trim($data['KD_ZNT']);
            $vBangunan[$key][] = trim($data['NIR']);
            $vBangunan[$key][] = trim($data['LUAS_BUMI']);
            $vBangunan[$key][] = trim($data['JNS_BUMI']);
            $vBangunan[$key][] = trim($data['NIR']) * trim($data['LUAS_BUMI']);
            $vBangunan[$key][] = 0 ;
            $vBangunan[$key][] = 0 ;
            $vBangunan[$key][] = $xNOP;
        
        }

        call_kelas();

    }

    function nilai_bangunan(){
        global $vBng;

        $qb = qb();

        $bangunan = "SELECT * FROM DAT_OP_BANGUNAN WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $results = $qb->rawQuery($bangunan)->get();

        foreach ($results as $key => $data) {
            
            $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);
            
            $vBng[$key][] = $key;
            $vBng[$key][] = trim($data['KD_PROPINSI']);
            $vBng[$key][] = trim($data['KD_DATI2']);
            $vBng[$key][] = trim($data['KD_KECAMATAN']);
            $vBng[$key][] = trim($data['KD_KELURAHAN']);
            $vBng[$key][] = trim($data['KD_BLOK']);
            $vBng[$key][] = trim($data['NO_URUT']);
            $vBng[$key][] = trim($data['KD_JNS_OP']);
            $vBng[$key][] = trim($data['NO_BNG']);
            $vBng[$key][] = trim($data['KD_JPB']);
            $vBng[$key][] = trim($data['THN_DIBANGUN_BNG']);

            $xTahun = trim($data['THN_RENOVASI_BNG']);

            if(is_null($xTahun) || $xTahun == "" || $xTahun == "-"){
                $xTahun = 0;
            }
            
            $vBng[$key][] = $xTahun;
            
            if(is_null($data['LUAS_BNG']) || trim($data['LUAS_BNG']) == ""){
                $vBng[$key][] = 0;
            }else{
                $vBng[$key][] = trim($data['LUAS_BNG']);
            }
            if(is_null($data['JML_LANTAI_BNG']) || trim($data['JML_LANTAI_BNG']) == ""){
                $vBng[$key][] = 0;
                $XLT = 1;
            }else{
                $vBng[$key][] = trim($data['JML_LANTAI_BNG']);
                $XLT = trim($data['JML_LANTAI_BNG']);
            }
            if(is_null($data['KONDISI_BNG']) || trim($data['KONDISI_BNG']) == ""){
                $vBng[$key][] = 0;
            }else{
                $vBng[$key][] = trim($data['KONDISI_BNG']);
            }
            if(is_null($data['JNS_KONSTRUKSI_BNG']) || trim($data['JNS_KONSTRUKSI_BNG']) == ""){
                $vBng[$key][] = 0;
            }else{
                $vBng[$key][] = trim($data['JNS_KONSTRUKSI_BNG']);
            }
            if(is_null($data['JNS_ATAP_BNG']) || trim($data['JNS_ATAP_BNG']) == ""){
                $vBng[$key][] = 0;
            }else{
                $vBng[$key][] = trim($data['JNS_ATAP_BNG']);
            }
            if(is_null($data['KD_DINDING']) || trim($data['KD_DINDING']) == ""){
                $vBng[$key][] = 0;
            }else{
                $vBng[$key][] = trim($data['KD_DINDING']);
            }
            if(is_null($data['KD_LANTAI']) || trim($data['KD_LANTAI']) == ""){
                $vBng[$key][] = 0;
            }else{
                $vBng[$key][] = trim($data['KD_LANTAI']);
            }
            if(is_null($data['KD_LANGIT_LANGIT']) || trim($data['KD_LANGIT_LANGIT']) == ""){
                $vBng[$key][] = 0;
            }else{
                $vBng[$key][] = trim($data['KD_LANGIT_LANGIT']);
            }

            $vBng[$key][] = $data['NILAI_SISTEM_BNG'];
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            
            $vBng[$key][] = 0;
            
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = "SISTEM";
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            
            $vBng[$key][] = $data['NO_FORMULIR_LSPOP'];
            $vBng[$key][] = $data['JNS_TRANSAKSI_BNG'];

            if(is_null($data['NIP_PENDATA_BNG']) || $data['NIP_PENDATA_BNG'] = "" ) $data['NIP_PENDATA_BNG'] = "-";
            if(is_null($data['NIP_PEMERIKSA_BNG']) || $data['NIP_PEMERIKSA_BNG'] = "" ) $data['NIP_PEMERIKSA_BNG'] = "-";
            if(is_null($data['NIP_PEREKAM_BNG']) || $data['NIP_PEREKAM_BNG'] = "" ) $data['NIP_PEREKAM_BNG'] = "-";


            $vBng[$key][] = $data['TGL_PENDATAAN_BNG'];
            $vBng[$key][] = $data['NIP_PENDATA_BNG'];
            $vBng[$key][] = $data['TGL_PEMERIKSAAN_BNG'];
            $vBng[$key][] = $data['NIP_PEMERIKSA_BNG'];
            $vBng[$key][] = $data['TGL_PEREKAMAN_BNG'];
            $vBng[$key][] = $data['NIP_PEREKAM_BNG'];
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;
            $vBng[$key][] = 0;

        }

        CALL_DBKB_STANDARD();
        DAYA_DUKUNG_JPB3();
        CALL_DAYA_DKUNG_JPB3();
        DAYA_DUKUNG_JPB8();
        CALL_DBKB_JPB3();
        CALL_DBKB_JPB2();
        CALL_DBKB_JPB4();
        CALL_DBKB_JPB5();
        CALL_DBKB_JPB6();
        CALL_DBKB_JPB7();
        CALL_DBKB_JPB8();
        CALL_DBKB_JPB9();
        CALL_DBKB_JPB12();
        CALL_DBKB_JPB13();
        CALL_DBKB_JPB14();
        CALL_DBKB_JPB15();
        CALL_DBKB_JPB16();
        CALL_DBKB_JPB17();
        MATERIAL();
    }

    function nilai_fasilitas(){
        global $vFAS;

        $qb = qb();

        $sql = "SELECT * FROM DAT_FASILITAS_BANGUNAN WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $results = $qb->rawQuery($sql)->get();

        foreach ($results as $key => $data) {

            $vFAS[$key][] = $key;
            
            $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);

            $vFAS[$key][] = trim($data['KD_PROPINSI']);
            $vFAS[$key][] = trim($data['KD_DATI2']);
            $vFAS[$key][] = trim($data['KD_KECAMATAN']);
            $vFAS[$key][] = trim($data['KD_KELURAHAN']);
            $vFAS[$key][] = trim($data['KD_BLOK']);
            $vFAS[$key][] = trim($data['NO_URUT']);
            $vFAS[$key][] = trim($data['KD_JNS_OP']);
            $vFAS[$key][] = trim($data['NO_BNG']);
            $vFAS[$key][] = trim($data['KD_FASILITAS']);
            $vFAS[$key][] = trim($data['JML_SATUAN']);
            
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
            $vFAS[$key][] = 0;
        }
    }

    function dbkb_fas1a(){
       global $vFAS;

       $qb = qb();

        $dbkb_fas1a = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_NON_DEP.NILAI_NON_DEP, FAS_NON_DEP.THN_NON_DEP FROM FASILITAS INNER JOIN FAS_NON_DEP ON FASILITAS.KD_FASILITAS = FAS_NON_DEP.KD_FASILITAS WHERE FAS_NON_DEP.THN_NON_DEP='" . $_POST['YEAR'] . "' ";

        $dbkb = $qb->rawQuery($dbkb_fas1a)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vFAS as $key => $value) {
                if($vFAS[$key][9] == $_dbkb['KD_FASILITAS']){
                    $vFAS[$key][11] = $_dbkb['NILAI_NON_DEP'];

                    if($vFAS[$key][9] == 44){
                        $vFAS[$key][11] = $_dbkb["NILAI_NON_DEP"] / 1000;
                    }
    
                    if($_dbkb["KD_FASILITAS"] == "01" || $_dbkb["KD_FASILITAS"] == "02" || $_dbkb["KD_FASILITAS"] == "11" || $_dbkb["KD_FASILITAS"] == "44"){
                        $vFAS[$key][12] = $vFAS[$key][10] * $vFAS[$key][11];
                    }else{
                        $vFAS[$key][14] = $vFAS[$key][10] * $vFAS[$key][11];
                        $vFAS[$key][18] = $vFAS[$key][11];
                    }
                }

            }
        }
    }

    function dbkb_fas2a(){
        global $vFAS;

        $qb = qb();

        $dbkb_fas2a = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_DEP_JPB_KLS_BINTANG.KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.NILAI_FASILITAS_KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG FROM FASILITAS INNER JOIN FAS_DEP_JPB_KLS_BINTANG ON FASILITAS.KD_FASILITAS = FAS_DEP_JPB_KLS_BINTANG.KD_FASILITAS WHERE FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG='" . $_POST['YEAR'] . "'";

        $dbkb = $qb->rawQuery($dbkb_fas2a)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vFAS as $key => $value) {

                if($vFAS[$key][9] == $_dbkb['KD_FASILITAS']){

                    if($vFAS[$key][10] == trim($_dbkb['KLS_BINTANG'])){
                        $vFAS[$key][11] = $_dbkb['NILAI_FASILITAS_KLS_BINTANG'];

                        if($vFAS[$key][9] == "03" || $vFAS[$key][9] == "04" || $vFAS[$key][9] == "06" || $vFAS[$key][9] == "07" || $vFAS[$key][9] == "03"){
                            $vFAS[$key][15] = $vFAS[$key][11];
                        }elseif($vFAS[$key][9] == "05" || $vFAS[$key][9] == "08" || $vFAS[$key][9] == "10"){
                            $vFAS[$key][16] = $vFAS[$key][11];
                        }else{
                            $vFAS[$key][17] = $vFAS[$key][11];
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

        $dbkb = $qb->rawQuery($dbkb_fas3a)->get();

        foreach($dbkb as $_dbkb){
            foreach ($vFAS as $key => $value) {

                if($vFAS[$key][9] == $_dbkb['KD_FASILITAS']){
                    
                    if($vFAS[$key][10] >= $_dbkb['KLS_DEP_MIN'] && $vFAS[$key][10] <= $_dbkb['KLS_DEP_MAX']){
                        $vFAS[$key][11] = $_dbkb['NILAI_DEP_MIN_MAX'];
                    }
    
                    if($_dbkb["KD_FASILITAS"] == "40"){
                        $vFAS[$key][12] = $vFAS[$key][10] * $vFAS[$key][11];
                    }else{
                        $vFAS[$key][14] = $vFAS[$key][10] * $vFAS[$key][11];
                        $vFAS[$key][18] = $vFAS[$key][11];
                    }
                }

            }
        }
    }

    function nilai_individu(){
        global $vBng;

        $qb = qb();

        $nilai_individu = "SELECT * FROM DAT_NILAI_INDIVIDU";

        $kt = $qb->rawQuery($nilai_individu)->get();

        foreach($kt as $_kt){
            
            foreach ($vBng as $key => $value) {
                $NOP1 = trim($_kt['KD_PROPINSI']). ".". trim($_kt['KD_DATI2']). ".". trim($_kt['KD_KECAMATAN']). ".". trim($_kt['KD_KELURAHAN']). ".". trim($_kt['KD_BLOK']). "-". trim($_kt['NO_URUT']). ".". trim($_kt['KD_JNS_OP']);

                $NOP2 = $value[1]. ".". $value[2]. ".". $value[3]. ".". $value[4]. ".". $value[5]. "-". $value[6]. ".". $value[7];
                 
                if ($NOP1 == $NOP2 && trim($_kt['NO_BNG']) == $value[8] ){
                    $vBng[$key][79] = $_kt['NILAI_INDIVIDU'];
                    $vBng[$key][68] = "INDIVIDU";
                }
            }

        }

    }

    function call_op(){

        global $vBangunan,$vBng,$vOP,$xTB;

        $qb = qb();

        foreach ($vBangunan as $key => $value) {
            $vOP[$key][] = $key;
            $vOP[$key][] = $value[1];
            $vOP[$key][] = $value[2];
            $vOP[$key][] = $value[3];
            $vOP[$key][] = $value[4];
            $vOP[$key][] = $value[5];
            $vOP[$key][] = $value[6];
            $vOP[$key][] = $value[7];
            $vOP[$key][] = $value[16];
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = "SISTEM";
            $vOP[$key][] = 0;
            $vOP[$key][] = $value[12];
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;
            $vOP[$key][] = 0;

            
            $NOP1 = $vOP[$key][1] . "." .$vOP[$key][2] . "." .$vOP[$key][3] . "." .$vOP[$key][4] . "." .$vOP[$key][5] . "-" .$vOP[$key][6] . "." .$vOP[$key][7];
                
            $vOP[$key][9] = $value[11];
            $vOP[$key][10] = $value[14];
            $vOP[$key][11] = $value[15]; 
            
            $QJum1 = 0; 
            $QJum2 = 0;
            $QJum3 = 0;
            $xKet = "SISTEM";

            foreach ($vBng as $k => $v) {
                if($vOP[$key][8] == $v[63]){
                    
                    $QJum1 = $QJum1 + $v[12];

                    if($v[68] = "INDIVIDU" ){
                        $QJum2 = $QJum2 + $v[79];
                    }else{
                        $QJum2 = $QJum2 + $v[62];
                    }

                    $QJum3 = $QJum3 + $v[23];

                    $xKet = $v[68];
                    $vOP[$key][18] = $v[9];
                }
            }

            $vOP[$key][12] = $QJum1;
            $vOP[$key][13] = number_format($QJum2, 2);
            $vOP[$key][17] = $xKet;
        }

        $kb = "SELECT * FROM KELAS_BANGUNAN WHERE THN_AWAL_KLS_BNG ='" . $xTB . "'";
        $kb_single = $qb->rawQuery($kb)->get();

        foreach($kb_single as $_kb_single){
            foreach ($vOP as $key => $value) {
                if($vOP[$key][13] != 0 || $vOP[$key][12] != 0){
                    if($vOP[$key][13] / $vOP[$key][12] >= $_kb_single['NILAI_MIN_BNG'] && $vOP[$key][13] / $vOP[$key][12] >= $_kb_single['NILAI_MAX_BNG']){
                        $vOP[$key][14] = $_kb_single['KD_KLS_BNG'];
                        $vOP[$key][15] = $_kb_single['NILAI_PER_M2_BNG'];

                        $vOP[$key][16] = $_kb_single['NILAI_PER_M2_BNG'] * $vOP[$key][12] * 1000;
                        
                    }
                }

                if($vOP[$key][13] <= 0){
                    $vOP[$key][16] = 0;
                }

                $vOP[$key][30] = $vOP[$key][11]+ $vOP[$key][16];

                if($vOP[$key][30] * 1 >= $ccMin[0] And $vOP[$key][30] * 1 <= $ccMax[0] ){
                    $vOP[$key][31] = $ccTarif[0];
                    $vOP[$key][32] = $ccTKP[0];
                }else{
                    $vOP[$key][31] = $ccTarif[1];
                    $vOP[$key][32] = $ccTKP[1];
                }

                if($vOP[$key][19] != 1 || $vOP[$key][16] == 0 ) $vOP[$key][32] = 0;
                $vOP[$key][33] = $PBBMin;
                $vOP[$key][34] = ($vOP[$key][30] - $vOP[$key][32]) * ($vOP[$key][31] / 100);

                if($vOP[$key][34] < 0) $vOP[$key][34] = 0;
            }
        }

        $Q_SPPT = "SELECT * FROM QOBJEKPAJAK WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "' ORDER BY NOPQ ASC";

        $SPPTs = $qb->rawQuery($Q_SPPT)->get();

        foreach ($SPPTs as $key => $SPPT) {
            if($SPPT && $vOP){
                foreach ($vOP as $key => $value) {
                    if($SPPT['NOPQ'] == $vOP[$key][8]){
                        if(is_null($SPPT['NM_WP'])){
                            $vOP[$key][20] = "";
                        }else{
                            $vOP[$key][20] = $SPPT['NM_WP'];
                        }
    
                        if(is_null($SPPT['JALAN_WP'])){
                            $vOP[$key][21] = "-";
                        }else{
                            $vOP[$key][21] = $SPPT['JALAN_WP'];
                        }
    
                        if(is_null($SPPT['BLOK_KAV_NO_WP'])){
                            $vOP[$key][22] = "00";
                        }else{
                            $vOP[$key][22] = $SPPT['BLOK_KAV_NO_WP'];
                        }
    
                        if(is_null($SPPT['RW_WP'])){
                            $vOP[$key][23] = "00";
                        }else{
                            $vOP[$key][23] = $SPPT['RW_WP'];
                        }
    
                        if(is_null($SPPT['RT_WP'])){
                            $vOP[$key][24] = "00";
                        }else{
                            $vOP[$key][24] = $SPPT['RT_WP'];
                        }
    
                        if(is_null($SPPT['KELURAHAN_WP'])){
                            $vOP[$key][25] = "-";
                        }else{
                            $vOP[$key][25] = $SPPT['KELURAHAN_WP'];
                        }
    
                        if(is_null($SPPT['KOTA_WP'])){
                            $vOP[$key][26] = "-";
                        }else{
                            $vOP[$key][26] = $SPPT['KOTA_WP'];
                        }
    
                        if(is_null($SPPT['KD_POS_WP'])){
                            $vOP[$key][27] = "00000";
                        }else{
                            $vOP[$key][27] = $SPPT['KD_POS_WP'];
                        }
    
                        if(is_null($SPPT['NPWP'])){
                            $vOP[$key][28] = "-";
                        }else{
                            $vOP[$key][28] = $SPPT['NPWP'];
                        }
    
                        if(is_null($SPPT['NO_PERSIL'])){
                            $vOP[$key][29] = "00";
                        }else{
                            $vOP[$key][29] = $SPPT['NO_PERSIL'];
                        }
    
                        if(is_null($SPPT['SUBJEK_PAJAK_ID'])){
                            $vOP[$key][35] = "";
                        }else{
                            $vOP[$key][35] = $SPPT['SUBJEK_PAJAK_ID'];
                        }
    
                        $vOP[$key][36] = $SPPT['NO_FORMULIR_SPOP'];
                        $vOP[$key][37] = $SPPT['KD_STATUS_WP'];
                        $vOP[$key][38] = $SPPT['JNS_TRANSAKSI_OP'];
    
                        if(is_null($SPPT['NIP_PENDATA']) || $SPPT['NIP_PENDATA'] == "" ){
                            $SPPT['NIP_PENDATA'] = "-";
                        }
    
                        if(is_null($SPPT['NIP_PEMERIKSA_OP']) || $SPPT['NIP_PEMERIKSA_OP'] == "" ){
                            $SPPT['NIP_PEMERIKSA_OP'] = "-";
                        }
    
                        if(is_null($SPPT['NIP_PEREKAM_OP']) || $SPPT['NIP_PEREKAM_OP'] == "" ){
                            $SPPT['NIP_PEREKAM_OP'] = "-";
                        }
    
                        $vOP[$key][39] = $SPPT['TGL_PENDATAAN_OP'];
                        $vOP[$key][40] = $SPPT['NIP_PENDATA'];
                        $vOP[$key][41] = $SPPT['TGL_PEMERIKSAAN_OP'];
                        $vOP[$key][42] = $SPPT['NIP_PEMERIKSA_OP'];
                        $vOP[$key][43] = $SPPT['TGL_PEREKAMAN_OP'];
                        $vOP[$key][44] = $SPPT['NIP_PEREKAM_OP'];
    
                        if(is_null($SPPT['JALAN_OP'])){
                            $vOP[$key][45] = "-";
                        }else{
                            $vOP[$key][45] = $SPPT['JALAN_OP'];
                        }
    
                        if(is_null($SPPT['BLOK_KAV_NO_OP'])){
                            $vOP[$key][46] = "00";
                        }else{
                            $vOP[$key][46] = $SPPT['BLOK_KAV_NO_OP'];
                        }
    
                        if(is_null($SPPT['RW_OP'])){
                            $vOP[$key][47] = "00";
                        }else{
                            $vOP[$key][47] = $SPPT['RW_OP'];
                        }
    
                        if(is_null($SPPT['RT_OP'])){
                            $vOP[$key][48] = "00";
                        }else{
                            $vOP[$key][48] = $SPPT['RT_OP'];
                        }
    
                   }
                }
            }
        }

    }

    function sv_bumi(){
        global $vBangunan;

        $qb = qb();

        $sv_bumi = "Select * From DAT_OP_BUMI WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $datas = $qb->rawQuery($sv_bumi)->get();

        foreach ($datas as $key => $data) {

            if($data && $vBangunan){
                
                // foreach ($vBangunan as $key => $value) {
    
                    $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);
    
                    if($data['NO_BUMI'] == $vBangunan[0][8] && $xNOP == $vBangunan[0][16]){
    
                        $new_data = [];
    
                        $new_data['LUAS_BUMI'] = $vBangunan[0][11];
                        $new_data['JNS_BUMI'] = $vBangunan[0][12];
                        $new_data['NILAI_SISTEM_BUMI'] = $vBangunan[0][13];
    
                        $upd = $qb->update("DAT_OP_BUMI",$new_data)->where("KD_KECAMATAN",$_POST['KD_KECAMATAN'])->where("KD_KELURAHAN",$_POST['KD_KELURAHAN'])->where('KD_BLOK',$data['KD_BLOK'])->where('NO_URUT',$data['NO_URUT'])->where('KD_JNS_OP',$data['KD_JNS_OP'])->exec();
    
                    }
                // }
            }

        }

    }

    function sv_bangunan(){
        global $vBng;

        $qb = qb();

        $sv_bangunan = "Select * From DAT_OP_BANGUNAN WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";

        $datas = $qb->rawQuery($sv_bangunan)->get();

        foreach ($datas as $key => $data) {
            
            if($data && $vBng){
                // foreach ($vBng as $key => $value) {
                    $xNOP = trim($data['KD_PROPINSI']) . "." . trim($data['KD_DATI2']) . "." . trim($data['KD_KECAMATAN']) . "." . trim($data['KD_KELURAHAN']) . "." . trim($data['KD_BLOK']) . "-" . trim($data['NO_URUT']) . "." . trim($data['KD_JNS_OP']);
    
                    if($vBng[0][63] == $xNOP && $data['NO_BNG'] == $vBng[0][8] && $data['KD_JPB'] == $vBng[0][9]){
                        $new_data = [];
                        $new_data['K_UTAMA'] = $vBng[0][80];
                        $new_data['K_MATERIAL'] = $vBng[0][81];
                        $new_data['K_FASILITAS'] = $vBng[0][82];
                        $new_data['J_SUSUT'] = $vBng[0][83];
                        $new_data['K_SUSUT'] = $vBng[0][84];
                        $new_data['K_NON_SUSUT'] = $vBng[0][85];
                        $new_data['NILAI_SISTEM_BNG'] = $vBng[0][62];
    
                        $upd = $qb->update("DAT_OP_BANGUNAN",$new_data)->where("KD_KECAMATAN",$_POST['KD_KECAMATAN'])->where("KD_KELURAHAN",$_POST['KD_KELURAHAN'])->where('KD_BLOK',$data['KD_BLOK'])->where('NO_URUT',$data['NO_URUT'])->where('KD_JNS_OP',$data['KD_JNS_OP'])->exec();
                    }
                // }
            }
            
        }

    }

    function sv_individu(){
        global $vBng;

        $qb = qb();

        $sv_individu = "Select * From DAT_NILAI_INDIVIDU WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";
        
        $data = $qb->rawQuery($sv_individu)->get();

        foreach($data as $_data){
            // foreach ($vBng as $key => $value) {

                $xNOP = trim($_data['KD_PROPINSI']) . "." . trim($_data['KD_DATI2']) . "." . trim($_data['KD_KECAMATAN']) . "." . trim($_data['KD_KELURAHAN']) . "." . trim($_data['KD_BLOK']) . "-" . trim($_data['NO_URUT']) . "." . trim($_data['KD_JNS_OP']);

                if($vBng[0][64] == $xNOP && $_data['NO_BNG'] == $vBng[0][9]){
                    $_data['NILAI_INDIVIDU'] = $vBng[0][80];

                    $upd = $qb->update("DAT_NILAI_INDIVIDU",$_data)->where("KD_KECAMATAN",$_POST['KD_KECAMATAN'])->where("KD_KELURAHAN",$_POST['KD_KELURAHAN'])->where('KD_BLOK',$_data['KD_BLOK'])->where('NO_URUT',$_data['NO_URUT'])->where('KD_JNS_OP',$_data['KD_JNS_OP'])->exec();
                }
            // }
        }
    
    }

    function sv_objek(){
        global $vOP,$ccProses,$xTT,$xTB;
        
        $qb = qb();

        if($vOP){
            $b_sv_objek = "B_OP '" . $ccProses . "','" . $_POST['KD_KECAMATAN'] . "','" . $_POST['KD_KELURAHAN'] . "'";
            // $sv_objek = "Select * From DAT_OBJEK_PAJAK WHERE KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "'";
            $qb->rawQuery($b_sv_objek)->exec();
        }
        
        foreach ($vOP as $key => $value) {
            $data = [];
            $data['KD_PROPINSI'] = $value[1];
            $data['KD_DATI2'] = $value[2];
            $data['KD_KECAMATAN'] = $value[3];
            $data['KD_KELURAHAN'] = $value[4];
            $data['KD_BLOK'] = $value[5];
            $data['NO_URUT'] = $value[6];
            $data['KD_JNS_OP'] = $value[7];

            $data['NO_PERSIL'] = $value[29];
            $data['SUBJEK_PAJAK_ID'] = $value[35];
            $data['NO_FORMULIR_SPOP'] = $value[36];
            $data['JALAN_OP'] = $value[45];
            $data['BLOK_KAV_NO_OP'] = $value[46];
            $data['RW_OP'] = $value[47];
            $data['RT_OP'] = $value[48];
            $data['KD_STATUS_CABANG'] = 0;
            $data['KD_STATUS_WP'] = $value[37];

            $data['TOTAL_LUAS_BUMI'] = $value[9];
            $data['TOTAL_LUAS_BNG'] = $value[12];
            $data['NJOP_BUMI'] = $value[11];
            $data['NJOP_BNG'] = $value[16];

            $data['STATUS_PETA_OP'] = 1;
            $data['JNS_TRANSAKSI_OP'] = $value[38];
            $data['TGL_PENDATAAN_OP'] = !empty($value[39]) ? $value[39]->format("Y-m-d\TH:i:s") : (new DateTime)->format("Y-m-d\TH:i:s");
            $data['NIP_PENDATA'] = $value[40];
            $data['TGL_PEMERIKSAAN_OP'] = !empty($value[41]) ? $value[41]->format("Y-m-d\TH:i:s") : (new DateTime)->format("Y-m-d\TH:i:s");
            $data['NIP_PEMERIKSA_OP'] = $value[42];
            $data['TGL_PEREKAMAN_OP'] = !empty($value[43]) ? $value[43]->format("Y-m-d\TH:i:s") : (new DateTime)->format("Y-m-d\TH:i:s");
            $data['NIP_PEREKAM_OP'] = $value[44];

            $qb->create("DAT_OBJEK_PAJAK",$data)->exec();

            $xxProp = $value[1];
            $xxKab = $value[2];
            $xxKec = $value[3];
            $xxKel = $value[4];
            $xxBlok = $value[5];
            $xxUrut = $value[6];
            $xxJenis = $value[7];
            $xNOP1 = $xxProp . "." . $xxKab . "." . $xxKec . "." . $xxKel . "." . $xxBlok . "-" . $xxUrut . "." . $xxJenis;
            $xxKelas1 = $value[10];
            $xxKelas2 = $value[14];
            $xxJatuh = (new DateTime)->format("Y-m-d\TH:i:s");
            $LBumi = $value[9];
            $LBng = $value[12];
            $NBumi = $value[11];
            $NBng = $value[16];
            $t_NJOP = $value[30];


            $xNJOPTKP = $value[32];
            $xNJKP = 0;
            $xxPBBMin = $value[33];
            $xHutang = $value[34];
            $xKurang = 0;
            $xBayar = $xHutang - $xKurang;

            if($xBayar < $xxPBBMin) $xBayar = $xxPBBMin;

            if($value[19] != "4" ){

                $new_data = [];
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

                
                $qb->create("SPPT",$new_data)->exec();

            }
        }
    }

    function Call_Susut(){

        global $vBng,$ck_Ulin;

        $qb = qb();
        
        $StrQ = "SELECT PENYUSUTAN.KD_RANGE_PENYUSUTAN, PENYUSUTAN.UMUR_EFEKTIF, PENYUSUTAN.KONDISI_BNG_SUSUT, RANGE_PENYUSUTAN.NILAI_MIN_PENYUSUTAN, RANGE_PENYUSUTAN.NILAI_MAX_PENYUSUTAN, PENYUSUTAN.NILAI_PENYUSUTAN FROM PENYUSUTAN INNER JOIN RANGE_PENYUSUTAN ON PENYUSUTAN.KD_RANGE_PENYUSUTAN = RANGE_PENYUSUTAN.KD_RANGE_PENYUSUTAN ORDER BY PENYUSUTAN.UMUR_EFEKTIF";
        
        $data = $qb->rawQuery($StrQ)->get();

        foreach($data as $_data){
            foreach ($vBng as $key => $value) {
                $JGuna = $value[9];

                if( $JGuna == 3){
                    $nMaterial1 = (($value[58]) + ($value[57]) + ($value[55])) * 1.3 * $value[12];

                    $nMaterial2 = $value[12] * $value[70] * $value[49] * (10 / 6) * $value[56] * 1.3;

                    $nMaterial = $nMaterial1 + $nMaterial2;
                }
                elseif( $JGuna == 8){
                    $nMaterial1 = (($value[58]) + ($value[57]) + ($value[55])) * $value[12];
                    $nMaterial2 = $value[12] * $value[70] * $value[49] * (10 / 6) * $value[56];
                    $nMaterial = $nMaterial1 + $nMaterial2;
                }
                else{
                    $nMaterial = (($value[58]) + ($value[57]) + ($value[56]) + ($value[55])) * $value[12];
                }

                $nMez_DDukung = $value[45] + $value[47];
            
                if($value[9] == "02" || $value[9] == "04" ){
                    $nAC = ($value[65] * $value[12]) ;
                }
                else{
                    $nAC = ($value[65] * $value[53]) + ($value[66] * $value[54]);
                }

                $nBoiler = $value[67] * $value[52];

                $JPB1 = $vBng[$key][27];
            
                $JPB2 = $vBng[$key][28];
            
                $JPB3 = $vBng[$key][29];
            
                $JPB4 = $vBng[$key][30];
            
                $JPB5 = $vBng[$key][31];
            
                $JPB6 = $vBng[$key][32];
            
                $JPB7 = $vBng[$key][33];
            
                $JPB8 = $vBng[$key][34];
            
                $JPB9 = $vBng[$key][35];
            
                $JPB10 = $vBng[$key][36];
            
                $JPB11 = $vBng[$key][37];
            
                $JPB12 = $vBng[$key][38];
            
                $JPB13 = $vBng[$key][39];
            
                $JPB14 = $vBng[$key][40];
            
                $JPB15 = $vBng[$key][41];
            
                $JPB16 = $vBng[$key][42];
            
                $JPB17 = $vBng[$key][43];

                $nSistem_B4_Susut = ($JPB1 + $JPB2 + $JPB3 + $JPB4 + $JPB5 + $JPB6 + $JPB7 + $JPB8 + $JPB9 + $JPB10 + $JPB11 + $JPB12 + $JPB13 + $JPB14 + $JPB15 + $JPB16 + $JPB17) * $vBng[$key][12];
                
                $vBng[$key][64] = ($JPB1 + $JPB2 + $JPB3 + $JPB4 + $JPB5 + $JPB6 + $JPB7 + $JPB8 + $JPB9 + $JPB10 + $JPB11 + $JPB12 + $JPB13 + $JPB14 + $JPB15 + $JPB16 + $JPB17);

                $TPajak = $_POST['YEAR'];
                $TBangun = $vBng[$key][10];
                $TRenovasi = $vBng[$key][11];
                
                $JLANTAI = $vBng[$key][13];

                if( ($JGuna == 1 || $JGuna == 3 || $JGuna == 8 || $JGuna == 10 || $JGuna == 11 || $JGuna == 2 || $JGuna == 4 || $JGuna == 5 || $JGuna == 7 || $JGuna == 9) && $JLANTAI <= 4 ){
                    if( $TRenovasi > 0 ){
                        $Umur = $TPajak - $TRenovasi;
                    }else{
                        $Umur = $TPajak - $TBangun;
                    }
                    
                }else{
                    if( $TBangun > 0 && $TRenovasi > 0 ){
                        if( $TPajak - $TBangun > 10 ){
                            $Umur = (($TPajak - $TBangun) + (2 * 10)) / 3;
                        }else{
                            $Umur = (($TPajak - $TBangun) + 2 * ($TPajak - $TRenovasi)) / 3;
                        }
                    }else{ 
                        if( $TPajak - $TBangun > 10 ){
                            $Umur = (($TPajak - $TBangun) + (2 * 10)) / 3;
                        }else{
                            $Umur = $TPajak - $TBangun;
                        }
                    }
                    $nMaterial = 0;
                }

                if( $Umur > 40 ){
                    $Umur = 40;
                }

                $umur_EFF = round($Umur);
        
                if( $value[15] == 4 && $ck_Ulin == 0 ){
                    $nSistem_B4_Susut = $nSistem_B4_Susut * 0.7;
                }
                $n_Fas1 = $value[59];
                $n_Fas2 = $value[60];
                $s_Fas2 = $value[69];

                if( $vBng[$key][44] == 0 || $vBng[$key][44] == "" ){
                    $xxMez = 0;
                }else{ 
                    $xxMez = $vBng[$key][45] / $vBng[$key][44];
                }
                
                $xxDD = $vBng[$key][47];
                
                $nBaru = (($nMaterial + $xxDD + $nSistem_B4_Susut) / $vBng[$key][12]) + $xxMez + $s_Fas2;
                
                if( $nBaru * 1000 >= $_data['NILAI_MIN_PENYUSUTAN'] && $nBaru * 1000 <= $_data['NILAI_MAX_PENYUSUTAN'] ){
                    if( ($vBng[$key][14] = $_data['KONDISI_BNG_SUSUT']) && ($umur_EFF = $_data['UMUR_EFEKTIF']) ){   
                        $vBng[$key][61] = $_data['NILAI_PENYUSUTAN'];
                    }
                }

                $nSusut = $vBng[$key][62];
                
                if( $nSusut > 50 && $vBng[$key][9] == "15" ){
                    $nSusut = 50;
                }
                
                
                $xSistem1 = $nMaterial + $nMez_DDukung + $nSistem_B4_Susut + $n_Fas2 + $n_Fas1 + $nAC + $nBoiler;
                $xSistem2 = ($nMaterial + $xxDD + $nSistem_B4_Susut + $n_Fas2) * ($nSusut / 100) ;
                $vBng[$key][62] = $xSistem1 - $xSistem2;
                $vBng[$key][80] = $nMez_DDukung + $nSistem_B4_Susut ;
                $vBng[$key][81] = $nMaterial;
                $vBng[$key][82] = $n_Fas2 ;
                $vBng[$key][83] = $nSusut ;
                $vBng[$key][84] = $xSistem2; 
                $vBng[$key][85] = $n_Fas1 + $nAC + $nBoiler ;
            }
        }

    }

    function NFAS(){
        global $vBng,$vFAS;

        $cJum = 0;
        $nMaterial = 0;
        $nMez_DDukung = 0;
        $cJum1 = 0;
        $cJum2 = 0;
        $cJum3 = 0;
        $cJum4 = 0;
        $s_FJ = 0;

        foreach($vFAS as $key => $value){
            $NOP1 = $value[1] . "." . $value[2] . "." . $value[3] . "." . $value[4] . "." . $value[5] . "-" . $value[6] . "." . $value[7];

            $vFAS[$key][13] = $NOP1;
        }
        
        foreach($vBng as $key => $value){
            $NOP2 = $value[1] . "." . $value[2] . "." . $value[3] . "." . $value[4] . "." . $value[5] . "-" . $value[6] . "." . $value[7];

            $vBng[$key][63] = $NOP2;

            foreach($vFAS as $key2 => $value2){
                if( ($value[64] == $value2[14]) && ($value[9] == $value2[9]) ){
                    $cJum = $cJum + ($value2[13]);
                    $cJum1 = $cJum1 + ($value2[15]);
                    $cJum2 = $cJum2 + ($value2[16]);
                    $cJum3 = $cJum3 + ($value2[17]);
                    $cJum4 = $cJum4 + ($value2[18]);
                    $s_FJ = $s_FJ + ($value2[19]);
                }
            }

            $vBng[$key][59] = $cJum;
            $vBng[$key][60] = $cJum1;
            $vBng[$key][65] = $cJum2;
            $vBng[$key][66] = $cJum3;
            $vBng[$key][67] = $cJum4;
            $vBng[$key][69] = $s_FJ;
            
        }

        Call_Susut();
    }

    function TIDAK_KENA_PAJAK(){
        global $vBng;

        foreach ($vBng as $key => $value) {
            if( trim($vBng[$key][10]) == 11 ){
                $vBng[$key][63] = 0;
            }
        }
    }