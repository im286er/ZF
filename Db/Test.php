<?php
class Db_Test extends Db_DAO {
    protected $servers   = array(
		'username' => DB_USERNAME,
		'password' => DB_PASSWORD,
		'master' => array(
			'host' => '192.168.37.140',
			'database' => 'mytest',
		 ),
		'slave' => array(
			'host' => '192.168.37.140',
			'database' => 'mytest',
		 ),
        'engine' => 'mysql',
	);
}