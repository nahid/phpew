<?php
class Files{

	function __construct(){

	}

	public static function download($file='', $name=''){
		if($file=='' OR $name==''){
			return false;
		}

		global $mime;

		$path=pathinfo($name);
		$extension=$path['extension'];
		if(array_key_exists($extension, $mime)){
			//$ftype=$mime[$extension];
			ob_clean();
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=".$name.";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ". filesize($file));
			readfile($file);
			ob_end_flush();
			exit();
		}else{
			echo"Unsupported file";
			return false;
		}


	}

	public  static function upload($file='', $path='', $name=''){
		if($file=='' OR $path==''){
			return false;
		}

		$tmp=isset($_FILES[$file]['tmp_name'])?$_FILES[$file]['tmp_name']:null;


		if(!is_null($tmp)){
			$name=$name==''?$_FILES[$file]['name']:$name;
			if(move_uploaded_file($tmp, removeEndSlashFromString($path)."/".$name)){
				return true;
			}else{
				return false;
			}
		}




	}

	public static function create($file, $mode="x+"){
		$mode=$mode=='try'?'w+':$mode;
		$file=ROOT. DS. $file;
		if(!file_exists($file)){
		$open=fopen($file, $mode);
		if($open){
			return new self;
		}
	}

		return false;
	}
}