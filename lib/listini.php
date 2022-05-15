<?php
class ListiniHelper {

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

	public function getOptions() {

		$query  = "SELECT * FROM opzioni_listino";
		return $this -> __getDB() -> getRow($query);

	}

	public function getRicarichi() {
		$options = $this -> getOptions();
		$ricarichi = [];

		$ricarichiFields = [
			'r500',
			'r400',
			'r300',
			'r200',
			'r100',
			'r31',
			'r1',
			'rsmin'
		];

		if($options) {

			foreach ($ricarichiFields as $key) {

				$label = str_replace('r', '', $key);
                if($label != 'smin') {
                    $label .= ' mt.';
                }

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
