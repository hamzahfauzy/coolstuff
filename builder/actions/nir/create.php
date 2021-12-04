<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$vBangunan = [];

if(isset($_GET['check'])){


    $xxTahun = ((int)$_GET['YEAR']) - 1;

    $data = $qb->select('DAT_NIR','DAT_NIR.*, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN')
        ->join('REF_KECAMATAN as kecamatan','kecamatan.KD_KECAMATAN','DAT_NIR.KD_KECAMATAN')
        ->join('REF_KELURAHAN as kelurahan','kelurahan.KD_KELURAHAN','DAT_NIR.KD_KELURAHAN')->andJoin('kelurahan.KD_KECAMATAN','DAT_NIR.KD_KECAMATAN')
        ->where("DAT_NIR.THN_NIR_ZNT",$xxTahun);

    if (isset($_GET['KD_KECAMATAN'] )){

        $data = $data->where("DAT_NIR.KD_KECAMATAN",$_GET['KD_KECAMATAN']);
    }

    if (isset($_GET['KD_KELURAHAN'] )){

        $data = $data->where("DAT_NIR.KD_KELURAHAN",$_GET['KD_KELURAHAN']);
    }
    
    if (isset($_GET['KD_ZNT'] )){

        $data = $data->where("DAT_NIR.KD_ZNT",$_GET['KD_ZNT']);
    }

    $data = $data->orderBy("DAT_NIR.KD_ZNT")->get();

    echo json_encode($data);

    die;

}

$kecamatans = $qb->select('REF_KECAMATAN')->orderby('KD_KECAMATAN')->get();

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");

if(request() == 'POST')
{   

    $newPost = [];
    $newPost['KD_PROPINSI'] = 12;
    $newPost['KD_DATI2'] = 12;
    $newPost['KD_KANWIL'] = '01';
    $newPost['KD_KPPBB'] = 16;
    $newPost['JNS_DOKUMEN'] = 1;
    $newPost['THN_NIR_ZNT'] = $_POST['YEAR'];

    if(isset($_POST['NIR_BARU'])){
        foreach ($_POST['NIR_BARU'] as $key => $value) {

            $arr = explode("-",$key);

            $newPost['NO_DOKUMEN'] = $arr[0]; 
            $newPost['KD_KECAMATAN'] = $arr[1]; 
            $newPost['KD_KELURAHAN'] = $arr[2]; 
            $newPost['KD_ZNT'] = $arr[3]; 

            $newPost['NIR'] = $value;

            $data = $qb->select('DAT_NIR')->where('KD_KECAMATAN',$newPost['KD_KECAMATAN'])->where('KD_KELURAHAN',$newPost['KD_KELURAHAN'])->where('KD_ZNT',$newPost['KD_ZNT'])->where('THN_NIR_ZNT',$newPost['THN_NIR_ZNT'])->where('NO_DOKUMEN',$newPost['NO_DOKUMEN'])->first();

            if($data){
                $qb->update('DAT_NIR',$newPost)->where('KD_KECAMATAN',$newPost['KD_KECAMATAN'])->where('KD_KELURAHAN',$newPost['KD_KELURAHAN'])->where('KD_ZNT',$newPost['KD_ZNT'])->where('THN_NIR_ZNT',$newPost['THN_NIR_ZNT'])->where('NO_DOKUMEN',$newPost['NO_DOKUMEN'])->exec();
            }else{
                $qb->create('DAT_NIR',$newPost)->exec();
            }

            
        }
    }

    if($newPost == false){
        print_r(sqlsrv_errors());

        die;
    }

    if($newPost)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/nir/index');
        return;
    }
}