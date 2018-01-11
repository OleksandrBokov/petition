<?php

$dirs = array();
$dirs = scandir(dirname(__FILE__).'/../modules');
$dirs = clearDir($dirs);
// строим массив
$modules = array();
$inner_modules = array();
foreach ($dirs as $key => $value){

    if($inmodule = findInnerModules($value)){
        $modules[$value] = array('class'=>'application.modules.' . $value . '.' . ucfirst($value) . 'Module',
            'modules'=>$inmodule
        );
    }else{
        $modules[$value] = array('class'=>'application.modules.' . $value . '.' . ucfirst($value) . 'Module');
    }
}

function findInnerModules($dir){
    $inner_modules = [];
    $dirPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.'modules';
    if(is_dir($dirPath)){
        $inner_dirs = scandir($dirPath);
        $inner_dirs = clearDir($inner_dirs);

        if($inner_dirs){

            foreach ($inner_dirs as $name)
            {
                $inner_modules[$name] = array('class'=>'application.modules.' . $dir . '.modules.'. $name.'.'. ucfirst($name) . 'Module');
            }

        }
    }

    return $inner_modules;

}

function clearDir($dir){
    unset($dir[array_search('.', $dir)]);
    unset($dir[array_search('..', $dir)]);
    unset($dir[array_search('.DS_Store', $dir)]);

    return $dir;
}

return $modules;
