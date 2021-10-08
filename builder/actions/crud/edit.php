<?php
$msg = get_flash_msg('success');
$_data   = $_GET['data'];
$builder = new Builder;
$all_fields  = $builder->get_content($_data,'sample');
$all_fields  = (array) $all_fields;

$datas       = $builder->get_content($_data.'s');
$values      = (array) $datas[$_GET['key']];
$keys        = array_keys($values);
$fields      = [];

foreach($keys as $key)
{
    $fields[$key] = [
        'type' => $all_fields[$key],
        'value' => $values[$key]
    ];
}

if(request() == 'POST')
{
    $post = $_POST;
    $datas = (array) $datas;
    $datas[$_GET['key']] = $post;
    $datas = json_encode($datas);
    if($builder->set_content($_data.'s',$datas))
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/crud/index&data='.$_data);
        return;
    }
}