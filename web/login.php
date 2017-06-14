<?php
require_once '../system/core/utils/core.php';
$data = [];
if (!isset($_SESSION['user'])) {
    require_once 'service/UserService.php';
    require_once 'models/models.php';
    $userService  = new UserService();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST["login"]) && $_POST["password"]){
            if ($userService->authorizeUser($_POST["login"], $_POST["password"])) {
                header("Location:/message.php");
                exit();
            }else{
                $data = ['error'=>"Не правильно введен логин или пароль",
                        'login'=>$_POST["login"]];
            }
        }else{
            $data = ['error' => "Не правильно введен логин или пароль"];
        }
    }
    require_once '../system/core/utils/common.func.php';
    showTemplate($data,"templates/form/login");
}
else{
    header("Location:/message.php");
    exit();
}
