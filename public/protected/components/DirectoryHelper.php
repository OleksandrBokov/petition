<?php

class DirectoryHelper
{
    public static function checkDir($path)
    {
        $arr = explode('/',$path);

        $dir = $_SERVER['DOCUMENT_ROOT'];
        for($i = 1; $i < count($arr); $i++)
        {
            $dir = $dir.'/'.$arr[$i];
            if(!empty($arr[$i])){
                self::createDir($dir);
            }
        }

        return true;
    }

    public static function createDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path , 0777);
            return true;
        }else{
            return false;
        }
    }


    public static function checkFileExist($path, $file_name)
    {
        if(self::checkDir($path)){
            if(!file_exists($path.'/'.$file_name)){
                fopen($path.'/'.$file_name, 'w');
                chmod($path.'/'.$file_name, 0777);
                return true;
            }
        }
        return false;
    }


    public static function createPicture($base64, $path)
    {
        $base_arr = explode(',', $base64);
        $data = array_shift($base_arr);
        $data = str_replace('data:image/','',$data);
        $format = str_replace(';base64','',$data);

        $uploadPath = $_SERVER['DOCUMENT_ROOT'].$path;

        $img = base64_decode(end($base_arr));

        $file_name = date('YmdHis');

        $fjpg = fopen($uploadPath.$file_name.'.'.$format, "w");

        fwrite($fjpg,$img);
        fclose($fjpg);

        return $path.$file_name.'.'.$format;
    }



    public static function uploadFile($tmp_name, $path, $file_name)
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$path.'/'.$file_name)){
            $file = explode('.',$file_name);
            $file_name = $file[0].'_'.date('YmdHis').'.'.$file[1];
        }

        if (!move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT'].$path.$file_name) ){
            return false;
        }else{
            return $file_name;
        }
    }


    public static function deleteFile($path)
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$path)){
            @unlink($_SERVER['DOCUMENT_ROOT'].$path);
        }

    }
}