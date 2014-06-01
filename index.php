<?php

include_once __DIR__ . "/init.php";

$page = empty($_REQUEST['page']) ? "upload" : $_REQUEST['page']; // @todo add some security-checks to see if the page is valid
include __DIR__ . "/view/main.php";