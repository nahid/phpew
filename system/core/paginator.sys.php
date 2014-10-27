<?php
class Paginator{
	public static function show(){
		echo Crud::table('user')->nextId()->result();
	}
}