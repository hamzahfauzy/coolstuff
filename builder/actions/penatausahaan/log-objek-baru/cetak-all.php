<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$C_STR = "";
$CetakQ = 0;

if($KD_KECAMATAN == 'Semua' && $KD_KELURAHAN == 'Semua')
{

    if( isset($cLog) && $cLog == 'on' ){
        $CetakQ = 2;
    }else{
        $CetakQ = 3;
    }

}
elseif($KD_KECAMATAN != 'Semua' && $KD_KELURAHAN == 'Semua')
{

    if( isset($cLog) && $cLog == 'on' ){
        $CetakQ = 4;
    }else{
        $CetakQ = 5;
    }
        
}else{

    if( isset($cLog) && $cLog == 'on' ){
        $CetakQ = 6;
    }else{
        $CetakQ = 7;
    }

}

if( $CetakQ == 1 ){
    $C_STR = "SELECT * from LogUtama where NOP1='" . trim($NOP) . "' and xFLAG='1' order by TGL_PEREKAMAN_OP asc";
}elseif( $CetakQ == 2 ){
    $C_STR = "SELECT * from LogUtama where xFLAG='1' AND (CONVERT(VARCHAR(10),TGL_PEREKAMAN_OP,110)>='" . $dRekam1 . "' AND CONVERT(VARCHAR(10),TGL_PEREKAMAN_OP,110)<= '" . $dRekam2 . "') order by TGL_PEREKAMAN_OP asc";
}elseif( $CetakQ == 3 ){
    $C_STR = "SELECT * from LogUtama where xFLAG='1' order by TGL_PEREKAMAN_OP asc";
}elseif( $CetakQ == 4 ){
    $C_STR = "SELECT * from LogUtama where xFLAG='1' and SUBSTRING(NOP1,7,3)='" . $KD_KECAMATAN . "'AND (CONVERT(VARCHAR(10),TGL_PEREKAMAN_OP,110)>='" . $dRekam1 . "' AND CONVERT(VARCHAR(10),TGL_PEREKAMAN_OP,110)<= '" . $dRekam2 . "') order by TGL_PEREKAMAN_OP asc";
}elseif( $CetakQ == 5 ){
    $C_STR = "SELECT * from LogUtama where xFLAG='1' and SUBSTRING(NOP1,7,3)='" . $KD_KECAMATAN . "' order by TGL_PEREKAMAN_OP asc";
}elseif( $CetakQ == 6 ){
    $C_STR = "SELECT * from LogUtama where xFLAG='1' and  SUBSTRING(NOP1,7,3)='" . $KD_KECAMATAN . "' AND SUBSTRING(NOP1,11,3)='" . $KD_KELURAHAN . "' AND (CONVERT(VARCHAR(10),TGL_PEREKAMAN_OP,110)>='" . $dRekam1 . "' AND CONVERT(VARCHAR(10),TGL_PEREKAMAN_OP,110)<= '" . $dRekam2 . "') order by TGL_PEREKAMAN_OP asc";
    
}elseif( $CetakQ == 7 ){
    $C_STR = "SELECT * from LogUtama where xFLAG='1' and SUBSTRING(NOP1,7,3)='" . $KD_KECAMATAN . "' AND SUBSTRING(NOP1,11,3)='" . $KD_KELURAHAN . "' order by TGL_PEREKAMAN_OP asc";
}

$datas = $qb->rawQuery($C_STR)->get();

