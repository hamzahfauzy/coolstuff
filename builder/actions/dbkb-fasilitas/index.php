<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

if(request() == 'POST'){
    if(!isset($_GET['fasilitas']) || $_GET['fasilitas'] == 'k1'){
        foreach($_POST['HARGA_BARU'] as $key => $hb){
            if($hb){
                $upd = $qb->update("FAS_NON_DEP",['NILAI_NON_DEP'=>$hb])->where('THN_NON_DEP',$_GET['year'])->where('KD_FASILITAS',$key)->exec();
            }
        }
    }else if(isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k2'){
        foreach($_POST['HARGA_BARU'] as $key => $hb){
            if($hb){

                $keys = explode('-',$key);

                $upd = $qb->update("FAS_DEP_JPB_KLS_BINTANG",['NILAI_FASILITAS_KLS_BINTANG'=>$hb])->where('THN_DEP_JPB_KLS_BINTANG',$_GET['year'])->where('KD_FASILITAS',$keys[0])->where('KD_JPB',$keys[1])->exec();
            }
        }
    }else if(isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k3'){
        foreach($_POST['HARGA_BARU'] as $key => $hb){
            if($hb){

                $keys = explode('-',$key);

                $upd = $qb->update("FAS_DEP_MIN_MAX",['NILAI_DEP_MIN_MAX'=>$hb])->where('THN_DEP_MIN_MAX',$_GET['year'])->where('KD_FASILITAS',$keys[0])->where('KLS_DEP_MIN',$keys[1])->where('KLS_DEP_MAX',$keys[2])->exec();
            }
        }
    }

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");

if(isset($_GET['year']) && $_GET['year']){
    $year = $_GET['year'];
}

$k1 = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_NON_DEP.NILAI_NON_DEP, FAS_NON_DEP.THN_NON_DEP FROM FASILITAS INNER JOIN FAS_NON_DEP ON FASILITAS.KD_FASILITAS = FAS_NON_DEP.KD_FASILITAS where FAS_NON_DEP.THN_NON_DEP= '" . $year . "'";

$k2 = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_DEP_JPB_KLS_BINTANG.KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.NILAI_FASILITAS_KLS_BINTANG, FAS_DEP_JPB_KLS_BINTANG.KD_JPB,FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG FROM FASILITAS INNER JOIN FAS_DEP_JPB_KLS_BINTANG ON FASILITAS.KD_FASILITAS = FAS_DEP_JPB_KLS_BINTANG.KD_FASILITAS where FAS_DEP_JPB_KLS_BINTANG.THN_DEP_JPB_KLS_BINTANG= '" . $year . "'";

$k3 = "SELECT FASILITAS.KD_FASILITAS, FASILITAS.NM_FASILITAS, FASILITAS.SATUAN_FASILITAS, FAS_DEP_MIN_MAX.KLS_DEP_MIN, FAS_DEP_MIN_MAX.KLS_DEP_MAX, FAS_DEP_MIN_MAX.NILAI_DEP_MIN_MAX, FAS_DEP_MIN_MAX.THN_DEP_MIN_MAX FROM FASILITAS INNER JOIN FAS_DEP_MIN_MAX ON FASILITAS.KD_FASILITAS = FAS_DEP_MIN_MAX.KD_FASILITAS where FAS_DEP_MIN_MAX.THN_DEP_MIN_MAX= '" . $year . "'";

if(isset($_GET['fasilitas']) && $_GET['fasilitas']){
    $query = $qb->rawQuery(${$_GET['fasilitas']});
}else{
    $query = $qb->rawQuery($k1);
}

if(isset($_GET['filter'])){
    if($_GET['dbkb']){
        $query->where('FASILITAS.NM_FASILITAS',"%".$_GET['dbkb']."%",'like');
    }
}

$datas = $query->get();

if(!$datas && !isset($_GET['filter'])){
    $qrs = explode('where',$query->sql);

    $kys = explode('INNER JOIN',$query->sql);

    $kys = explode(' ON ',$kys[1]);

    $ky = $kys[0];

    $qrs1 = explode('=',$qrs[1]);

    $qrs2 = explode(".",$qrs1[0]);

    $sYear = (int) str_replace("'","",$qrs1[1]);

    $newYear = "'".($sYear-1)."'";

    $qry = "SELECT * FROM $ky where $qrs2[1]=$newYear";

    $lastData = $qb->rawQuery($qry)->get();

    foreach ($lastData as $key => $value) {
        
        $value[$qrs2[1]] = $sYear; 
        // print_r($value);

        $qb->create($ky,$value)->exec();
    }

    header("location:index.php?page=builder/dbkb-fasilitas/index");
    return;
}