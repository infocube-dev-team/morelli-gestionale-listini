<?php
if(!defined('CONF_LOADED')) {

	define('DB_HOST', "morelli_mysql_1");
	define('DB_PORT', "3306");
	define('DB_USER', "root");
	define('DB_PASSWORD', "123456");
	define('DB_NAME', "gestionale");

	// Legacy
	$localhost=DB_HOST;
	$localporta=DB_PORT;
	$localnome=DB_NAME;
	$locallogin=DB_USER;
	$localpass=DB_PASSWORD;

	define('CONF_LOADED', 'CONF_LOADED');
}
