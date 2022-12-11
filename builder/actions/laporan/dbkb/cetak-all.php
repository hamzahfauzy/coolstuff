<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$C_STR = "";

if($type == "bangunan_standard"){
    $C_STR = "SELECT DBKB_STANDARD.*, TIPE_BANGUNAN.LUAS_MIN_TIPE_BNG, TIPE_BANGUNAN.LUAS_MAX_TIPE_BNG, DBKB_STANDARD.THN_DBKB_STANDARD, REF_JPB.NM_JPB FROM (DBKB_STANDARD INNER JOIN TIPE_BANGUNAN ON DBKB_STANDARD.TIPE_BNG = TIPE_BANGUNAN.TIPE_BNG) INNER JOIN REF_JPB ON DBKB_STANDARD.KD_JPB = REF_JPB.KD_JPB WHERE DBKB_STANDARD.THN_DBKB_STANDARD='" . $tahun_pajak . "' ORDER BY DBKB_STANDARD.KD_BNG_LANTAI,DBKB_STANDARD.KD_JPB";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = $value['NM_JPB'];
        $datas[$key]["LUAS"] = $value['LUAS_MIN_TIPE_BNG'] . " s.d " . $value['LUAS_MAX_TIPE_BNG'];

        $lantai = substr($value['KD_BNG_LANTAI'],2,1);

        $datas[$key]["LANTAI"] = $lantai == 1 ? 1 : "2 s.d 4";
        $datas[$key]["NJOP"] = $value["NILAI_DBKB_STANDARD"];
    }
}

if($type == "perkantoran_swasta"){
    $C_STR = "SELECT * FROM DBKB_JPB2 where THN_DBKB_JPB2='" . $tahun_pajak . "' ORDER BY LANTAI_MAX_JPB2 ASC, LANTAI_MIN_JPB2 ASC,KLS_DBKB_JPB2 DESC";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = "";

        $datas[$key]["LANTAI"] = $value['LANTAI_MIN_JPB2'] . " s.d " . $value["LANTAI_MAX_JPB2"];
        $datas[$key]["KELAS"] = $value["KLS_DBKB_JPB2"];
        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB2"];
    }
}

if($type == "pabrik"){
    $C_STR = "SELECT * FROM DBKB_JPB3 WHERE THN_DBKB_JPB3='" . $tahun_pajak . "' ORDER BY TING_KOLOM_MAX_DBKB_JPB3,TING_KOLOM_MIN_DBKB_JPB3,LBR_BENT_MAX_DBKB_JPB3,LBR_BENT_MIN_DBKB_JPB3";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = "";

        $datas[$key]["LUAS"] = $value["LBR_BENT_MIN_DBKB_JPB3"] . " s.d " . $value["LBR_BENT_MAX_DBKB_JPB3"];

        $datas[$key]["LANTAI"] = $value['TING_KOLOM_MIN_DBKB_JPB3'] . " s.d " . $value["TING_KOLOM_MAX_DBKB_JPB3"];

        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB3"];
    }
}

if($type == "pertokoan"){
    $C_STR = "SELECT * FROM DBKB_JPB4 where THN_DBKB_JPB4='" . $tahun_pajak . "' ORDER BY LANTAI_MAX_JPB4 ASC, LANTAI_MIN_JPB4 ASC,KLS_DBKB_JPB4 DESC";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = "";

        $datas[$key]["LANTAI"] = $value['LANTAI_MIN_JPB4'] . " s.d " . $value
        ["LANTAI_MAX_JPB4"];
        $datas[$key]["KELAS"] = $value["KLS_DBKB_JPB4"];
        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB4"];
    }
}

if($type == "rumah_sakit"){
    $C_STR = "SELECT * FROM DBKB_JPB5 where THN_DBKB_JPB5='" . $tahun_pajak . "' ORDER BY LANTAI_MAX_JPB5 ASC, LANTAI_MIN_JPB5 ASC,KLS_DBKB_JPB5 DESC";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = "";

        $datas[$key]["LANTAI"] = $value['LANTAI_MIN_JPB5'] . " s.d " . $value
        ["LANTAI_MAX_JPB5"];
        $datas[$key]["KELAS"] = $value["KLS_DBKB_JPB5"];
        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB5"];
    }
}

if($type == "olahraga"){
    $C_STR = "SELECT * FROM DBKB_JPB12 where THN_DBKB_JPB12='" . $tahun_pajak . "' ORDER BY TYPE_DBKB_JPB12";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = "";

        $datas[$key]["TIPE"] = $value['TYPE_DBKB_JPB12'];

        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB12"];
    }
}

