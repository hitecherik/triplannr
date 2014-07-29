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
		public $day = array();
		public $night = array();

		function __construct($period) {
			$this->date = substr($period["value"], 0, -1);

			foreach ($period->Rep[0]->attributes() as $name => $value) {
				$this->day[$name] = $value;
			}

			foreach ($period->Rep[1]->attributes() as $name => $value) {
				$this->night[$name] = $value;
			}
		}

		public function outputData($params) {
			echo $this->date;

			echo "<h2>Day</h2>";
			foreach ($this->day as $name => $value) {
				echo "$name: $value {$params[$name][0]}\n";
			}

			echo "<h2>Night</h2>";
			foreach ($this->night as $name => $value) {
				echo "$name: $value {$params[$name][0]}\n";
			}
		}
	}