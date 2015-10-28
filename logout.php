<?php

require_once dirname(__FILE__)."/lib/header_session.php";
SESSION_DESTROY();
	header("Location: index.php");
	?>