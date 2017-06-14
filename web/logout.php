<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 24.04.17
 * Time: 19:32
 */
require_once '../system/core/utils/core.php';
if (isset($_SESSION['user'])){
    unset($_SESSION['user']);
}
header("Location:/login.php");
exit();