<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 23.04.17
 * Time: 18:59
 */
require_once SITE_PATH."/models/User.php";
require_once SITE_PATH."/database/DBConnection.php";
class UserRepository
{
    private $connection = null;
    public function __construct()
    {
        $this->connection = DBConnection::getConnection();
    }

    function getRowByNickname($nickname)
    {
        $isExist = false;
        $stmt = $this->connection->prepare("SELECT * FROM my_user WHERE nickname = ?");
        if ($stmt->execute(array($nickname))) {
            if ($row = $stmt->fetch()) {
                $isExist = true;
            }
        }
        return $isExist;
    }
    function getUserByLogin($login){
        $user = null;
        $stmt = $this->connection->prepare("SELECT * FROM my_user WHERE email = ?");
        if ($stmt->execute(array($login))) {
            if ($data = $stmt->fetch()) {
                    $user = new User();
                    $user->setId($data[0]);
                    $user->setLastName($data[1]);
                    $user->setFirstName($data[2]);
                    $user->setNickname($data[3]);
                    $user->setEmail($data[4]);
                    $user->setAvatar($data[5]);
                    $user->setPassword($data[6]);
                    $user->setCountry($data[7]);
                    $user->setGender($data[8]);
                    $user->setAgreement($data[9]);
                    $user->setNews($data[10]);
                }
            }
        return $user;
    }

    function getRowByLogin($login)
    {
        $isExist = false;
        $stmt = $this->connection->prepare("SELECT * FROM my_user WHERE email = ?");
        if ($stmt->execute(array($login))) {
            if ($row = $stmt->fetch()) {
                $isExist = true;
            }
        }
        return $isExist;
    }

    function getAvatarByEmail($email)
    {

        $avatar = '/avatar/default.jpg';
        $stmt = $this->connection->prepare("SELECT * FROM my_user WHERE email = ?");
        if ($stmt->execute(array($email))) {
            if ($data = $stmt->fetch()) {
                $avatar = $data[5];
            }
        }
        return $avatar;
    }
    function registerUser($user){
        $stmt = $this->connection->prepare("INSERT INTO my_user VALUES 
        (DEFAULT,?,?,?,?,?,?,?,?,?,?)");
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $nickname = $user->getNickname();
        $email = $user->getEmail();
        $avatar = $user->getAvatar();
        $password = $user->getPassword();
        $country = $user->getCountry();
        $gender = $user->getGender();
        $agreement = $user->getAgreement();
        $news = $user->getNews();
        $stmt->bindParam(1, $firstName);
        $stmt->bindParam(2, $lastName);
        $stmt->bindParam(3, $nickname);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $avatar);
        $stmt->bindParam(6, $password);
        $stmt->bindParam(7, $country);
        $stmt->bindParam(8, $gender);
        $stmt->bindParam(9, $agreement);
        $stmt->bindParam(10, $news);
        $stmt->execute();
        return $user;
    }

    public function getUserById($user_id)
    {
        $user = null;
        $stmt = $this->connection->prepare("SELECT * FROM my_user WHERE my_user.id = ?");
        if ($stmt->execute(array((int)$user_id))) {
            if ($data = $stmt->fetch()) {
                $user = new User();
                $user->setId($data[0]);
                $user->setLastName($data[1]);
                $user->setFirstName($data[2]);
                $user->setNickname($data[3]);
                $user->setEmail($data[4]);
                $user->setAvatar($data[5]);
                $user->setCountry($data[7]);
                $user->setGender($data[8]);
                $user->setAgreement($data[9]);
                $user->setNews($data[10]);
            }
        }
        return $user;
    }

}