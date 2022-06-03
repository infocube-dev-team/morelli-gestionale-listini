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
		if ( ! $instance ) {
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
	public function getRows( $sql ) {
		$result = $this->query( $sql );
		$return = [];

		if ( $result ) {
			if ( mysql_num_rows( $result ) == 0 ) {
				return $return;
			}

			while ( $row = mysql_fetch_assoc( $result ) ) {
				$return[] = $row;
			}

			return $return;

		}

		return $return;
	}

	/**
	 * @return bool
	 */
	public function getRow( $sql ) {
		$rows = $this->getRows( $sql );
		if ( $rows ) {
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
				return $result;
			}
		}

		return null;
	}

	public function update( $table, $object, $where, $noupdate = array() ) {

		if ( is_object( $object ) ) {
			$values = get_object_vars( $object );
		} else if ( is_array( $object ) ) {
			$values = $object;
		}

		if ( empty( $values ) ) {
			return false;
		}

		$campi = "";
		foreach ( $values as $key => $value ) {

			// Se campo updatabile
			if ( ! in_array( $key, $noupdate ) ) {
				$campi .= ( $campi == "" ) ? "" : ",";

				$campi .= "`" . $key . "`";
				if ( is_null( $value ) ) {
					$campi .= "=NULL";
				} else {
					$campi .= "='" . mysql_real_escape_string( $value, $this->conn ) . "'";
				}

			}
		}

		return $this->query( sprintf( "UPDATE %s SET %s WHERE %s", $table, $campi, $where ) );
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
