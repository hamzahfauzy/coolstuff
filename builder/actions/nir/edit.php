<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("DAT_NIR","NO_DOKUMEN,NIR,THN_NIR_ZNT");
$data = $qb->select('DAT_NIR')->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_ZNT',$_GET['znt'])->where('THN_NIR_ZNT',$_GET['tahun'])->where('NIR',$_GET['nir'])->where('NO_DOKUMEN',$_GET['no_dokumen'])->first();
$keys        = array_keys($data);
$fields      = [];

$kecamatans = $qb->select('REF_KECAMATAN')->get();

$kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['kecamatan'])->get();
$znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->get();

$i = 0;
foreach($keys as $key => $val)
{

    if(empty($all_fields[$i]) || $all_fields[$i]['column_name'] != $val){
        continue;
    }

    $fields[$val] = [
        'type' => $all_fields[$i]['data_type'],
        'character_maximum_length' => $all_fields[$i]['character_maximum_length'],
        'value' => $data[$val],
    ];

    $i++;

}

if(request() == 'POST')
{   
    $update = $qb->update('DAT_NIR',$_POST)->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_ZNT',$_GET['znt'])->where('THN_NIR_ZNT',$_GET['tahun'])->where('NIR',$_GET['nir'])->where('NO_DOKUMEN',$_GET['no_dokumen'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/nir/index');
        return;
    }
}