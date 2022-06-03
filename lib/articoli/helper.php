<?php

class ArticoliHelper {

	const COSTO_METRATURA_1 = 'cm1';
	const COSTO_METRATURA_31 = 'cm31';
	const COSTO_METRATURA_100 ='cm100';
	const COSTO_METRATURA_200 ='cm200';
	const COSTO_METRATURA_300 ='cm300';
	const COSTO_METRATURA_400 ='cm400';
	const COSTO_METRATURA_500 ='cm500';
	const COSTO_METRATURA_MIN ='cmsmin';

	protected function __construct() {
	}

	/**
	 * @return self
	 */
	public static function getInstance() {
		static $instance;
		if ( ! $instance ) {
			$instance = new ArticoliHelper();
		}

		return $instance;
	}

	public function getDiffMetratureAttive($addFirst = true, $addMin = true) {
		$listinoHelper = ListiniHelper::getInstance();
		$metratureAttive = $listinoHelper -> getMetratureAttive($addFirst, $addMin);

		$diffs = [];
		foreach ($metratureAttive as $m) {
			$diffs[] = "cm" . $m;

		}

		return $diffs;
	}

	/**
	 * @param $id
	 *
	 * @return bool|null
	 */
	public function getDiffs( $id ) {
		$articolo = $this -> __getDB() -> getRow( "SELECT cm1, cm31, cm100, cm200, cm300, cm400, cm500, cmsmin FROM articoli WHERE id='$id'" );

		$diffs = array(
			'cm1',
			'cm31',
			'cm100',
			'cm200',
			'cm300',
			'cm400',
			'cm500',
			'cmsmin'
		);

		return $articolo;
	}


	protected function __getDB() {
		return DB::getInstance();
	}

}
