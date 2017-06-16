<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 16.06.17
 * Time: 20:20
 */
require_once SITE_PATH.'/service/UserService.php';
class UserController
{
    private $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * @return UserService
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * @param UserService $userService
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    public function login_page(){
        $data = [];
        if (!isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST["login"]) && $_POST["password"]){
                    if ($this->userService->authorizeUser($_POST["login"], $_POST["password"])) {
                        return ['redirect'=>"posts"];
                    }else{
                        $data = ['error'=>"Не правильно введен логин или пароль",
                            'login'=>$_POST["login"]];
                    }
                }else{
                    $data = ['error' => "Не правильно введен логин или пароль"];
                }
            }
            return ['view' => 'form/login',
                'data' => $data];
        }
        else{
            return ['redirect'=>"posts"];
        }
    }
    public function logout(){
        if (isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
        return ['redirect'=>"login"];
    }
    public function registration(){
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isError = false;
            if (isset($_POST['first-name']))
                $data['firstName'] = $_POST['first-name'];
            if (isset($_POST['last-name']))
                $data['lastName'] = $_POST['last-name'];
            if (isset($_POST['nickname']))
                $data['nickname'] = $_POST['nickname'];
            if (isset($_POST['email']))
                $data['email'] = $_POST['email'];
            if (isset($_POST['password1']))
                $password1 = $_POST['password1'];
            if (isset($_POST['password2']))
                $password2 = $_POST['password2'];
            if (isset($_POST['country']))
                $data['country'] = $_POST['country'];
            if (isset($_POST['gender']))
                $data['gender'] = $_POST['gender'];
            if (isset($_POST['agreement']))
                $data['agreement'] = 1;
            else
                $data['agreement'] = 0;
            if (isset($_POST['news']))
                $data['news'] = 1;
            else
                $data['news'] = 0;
            if (!isset($data['firstName']) || isset($data['firstName']) && !preg_match('|^[a-zа-яЁё\s]+$|ui', $data['firstName'])) {
                $firstNameError = "некорректное имя";
                $isError = true;
            }
            if (!isset($data['lastName']) || isset($data['lastName']) && !preg_match('|^[a-zа-яё\s]+$|ui', $data['lastName'])) {
                $data['lastNameError'] = "некорректная фамилия";
                $isError = true;
            }
            if (!isset($data['nickname']) || isset($data['nickname']) && !preg_match('|^\w{4,10}$|ui', $data['nickname'])) {
                $data['nicknameError'] = "minimum 4 and max 10 character nickname";
                $isError = true;
            }
            if (isset($data['nickname']) &&
                $this->userService->userIsExistByNickname($data['nickname'])){
                $data['nicknameError'] = "этот никнейм занят";
                $isError = true;
            }
            if (!isset($password1) || isset($password1) && !preg_match('|^\w{4,10}$|ui', $password1)) {
                $data['password1Error'] = "minimum 4 and max 10 character password";
                $isError = true;
            }

            if (!isset($password2) || isset($password2) && isset($password1) &&
                strcmp($password1, $password2)!=0) {
                $data['password2Error'] = "пароли не совпадают";
                $isError = true;
            }

            if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['emailError'] = "Invalid email format";
                $isError = true;
            }
            if (isset($data['email']) && $this->userService->userIsExist($data['email'])){
                $data['emailError'] = "этот логин уже используется";
                $isError = true;
            }
            if (!isset($data['country']) || isset($data['country']) && !preg_match('|^[a-zа-яё\s]+$|ui', $data['country'])) {
                $data['countryError'] = "некорректная страна";
                $isError = true;
            }
            if (!isset($data['gender'])) {
                $data['genderError'] = "некорректный пол";
                $isError = true;
            }
            if ($data['agreement'] == 0) {
                $data['agreementError'] = "нужно согласиться с условиями";
                $isError = true;
                unset($data['agreement']);
            }
            $avatar = "";
            $isErr = true;
            if (isset($_FILES['avatar'])){
                if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
                    if ($_FILES['avatar']['size'] < 30 *1024*1024*1024){
                        echo $_FILES['avatar']['type'];
                        if (in_array($_FILES['avatar']['type'], ['image/jpeg', 'image/bmp', 'image/png'])){
                            $uploaddir = PUBLIC_PATH;
                            $info = new SplFileInfo($_FILES['avatar']['name']);
                            $expansion = $info->getExtension();
                            $avatar = '/avatars/'.uniqid()."__".time().".".$expansion;
                            $uploadfile = $uploaddir.$avatar;
                            echo $uploadfile."\n";
                            if(!move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)){
                                $data['avatarError'] = "Возможная атака с помощью файловой загрузки!";
                            }else{
                                $isErr = false;
                            }
                        }
                        else{
                            $data['avatarError'] = "Не соответсвует формат загрузки";
                        }
                    }
                    else{
                        $data['avatarError'] = "Превышен размер загрузки данных";
                    }
                }
                else {
                    $data['avatarError'] = "Возможная атака с помощью файловой загрузки!";
                }
            }else{
                $data['avatarError'] = "ошибка загрузки файла";
            }
            $isError = $isError | $isErr;
            if ($isError) {
                return ['view' => 'form/registration',
                    'data' => $data];
            } else {
                $user = new User();
                $user->setLastName($data['lastName']);
                $user->setFirstName($data['firstName']);
                $user->setNickname($data['nickname']);
                $user->setEmail($data['email']);
                $user->setAvatar($avatar);
                $user->setPassword($password1);
                $user->setCountry($data['country']);
                $user->setGender($data['gender']);
                $user->setAgreement($data['agreement']);
                $user->setNews($data['news']);
                $this->userService->registerNewUser($user);
                return ['redirect'=>"login"];
            }
        } else {
            return ['view' => 'form/registration',
                'data' => $data];        }
    }
}