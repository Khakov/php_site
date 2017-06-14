<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 23.04.17
 * Time: 18:58
 */
require_once ROOT."/repositories/UserRepository.php";
class UserService
{
    private $userRepository;
function __construct()
{
    $this->userRepository = new UserRepository();
}

    /**
     * @return UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    /**
     * @param UserRepository $userRepository
     */
    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    function userIsExist($nickname){
        return $this->userRepository->getRowByLogin($nickname);
    }
    function userIsExistByNickname($nickname){
        return $this->userRepository->getRowByNickname($nickname);
    }
    function registerNewUser($user){
        $password1 =  password_hash($this->preHashPassword($user->getPassword(),$user->getNickname()),
            PASSWORD_BCRYPT);
        $user->setPassword($password1);
        var_dump($user);
        return $this->userRepository->registerUser($user);
    }

    function preHashPassword($password, $nickname){
        $passLen = strlen($password);
        $nickLen = strlen($nickname);
        $pass = strrev(substr($password,0,$passLen/2)) . strrev(substr($password,$passLen/2, $passLen - $passLen/2));
        $nick = strrev(substr($nickname,0,$nickLen/2)) . strrev(substr($nickname,$nickLen/2, $nickLen - $nickLen/2));
        return $pass.$nick."Qst7Hg6";
    }
    function getAvatarByEmail($email){
        return $this->userRepository->getAvatarByEmail($email);
    }

    function authorizeUser($login, $password)
    {
        $user = $this->userRepository->getUserByLogin($login);
        if ($user != null) {
            if (password_verify($this->preHashPassword($password,
                $user->getNickname()), $user->getPassword())) {
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }

    public function getAuthUser()
    {
        if(isset($_SESSION['user'])){
            return $_SESSION['user'];
        }
        return null;
    }

    public function getUserById($user_id)
    {
        return $this->userRepository->getUserById($user_id);
    }
}