<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$C_STR = "SELECT * FROM SPPT_SIMULASI1 ORDER BY THN_PAJAK*1 DESC";

$datas = $qb->rawQuery($C_STR)->get();

$datas_new = [];

foreach ($datas as $key => $value) {
    if(array_key_exists($value['NM_KECAMATAN'],$datas_new)){

        $datas_new[$value['NM_KECAMATAN']]['total']['SPPT1'] += $value['SPPT1'];
        $datas_new[$value['NM_KECAMATAN']]['total']['PBB1'] += $value['PBB1'];
        $datas_new[$value['NM_KECAMATAN']]['total']['SPPT2'] += $value['SPPT2'];
        $datas_new[$value['NM_KECAMATAN']]['total']['PBB2'] += $value['PBB2'];

    }else{
        
        $datas_new[$value['NM_KECAMATAN']]['total']['SPPT1'] = $value['SPPT1'];
        $datas_new[$value['NM_KECAMATAN']]['total']['PBB1'] = $value['PBB1'];
        $datas_new[$value['NM_KECAMATAN']]['total']['SPPT2'] = $value['SPPT2'];
        $datas_new[$value['NM_KECAMATAN']]['total']['PBB2'] = $value['PBB2'];

    }

    $datas_new[$value['NM_KECAMATAN']]['kelurahans'][$value['NM_KELURAHAN']]['SPPT1'] = $value['SPPT1'];
    $datas_new[$value['NM_KECAMATAN']]['kelurahans'][$value['NM_KELURAHAN']]['PBB1'] = $value['PBB1'];
    $datas_new[$value['NM_KECAMATAN']]['kelurahans'][$value['NM_KELURAHAN']]['SPPT2'] = $value['SPPT2'];
    $datas_new[$value['NM_KECAMATAN']]['kelurahans'][$value['NM_KELURAHAN']]['PBB2'] = $value['PBB2'];
}