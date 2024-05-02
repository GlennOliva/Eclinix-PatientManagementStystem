<?php
include('../config/dbcon.php');
session_start();
session_unset();
session_destroy();

header('location: patient_login.php');

?>