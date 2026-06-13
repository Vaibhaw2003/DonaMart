<?php
// admin/logout.php
session_start();
session_unset();
session_destroy();
header("Location: /DonaMart/admin/login.php");
exit;