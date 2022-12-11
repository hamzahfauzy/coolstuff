<?php
$_data   = $_GET['data'];
$builder = new Builder;
$fields  = $builder->get_content($_data,'sample');

if(request() == 'POST')
{
    $builder = new Builder;
    $datas  = $builder->get_content($_data.'s');
    $datas[] = $_POST;
    $datas = json_encode($datas);
    if($builder->set_content($_data.'s',$datas))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/crud/index&data='.$_data);
        return;
    }
}