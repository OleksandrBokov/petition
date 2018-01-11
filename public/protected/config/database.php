<?php

if($_SERVER['SERVER_ADDR'] == '::1' || $_SERVER['SERVER_ADDR'] == '127.0.0.1'){
    return array(
        //'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        // uncomment the following lines to use a MySQL database

        'connectionString' => 'mysql:host=localhost;dbname=petition',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        // 'tablePrefix'=>'',
        // 'enableParamLogging' => true,
        // 'schemaCachingDuration'=>3600,

    );
}
else{
    return array(

        'connectionString' => 'mysql:host=localhost;dbname=petition',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '1Qaz2wsx',
        'charset' => 'utf8',
        // 'tablePrefix'=>'',
        // 'enableParamLogging' => true,
        // 'schemaCachingDuration'=>3600,
    );
}


// This is the database connection configuration.
/*return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database

	'connectionString' => 'mysql:host=localhost;dbname=sportportal',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'root',
	'charset' => 'utf8',
    'tablePrefix'=>'', ///needed empty to behaviors in models !!! or not finded model language
    'enableProfiling' => true,
    'enableParamLogging' => true,
    'schemaCachingDuration'=>3600, ///cache SHOW CREATE TABLE ...
);*/