<?php

class Form
{
    static function input($type,$name,$attribute = [])
    {
        $attr = '';
        $vals = isset($attribute['value']) ? $attribute['value'] : '';
        if($type == 'date' && !isset($attribute['value'])) $attribute['value'] = date('Y-m-d');
        foreach($attribute as $key => $value)
            $attr .= " $key='$value'";
        
        if($type == 'textarea')
        {
            return self::textarea($name, $vals, $attr);
        }

        $lists = "";
        if(substr($type,0,7) == 'options')
        {
            $types = explode(':',$type);
            $options = $types[1];
            if(substr($type, 8,3) == 'obj')
            {
                $builder = new Builder;
                $datas = $builder->get_content($options.'s');
                $options = $datas;
                foreach($options as $option)
                {
                    $lists .= "<option value='".json_encode($option)."' ".(json_encode($option)==$value?'selected=""':'').">".$option->name."</option>";
                }
            }
            else
            {
                $options = explode('|',$options);
                foreach($options as $option)
                    $lists .= "<option value='$option' ".($option==$value?'selected=""':'').">$option</option>";
            }
            
            return self::options($name, $lists, $attr);
        }

        return self::text($type,$name,$attr);
    }

    static function text($type,$name, $attr = "")
    {
        return "<input type='$type' name='$name' $attr>";
    }

    static function textarea($name, $value, $attr = "")
    {
        return "<textarea name='$name' $attr>$value</textarea>";
    }

    static function options($name, $lists, $attr = "")
    {
        return "<select name='$name' $attr>$lists</select>";
    }
}