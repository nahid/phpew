<?php
class Html{
	protected static $errors=array();
	function __construct(){
		
	}
	
	public static function loadCss(array $files){
		if(is_array($files)){
			echo"\n<!-- ########################### Start importing css files ########################### --> \n";
			foreach($files as $css){
			
			$file=trim($css).".css";
			$nochache=hash('crc32',uniqid());
			$url=BU."assets".US."css".US.$file;
			if(file_exists(ROOT.DS."assets".DS."css".DS.$file)){
				echo "<link rel=\"stylesheet\" href=\"{$url}?nc={$nochache}\" type=\"text/css\" /> \n";
			}else{
				echo "\n<!-- {$file} was f und \n <link rel=\"stylesheet\" href=\"{$url}\" type=\"text/css\" /> \n -->\n\n";
				
			}
				
			}
			echo"<!-- ########################### End importing css files ########################### --> \n\n";
		}
	}
	
	
	public static function loadJs(array $files){
		if(is_array($files)){
			echo"\n<!-- ########################### Start importing java script files ########################### --> \n";
			foreach($files as $js){
			
			$file=trim($js).".js";
			$nochache=hash('crc32',uniqid());
			$url=BU."assets".US."js".US.$file;
			if(file_exists(ROOT.DS."assets".DS."js".DS.$file)){
					echo "<script src=\"{$url}?jr={$nochache}\" type=\"text/javascript\"></script>\n";
			}else{
				echo "\n<!-- {$file} was not found \n<script src=\"{$url}\" type=\"text/javascript\"></script> \n-->\n\n";
				
			}
				
			}
			echo"<!-- ########################### End importing java script files ########################### --> \n\n";
		}
	}
	
	
}
