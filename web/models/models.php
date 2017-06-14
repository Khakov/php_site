<?php

require_once ROOT.'/repositories/UserRepository.php';
function get_customers()
{
    return ['f' => 'физческое лицо', 'u' => 'юридическое лицо'];
}

function get_catalog_1()
{
    $data = [];
    $data[] = get_product('карандаш', 5);
    $data[] = get_product('ручка', 10);
    $data[] = get_product('линейка', 12);
    return $data;
}

function get_catalog_2()
{
    $data = [];
    $data[] = get_product('конфеты', 2);
    $data[] = get_product('кефир', 20);
    $data[] = get_product('хлеб', 25);
    return $data;
}

function get_product($name, $price)
{
    return ['name' => $name, 'price' => $price];
}

function getGuestsById($id)
{
    $userRepository = new UserRepository();
    $userRepository->getUserByLogin("arthur@mail.ru");
    $results =[];
    $result = [];
    $isExist = false;
    if (($handle = fopen("guests.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (!strcmp($data[0], $id)) {
                $result['name'] = $data[1];
                $result['text'] = $data[2];
                $result['avatar'] = $userRepository->getAvatarByEmail($data[1]);
                $results[]=$result;
                $isExist = true;
            }
        }
        fclose($handle);
    }
    if ($isExist) {
        return $results;
    }
    else{
        return null;
    }
}