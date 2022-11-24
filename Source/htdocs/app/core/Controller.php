<?php

namespace app\core;

class Controller
{
    public function view($name, $data = [])
    {
        include('app/views/' . $name . '.php');
    }

    public function saveImage($file)
    {
        if(empty($file))
            return false;

        $info = getimagesize($file);
        $types = ['image/jpeg'=>'jpg', 'image/png'=>'png'];

        if(in_array($info['mime'], array_keys($types)))
        {
            $extension = $types[$info['mime']];
            $filename = uniqid() . ".$extension";

            move_uploaded_file($file, 'img/'.$filename);

            return $filename;
        }

        else
        {
            return '';
        }
    }
}
