<?php
class Email {
	var $to;
	var $to_name;
	var $from;
	var $from_name;
	var $subject;
	var $htmlbody;

	public function to($to, $name = null) {
		$this -> to = $to;
		$this -> to_name = $name;
		return $this;
	}

	public function from($from, $name = null) {
		$this -> from = $from;
		$this -> from_name = $name;
		return $this;
	}

	public function subject($subject) {
		$this -> subject = $subject;
		return $this;
	}

	public function message($msg) {
		$this -> htmlbody = $msg;
		return $this;
	}

	public function send() {
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$headers .= 'To:' . $this -> to_name . '<' . $this -> to . '>' . "\r\n";
		$headers .= 'From:' . $this -> from_name . '<' . $this -> from . '>' . "\r\n";

		if (mail($this -> to, $this -> subject, $this -> htmlbody, $headers)) {
			return TRUE;
		} else {
			return false;
		}
	}

}
