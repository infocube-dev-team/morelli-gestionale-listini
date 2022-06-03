<?php
class ListiniHelper {

	const LISTINO_MT_SMIN = 'smin';
	const LISTINO_MT_1 = '1';
	const LISTINO_MT_31 = '31';
	const LISTINO_MT_100 = '100';
	const LISTINO_MT_200 = '200';
	const LISTINO_MT_300 = '300';
	const LISTINO_MT_400 = '400';
	const LISTINO_MT_500 = '500';


	protected function __construct() {
	}

	/**
	 * @return self
	 */
	public static function getInstance() {
		static $instance;
		if(!$instance) {
			$instance = new ListiniHelper();
		}

		return $instance;
	}

	/**
	 * @param bool $smin
	 * @param bool $min
	 *
	 * @return string[]
	 */
	public function getMetrature($smin = false, $min = false) {

		$metrature = $this -> getMetratureAttive(false, false);

		if($min) {
			$metrature[0] = $min;
		}

		return $metrature;
	}

	public function getMetratureAttive($addFirst = true, $addMin = true) {

		$metrature = [];

		if($addFirst) {
			$metrature[] = self::LISTINO_MT_1;
		}

		$metrature = $metrature + [
			self::LISTINO_MT_31,
			self::LISTINO_MT_100,
			self::LISTINO_MT_200,
			self::LISTINO_MT_300,
//			self::LISTINO_MT_400,
//			self::LISTINO_MT_500,
		];

		if($addMin) {
			$metrature[] = self::LISTINO_MT_SMIN;
		}

		return array_values($metrature);
	}


	/**
	 * @param $smin
	 *
	 * @return int
	 */
	public function isAttiva2($smin) {
		return ($smin != null && $smin != 0 && $smin != "") ? 1 : 0;
	}

	public function getOptions() {

		$query  = "SELECT * FROM opzioni_listino";
		return $this -> __getDB() -> getRow($query);

	}

	public function getRicarichi() {
		$options = $this -> getOptions();
		$ricarichi = [];

		$ricarichiFields = [
//			self::LISTINO_MT_500,
//			self::LISTINO_MT_400,
			self::LISTINO_MT_300,
			self::LISTINO_MT_200,
			self::LISTINO_MT_100,
			self::LISTINO_MT_31,
			self::LISTINO_MT_1,
			self::LISTINO_MT_SMIN
		];

		if($options) {

			foreach ($ricarichiFields as $key) {

				$label = $key;
                if($key != self::LISTINO_MT_SMIN) {
                    $label .= ' mt.';
                }

                $key = 'r' . $key;
				$ricarichi[$key] = [
					'label' => $label,
					'value' => $options[$key]
				];
			}

		}

		return $ricarichi;
	}

	protected function __getDB() {
		return DB::getInstance();
	}

}
