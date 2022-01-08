<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$qb = new QueryBuilder();

if(isset($_GET['check'])){
    $sql = "Select * FROM DAT_SUBJEK_PAJAK_NJOPTKP WHERE THN_NJOPTKP='" . trim($_GET['year']) . "'";

    $pbb = $qb->rawQuery($sql)->first();

    echo $pbb ? 1 : 0;
    die;
}

if(request() == 'POST'){

    $vBangunan = [];
    $vBangunan1 = [];

    function C_NJOPTKP(){
        global $vBangunan,$vBangunan1;

        $sql = "SELECT SUBJEK_PAJAK_ID, JNS_BUMI From QOBJEKPAJAK GROUP BY SUBJEK_PAJAK_ID, JNS_BUMI HAVING JNS_BUMI='1'";
        $qb = new QueryBuilder();

        $njoptkp = $qb->rawQuery($sql)->get();

        foreach($njoptkp as $key => $value){
            
            $vBangunan[$key][] = $key;
            $vBangunan[$key][] = $value['SUBJEK_PAJAK_ID'];
            $vBangunan[$key][] = "-";
            $vBangunan[$key][] = "-";
            $vBangunan[$key][] = "-";
            $vBangunan[$key][] = "-";
            $vBangunan[$key][] = "-";
            $vBangunan[$key][] = "-";
            $vBangunan[$key][] = "-";
            $vBangunan[$key][] = $_POST['THN_NJOPTKP'];
        }

        $n_STR = "SELECT * FROM QOBJEKPAJAK ORDER BY NJOP_BUMI+NJOP_BNG, SUBJEK_PAJAK_ID ASC";
        $n_data = $qb->rawQuery($n_STR)->get();

        foreach ($n_data as $key => $value) {

            $vBangunan1[$key][] = $key;
            $vBangunan1[$key][] = $value['SUBJEK_PAJAK_ID'];
            $vBangunan1[$key][] = $value['KD_PROPINSI'];
            $vBangunan1[$key][] = $value['KD_DATI2'];
            $vBangunan1[$key][] = $value['KD_KECAMATAN'];
            $vBangunan1[$key][] = $value['KD_KELURAHAN'];
            $vBangunan1[$key][] = $value['KD_BLOK'];
            $vBangunan1[$key][] = $value['NO_URUT'];
            $vBangunan1[$key][] = $value['KD_JNS_OP'];
            $vBangunan1[$key][] = $value['JNS_BUMI'];
            $vBangunan1[$key][] = $value['NJOP_BUMI'] + $value['NJOP_BNG'];
        }

        if($vBangunan1 && $vBangunan){
    
            foreach ($vBangunan1 as $key => $value) {
    
                foreach ($vBangunan as $key2 => $value2) {
                    
                    if ($value[1] == $value2[1]){
                        $vBangunan[$key2][2] = $value[2];
                        $vBangunan[$key2][3] = $value[3];
                        $vBangunan[$key2][4] = $value[4];
                        $vBangunan[$key2][5] = $value[5];
                        $vBangunan[$key2][6] = $value[6];
                        $vBangunan[$key2][7] = $value[7];
                        $vBangunan[$key2][8] = $value[8];
                    }

                }
    
            }

        }
        
    }

    function sv_NJOPTKP(){
        global $vBangunan,$vBangunan1;
        $qb = new QueryBuilder();

        if($vBangunan){
            $s_SQL = "DELETE From DAT_SUBJEK_PAJAK_NJOPTKP where THN_NJOPTKP='".$_POST['THN_NJOPTKP']."'";
    
            $qb->rawQuery($s_SQL)->exec();
    
            foreach ($vBangunan as $key => $value) {
                
                $s_SQL = "Insert Into DAT_SUBJEK_PAJAK_NJOPTKP values ('" . $value[1] . "','" . $value[2] . "','" . $value[3] . "','" . $value[4] . "','" . $value[5] . "','" . $value[6] . "','" . $value[7] . "','" . $value[8] . "','" . $value[9] . "')";
                echo $s_SQL ."<br>";
                $qb->rawQuery($s_SQL)->exec();
                
            }
        }

    }

    C_NJOPTKP();

    sv_NJOPTKP();

    die();

    set_flash_msg(['success'=>'Data Saved']);
    header("location:index.php?page=builder/penetapan-njoptkp/index");
    return;

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");