<?php
$_data   = $_GET['data'];
$builder = new Builder;
$datas       = $builder->get_content($_data.'s');
$datas       = (array) $datas;
unset($datas[$_GET['key']]);

$datas = json_encode($datas);
if($builder->set_content($_data.'s',$datas))
{
    set_flash_msg(['success'=>'Data Deleted']);
    header('location:index.php?page=builder/crud/index&data='.$_data);
    return;
}