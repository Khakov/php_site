<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 13.05.17
 * Time: 17:37
 */
require_once "../models/User.php";

class CSVUserRepository
{
    public function __construct()
    {
    }

    function getRowByNickname($nickname)
    {
        if (($handle = fopen("contacts.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && !$isExist) {
                if (!strcmp($data[3], $nickname)) {
                    $isExist = true;
                }
            }
            fclose($handle);
        }
        return $isExist;
    }

    function getUserByLogin($login)
    {
        $user = null;
        $isExist = false;
        if (($handle = fopen("contacts.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && !$isExist) {
                if (!strcmp($data[4], $login)) {
                    $isExist = true;
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
            fclose($handle);
        }
        return $user;
    }

    function getRowByLogin($nickname)
    {
        $isExist = false;
        if (($handle = fopen("contacts.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && !$isExist) {
                if (!strcmp($data[4], $nickname)) {
                    $isExist = true;
                }
            }
            fclose($handle);
        }
        return $isExist;
    }

    function getAvatarByEmail($email)
    {
        $isExist = false;
        $avatar = "";
        if (($handle = fopen("contacts.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE && !$isExist) {
                if (!strcmp($data[4], $email)) {
                    $avatar = $data[5];
                    $isExist = true;
                }
            }
            fclose($handle);
        }
        if ($isExist) {
            return $avatar;
        }
        return '/avatar/default.jpg';
    }

    function getCount()
    {
        $count = 0;
        if (($handle = fopen("contacts.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $count++;
            }
            fclose($handle);
        }
        return $count;
    }

    function registerUser($user)
    {
        $user->setId($this->getCount());
        $row = $user->getId() . ",";
        $row = $row . $user->getFirstName() . ",";
        $row = $row . $user->getLastName() . ",";
        $row = $row . $user->getNickname() . ",";
        $row = $row . $user->getEmail() . ",";
        $row = $row . $user->getAvatar() . ",";
        $row = $row . $user->getPassword() . ",";
        $row = $row . $user->getCountry() . ",";
        $row = $row . $user->getGender() . ",";
        $row = $row . $user->getAgreement() . ",";
        $row = $row . $user->getNews() . "\n";
        file_put_contents("contacts.csv", $row, FILE_APPEND | LOCK_EX);
        return $user;
    }
}