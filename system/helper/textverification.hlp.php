<?php
class Textverification {
	var $v1;
	var $v2;
	var $opt = array();
	var $rndopt;

	var $string;

	function __construct() {
		$this -> v1 = rand(1, 99);
		$this -> v2 = rand(1, 99);
		$this -> opt = array('+', '-', '*', '/');
		$this -> rndopt = $this -> opt[array_rand($this -> opt)];
	}

	private function add() {
		$result = $this -> v1 + $this -> v2;
		$this -> string = $this -> v1 . ' ' . $this -> rndopt . ' ' . $this -> v2;
		$_SESSION['verify_text'] = $result;
		return $this -> string;
	}

	private function sub() {
		if ($this -> v2 > $this -> v1) {
			$result = $this -> v2 - $this -> v1;
			$this -> string = $this -> v2 . ' ' . $this -> rndopt . ' ' . $this -> v1;
		} else {
			$result = $this -> v1 - $this -> v2;
			$this -> string = $this -> v1 . ' ' . $this -> rndopt . ' ' . $this -> v2;
		}
		$_SESSION['verify_text'] = $result;
		return $this -> string;
	}

	private function mult() {
		$result = $this -> v1 * $this -> v2;
		$this -> string = $this -> v1 . ' ' . $this -> rndopt . ' ' . $this -> v2;
		$_SESSION['verify_text'] = $result;
		return $this -> string;
	}

	private function div() {
		if ($this -> v2 > $this -> v1) {
			$result = $this -> v2 / $this -> v1;
			$this -> string = $this -> v2 . ' ' . $this -> rndopt . ' ' . $this -> v1;
		} else {
			$result = $this -> v1 / $this -> v2;
			$this -> string = $this -> v1 . ' ' . $this -> rndopt . ' ' . $this -> v2;
		}

		$_SESSION['verify_text'] = $result;
		return $this -> string;
	}

	public function execute() {
		switch($this->rndopt) {
			case '+' :
				return $this -> add();
				break;
			case '-' :
				return $this -> sub();
				break;
			case '*' :
				return $this -> mult();
				break;
			case '/' :
				return $this -> div();
				break;
			default :
				return false;
				break;
		}
	}

}
