<?php
	class Activity {
		public $name = "";
		public $count = 0;
		public $allowsPrecipitation = false;

		function __construct($name, $allowsPrecipitation = false) {
			$this->name = $name;
			$this->allowsPrecipitation = $allowsPrecipitation;
		}

		public function add() {
			$this->count++;

			return $this->name;
		}

		private function compareObjects($a, $b) {
			if ($a->count == $b->count) {
				return 0;
			}

			return ($a->count > $b->count) ? 1 : -1;
		}

		public static function compareCounts(&$array) {
			usort($array, "self::compareObjects");
		}

		public static function withPrecipitation(&$array) {
			$with_precipitation = array();

			foreach ($array as $activity) {
				if ($activity->allowsPrecipitation) {
					array_push($with_precipitation, $activity);
				}
			}

			$array = $with_precipitation;
		}
	}

	class Day {
		public $date = "";
		public $nine = array();
		public $noon = array();
		public $three = array();

		function __construct($period) {
			$this->date = substr($period["value"], 0, -1);

			foreach ($period->Rep as $rep) {
				switch ((string) $rep) {
					case "540":
						foreach ($rep->attributes() as $name => $value) {
							$this->nine[$name] = $value;
						}
						break;
					
					case "720":
						foreach ($rep->attributes() as $name => $value) {
							$this->noon[$name] = $value;
						}
						break;

					case "900":
						foreach ($rep->attributes() as $name => $value) {
							$this->three[$name] = $value;
						}
						break;
				}
			}
		}
	}