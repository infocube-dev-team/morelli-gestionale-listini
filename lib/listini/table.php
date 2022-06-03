<?php

class ListiniTable {

	protected function __construct() {
	}

	/**
	 * @return self
	 */
	public static function getInstance() {
		static $instance;
		if ( ! $instance ) {
			$instance = new ListiniTable();
		}

		return $instance;
	}

	/**
	 * @return array
	 */
	public function getHeaders( $smin = false, $min = false ) {

		$metrature = $this->__getHelper()->getMetrature( $smin, $min );

		$headers = [];

		if ( $metrature ) {
			if ( $this->__getHelper()->isAttiva2( $smin ) ) {
				$headers[] = $smin . "/" . ($metrature[0] - 1);
			} else {
				$headers[] = '';
			}

			for ( $m = 0; $m < count( $metrature ); $m ++ ) {
				$start     = $metrature[ $m ];
				$end       = ( count( $metrature ) > ( $m + 1 ) ) ? $metrature[ $m + 1 ] - 1 : "-->";
				$headers[] = $start . "/" . $end;
			}
		}

		return $headers;

	}

	/**
	 * @return ListiniHelper
	 */
	protected function __getHelper() {
		return ListiniHelper::getInstance();
	}
}