if($type == "hotel"){
    $C_STR = "SELECT * FROM DBKB_JPB7 where THN_DBKB_JPB7='" . $tahun_pajak . "' ORDER BY LANTAI_MAX_JPB7 ASC, LANTAI_MIN_JPB7 ASC,BINTANG_DBKB_JPB7 DESC,JNS_DBKB_JPB7 ASC";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = $value['JNS_DBKB_JPB7'] == 1 ? "1. HOTEL NON RESORT" : "2. HOTEL RESORT";

        $datas[$key]["LANTAI"] = $value['LANTAI_MIN_JPB7'] . " s.d " . $value
        ["LANTAI_MAX_JPB7"];

        if ($value['BINTANG_DBKB_JPB7'] == "5") {
            $datas[$key]["BINTANG"] = 1;
        }
        elseif ($value['BINTANG_DBKB_JPB7'] == "4") {
            $datas[$key]["BINTANG"] = 2;
        }
        else
        if ($value['BINTANG_DBKB_JPB7'] == "3") {
            $datas[$key]["BINTANG"] = 3;
        }
        else
        if ($value['BINTANG_DBKB_JPB7'] == "2") {
            $datas[$key]["BINTANG"] = 4;
        }
        else{
            $datas[$key]["BINTANG"] = 5;
        }

        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB7"];
    }

}

if($type == "bengkel"){
    $C_STR = "SELECT * FROM DBKB_JPB8 WHERE THN_DBKB_JPB8='" . $tahun_pajak . "' ORDER BY TING_KOLOM_MAX_DBKB_JPB8,TING_KOLOM_MIN_DBKB_JPB8,LBR_BENT_MAX_DBKB_JPB8,LBR_BENT_MIN_DBKB_JPB8";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = "";

        $datas[$key]["LUAS"] = $value["LBR_BENT_MIN_DBKB_JPB8"] . " s.d " . $value["LBR_BENT_MAX_DBKB_JPB8"];

        $datas[$key]["LANTAI"] = $value['TING_KOLOM_MIN_DBKB_JPB8'] . " s.d " . $value["TING_KOLOM_MAX_DBKB_JPB8"];

        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB8"];
    }
}

if($type == "apartemen"){
    $C_STR = "SELECT * FROM DBKB_JPB13 where THN_DBKB_JPB13='" . $tahun_pajak . "' ORDER BY LANTAI_MAX_JPB13 ASC, LANTAI_MIN_JPB13 ASC,KLS_DBKB_JPB13 DESC";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        $datas[$key]["JPB"] = "";

        $datas[$key]["LANTAI"] = $value['LANTAI_MIN_JPB13'] . " s.d " . $value
        ["LANTAI_MAX_JPB13"];
        $datas[$key]["KELAS"] = $value["KLS_DBKB_JPB13"];
        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB13"];
    }
}

if($type == "kanopi"){
    $C_STR = "SELECT DAYA_DUKUNG.TYPE_KONSTRUKSI, DAYA_DUKUNG.DAYA_DUKUNG_LANTAI_MIN_DBKB, DAYA_DUKUNG.DAYA_DUKUNG_LANTAI_MAX_DBKB, DBKB_DAYA_DUKUNG.NILAI_DBKB_DAYA_DUKUNG FROM DBKB_DAYA_DUKUNG INNER JOIN DAYA_DUKUNG ON DBKB_DAYA_DUKUNG.TYPE_KONSTRUKSI = DAYA_DUKUNG.TYPE_KONSTRUKSI where DBKB_DAYA_DUKUNG.THN_DBKB_DAYA_DUKUNG='" . $tahun_pajak . "'";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {

        if ($value['TYPE_KONSTRUKSI']="1") {
            $datas[$key]["JPB"] = "1. Ringan";
        }else
        if ($value['TYPE_KONSTRUKSI']="2") {
            $datas[$key]["JPB"] = "2. Sedang";
        }else
        if ($value['TYPE_KONSTRUKSI']="3") {
            $datas[$key]["JPB"] = "3. Menengah";
        }else
        if ($value['TYPE_KONSTRUKSI']="4") {
            $datas[$key]["JPB"] = "4. Berat";
        }else{
            $datas[$key]["JPB"] = "5. Sangat Berat";
        }

        $datas[$key]["TIPE"] = $value['DAYA_DUKUNG_LANTAI_MIN_DBKB'] . " s.d " . $value['DAYA_DUKUNG_LANTAI_MAX_DBKB'];

        $datas[$key]["NJOP"] = $value["NILAI_DBKB_DAYA_DUKUNG"];
    }


}

if($type == "tangki_minyak"){
    $C_STR = "SELECT * FROM DBKB_JPB15 WHERE THN_DBKB_JPB15='" . $tahun_pajak . "' ORDER BY KAPASITAS_MAX_DBKB_JPB15,KAPASITAS_MIN_DBKB_JPB15,JNS_TANGKI_DBKB_JPB15";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {

        $datas[$key]["JPB"] = $value['JNS_TANGKI_DBKB_JPB15'] == 1 ? "1.TANGKI DIATAS TANAH" : "2. TANGKI DIBAWAH TANAH" ;

        $datas[$key]["KAPASITAS"] = $value['KAPASITAS_MIN_DBKB_JPB15'] . " s.d " . $value
        ["KAPASITAS_MAX_DBKB_JPB15"];
        
        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB15"];
    }
}

