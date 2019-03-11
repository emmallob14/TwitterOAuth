<?php
IF(ISSET($_SESSION["access_token"])) {
	UNSET($_SESSION["access_token"]);
	session_destroy();
}
// redirect user back to index page
HEADER("location:index.php");
EXIT();
?>