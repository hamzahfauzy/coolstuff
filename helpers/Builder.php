<?php

class Builder
{
    private $base_builder_path = '../builder/appdata/';
    function get_content($filename, $type = 'used')
    {
        $file_path = $this->base_builder_path.$type.'/'.$filename.'.json';

        if(!file_exists($file_path))
            return false;

        $installation = file_get_contents($file_path);
        return json_decode($installation);
    }

    function get_installation()
    {
        return $this->get_content('installation');
    }

    function get_installation_field()
    {
        return $this->get_content('installation','sample');
    }

    function set_content($filename,$content,$mode='rewrite') // type: rewrite, append
    {
        $mode = $mode == 'rewrite' ? FILE_USE_INCLUDE_PATH : FILE_USE_INCLUDE_PATH | FILE_APPEND;
        $file_path = $this->base_builder_path.'used/'.$filename.'.json';
        return file_put_contents($file_path,$content,$mode);
    }
}