if($type == "gedung_sekolah"){
    $C_STR = "SELECT * FROM DBKB_JPB16 where THN_DBKB_JPB16='" . $tahun_pajak . "' ORDER BY LANTAI_MAX_JPB16 ASC, LANTAI_MIN_JPB16 ASC,KLS_DBKB_JPB16 DESC";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {

        
        $datas[$key]["JPB"] = "";
        
        $datas[$key]["LANTAI"] = $value['LANTAI_MIN_JPB16'] . " s.d " . $value["LANTAI_MAX_JPB16"];
        
        $datas[$key]["KELAS"] = $value["KLS_DBKB_JPB16"];

        $datas[$key]["NJOP"] = $value["NILAI_DBKB_JPB16"];
    }
}

if($type == "fasilitas1"){
    $C_STR = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FAS_DEP_JPB_KLS_BINTANG.KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.NILAI_FASILITAS_KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG FROM FASILITAS INNER JOIN FAS_DEP_JPB_KLS_BINTANG ON FASILITAS.KD_FASILITAS = FAS_DEP_JPB_KLS_BINTANG.KD_FASILITAS WHERE FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG='" . $tahun_pajak . "'";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        
        $datas[$key]["JPB"] = $value['NM_FASILITAS'];
        
        $datas[$key]["KELAS"] = $value["KLS_BINTANG"];

        $datas[$key]["NJOP"] = $value["NILAI_FASILITAS_KLS_BINTANG"];
    }
    
}

if($type == "fasilitas2"){
    $C_STR = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FAS_DEP_MIN_MAX.THN_DEP_MIN_MAX, FAS_DEP_MIN_MAX.KLS_DEP_MIN, FAS_DEP_MIN_MAX.KLS_DEP_MAX, FAS_DEP_MIN_MAX.NILAI_DEP_MIN_MAX FROM FASILITAS INNER JOIN FAS_DEP_MIN_MAX ON FASILITAS.KD_FASILITAS = FAS_DEP_MIN_MAX.KD_FASILITAS WHERE FAS_DEP_MIN_MAX.THN_DEP_MIN_MAX='" . $tahun_pajak . "'";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        
        $datas[$key]["JPB"] = $value['NM_FASILITAS'];
        
        $datas[$key]["KELAS"] = $value["KLS_DEP_MIN"] . " s.d " . $value['KLS_DEP_MAX'];

        $datas[$key]["NJOP"] = $value["NILAI_DEP_MIN_MAX"];
    }
}

if($type == "fasilitas3"){
    $C_STR = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FAS_NON_DEP.THN_NON_DEP, FAS_NON_DEP.NILAI_NON_DEP FROM FASILITAS INNER JOIN FAS_NON_DEP ON FASILITAS.KD_FASILITAS = FAS_NON_DEP.KD_FASILITAS WHERE FAS_NON_DEP.THN_NON_DEP='" . $tahun_pajak . "'";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        
        $datas[$key]["JPB"] = $value['NM_FASILITAS'];

        $datas[$key]["NJOP"] = $value["NILAI_NON_DEP"];
    }
}

if($type == "material"){
    $C_STR = "SELECT DBKB_MATERIAL.KD_PROPINSI, DBKB_MATERIAL.KD_DATI2, DBKB_MATERIAL.THN_DBKB_MATERIAL, PEKERJAAN.KD_PEKERJAAN, PEKERJAAN.NM_PEKERJAAN, PEKERJAAN.STATUS_PEKERJAAN, PEKERJAAN_KEGIATAN.KD_KEGIATAN, PEKERJAAN_KEGIATAN.NM_KEGIATAN, DBKB_MATERIAL.NILAI_DBKB_MATERIAL FROM (PEKERJAAN INNER JOIN PEKERJAAN_KEGIATAN ON PEKERJAAN.KD_PEKERJAAN = PEKERJAAN_KEGIATAN.KD_PEKERJAAN) INNER JOIN DBKB_MATERIAL ON (PEKERJAAN_KEGIATAN.KD_KEGIATAN = DBKB_MATERIAL.KD_KEGIATAN) AND (PEKERJAAN_KEGIATAN.KD_PEKERJAAN = DBKB_MATERIAL.KD_PEKERJAAN) WHERE DBKB_MATERIAL.THN_DBKB_MATERIAL='" . $tahun_pajak . "' order by PEKERJAAN_KEGIATAN.NM_KEGIATAN";

    $results = $qb->rawQuery($C_STR)->get();

    $datas = [];

    foreach ($results as $key => $value) {
        
        $datas[$key]["JPB"] = $value['NM_PEKERJAAN'];

        $datas[$key]["NJOP"] = $value["NILAI_DBKB_MATERIAL"];
    }
}