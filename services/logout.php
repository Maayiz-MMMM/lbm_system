<?php
session_start();
session_unset();
session_destroy();

header('location:'.dirname($_SERVER['PHP_SELF']).'/../find.php');