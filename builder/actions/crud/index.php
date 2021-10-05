<?php
$_data   = $_GET['data'];
$msg = get_flash_msg('success');
$builder = new Builder;
$fields = $builder->get_content($_data,'sample');
$datas = $builder->get_content($_data.'s');