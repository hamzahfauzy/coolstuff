<?php

class Form
{
    static function input($type,$name,$attribute = [])
    {
        $attr = '';
        foreach($attribute as $key => $value)
            $attr .= " $key='$value'";
        return "<input type='$type' name='$name' $attr>";
    }
}