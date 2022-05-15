<?php

class DB {

	protected $host;
	protected $port;
	protected $user;
	protected $password;
	protected $dbname;

	protected $conn = null;
	protected $error = "";

	protected function __construct( $host, $port, $user, $password, $dbname ) {
		$this->host     = $host;
		$this->port     = $port;
		$this->user     = $user;
		$this->password = $password;
		$this->dbname   = $dbname;
	}

	/**
	 * @return self
	 */
	public static function getInstance() {
		static $instance;
		if(!$instance) {
			$instance = new DB(
				DB_HOST,
				DB_PORT,
				DB_USER,
				DB_PASSWORD,
				DB_NAME
			);
		}

		return $instance;
	}

	public function getHost() {
		return $this->host;
	}

	public function getPort() {
		return $this->port;
	}

	public function getUser() {
		return $this->user;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getDbName() {
		return $this->dbname;
	}

	public function getError() {
		return mysql_error();
	}

	/**
	 * @return false|resource
	 */
	public function connect() {

		if ( ! $this->conn ) {

			$this->conn = mysql_connect( $this->getHost() . ":" . $this->getPort(), $this->getUser(), $this->getPassword() );
			if ( ! $this->conn ) {
				die( 'Could not connect : ' . $this->getHost() . $this->getError() );
			}

			if ( ! $this->dbSelect() ) {
				$this->close();
				die( 'Could not select db: ' . $this->getError() );
			}
		}

		return $this->conn;

	}

	/**
	 * @return bool
	 */
	protected function dbSelect() {

		if ( $this->conn ) {
			return mysql_select_db( $this->getDbName(), $this->conn );
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function getRow( $sql ) {
		$rows = $this -> query($sql);
		if($rows) {
			return $rows[0];
		}

		return null;
	}

	/**
	 * @return bool
	 */
	public function query( $sql ) {

		if ( $this->conn ) {
			$result = mysql_query( $sql, $this->conn );
			if ( $result ) {

				$return = [];
				if (mysql_num_rows($result) == 0) {
					return $return;
				}

				while ( $row = mysql_fetch_assoc( $result ) ) {
					$return[] = $row;
				}

				return $return;

			}
		}

		return null;
	}

	/**
	 * @return bool
	 */
	public function close() {

		if ( $this->conn ) {
			mysql_close( $this->conn );
			$this->conn = null;
		}

		return true;

	}

}
