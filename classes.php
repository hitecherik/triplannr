<?php
	class Activity {
		public $name = "";
		public $count = 0;
		public $indoorActivity = false;

		function __construct($name, $indoorActivity = false) {
			$this->name = $name;
			$this->indoorActivity = $indoorActivity;
		}

		/* public function count() {
			return $this->count();
		} */

		public function add() {
			$this->count += 1;

			return $this->name;
		}

		public static function compareCounts($one, $two) {
			if ($one > $two) {
				return true;
			}

			return false;
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