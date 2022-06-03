<?php
if ( ! defined( 'BOOTSTRAP' ) ) {

	function bootstrap() {
		define( 'BOOTSTRAP', 'BOOTSTRAP' );

		define( 'DS', DIRECTORY_SEPARATOR );
		define( 'BASE_DIR', realpath( __DIR__ ) );
		define( 'CONF_DIR', BASE_DIR . DS . "conf" );
		define( 'LIB_DIR', BASE_DIR . DS . "lib" );
		define( 'AMM_DIR', BASE_DIR . DS . "amministrazione" );

		require_once CONF_DIR . DS . "conf.php";
		require_once LIB_DIR . DS . "load.php";

		$db = DB::getInstance();
		$db->connect();

	}

	bootstrap();
}
