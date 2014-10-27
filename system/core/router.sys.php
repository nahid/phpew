<?php
class Router {
	public function pageLoad($page, $skin) {
		$page=rawurldecode($page).".page.php";

		//echo $page;

		
	if($skin!==FALSE){

		if (file_exists(ROOT . DS . "app" . DS . "pages" . DS . $skin . DS . "header.php")) {
			require_once (ROOT . DS . "app" . DS . "pages" . DS . $skin . DS . "header.php");
		} else {
			require_once (ROOT . DS . "app" . DS . "pages" . DS . "header.php");
		}
	}

		if (file_exists(ROOT . DS . "app" . DS . "pages" . DS. $page)) {
			require_once (ROOT . DS . "app" . DS. "pages". DS . $page);
		}else {
			require_once (ROOT . DS . "app" . DS . "pages" . DS . "404.php");

		}
		
	if($skin!==FALSE){

		if (file_exists(ROOT . DS . "app" . DS . "pages" . DS . $page . DS . "footer.php")) {
			require_once (ROOT . DS . "app" . DS . "pages" . DS . $page . DS . "footer.php");
		} else {
			require_once (ROOT . DS . "app" . DS . "pages" . DS . "footer.php");
		}
	}

	// clear all our internal data from session
	clearSessionData();
	}


}
?>