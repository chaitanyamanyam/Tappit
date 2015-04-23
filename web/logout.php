<?php

/**
 * @author 
 * @copyright 2014
 */
session_start();
unset($_SESSION['sess_username']);
header('Location: index.php');

?>