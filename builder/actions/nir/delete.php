<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['kecamatan']) && isset($_GET['kelurahan']) && isset($_GET['nir']) && isset($_GET['tahun']) && isset($_GET['no_dokumen']))
{   
    $delete = $qb->delete('DAT_NIR',$_POST)->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_ZNT',$_GET['znt'])->where('THN_NIR_ZNT',$_GET['tahun'])->where('NIR',$_GET['nir'])->where('NO_DOKUMEN',$_GET['no_dokumen'])->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/nir/index');
        return;
    }
}