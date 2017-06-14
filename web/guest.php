<?php
require_once '../system/core/utils/core.php';
require_once '../system/core/utils/common.func.php';
require_once 'models/models.php';
require_once 'service/UserService.php';

$userService = new UserService();
showHeader();
$data = [];
if (isset($_REQUEST['guest'])) {
    $data['guests'] = getGuestsById($_REQUEST['guest']);
    $data['guest'] = $_REQUEST['guest'];
    if ($data['guests']=== null){
        unset($data['guests']);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $isError = false;
        if (isset($_POST['email']))
            $data['email'] = $_POST['email'];
        if (isset($_POST['text']))
            $data['text'] = $_POST['text'];
        if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['emailError'] = "Invalid email format";
            $isError = true;
        }
        if (isset($data['email']) && !$userService->userIsExist($data['email'])){
            $data['emailError'] = "нет пользователя с таким логином";
            $isError = true;
        }
        if (!isset($data['text']) || (isset($data['text']) && strlen($data['text'])>100)){
            $data['emailError'] = "длина текста не  должна быть более 100 символов";
            $isError = true;
        }
        if (!$isError){
            $row =  $_REQUEST['guest'].",".$data['email'].",".$data['text']."\n";
            file_put_contents("guests.csv", $row, FILE_APPEND | LOCK_EX);
            header("Location:/success2.php?guest=".$_REQUEST['guest']);
            exit();
        }
    }
    showTemplate($data, 'templates/guest');
}
else{
    echo "выберите доугого пользователя";
}
showFooter();