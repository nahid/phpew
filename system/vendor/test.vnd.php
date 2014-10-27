<?php
class Test{
	var $a="";
	
	function show(){
		$this->a= "yes";
		return $this;
	}
	function view(){
		return "hello ".$this->a;
	}
}