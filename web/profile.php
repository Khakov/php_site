<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 06.06.17
 * Time: 23:29
 */
require_once '../system/core/utils/core.php';
require_once ROOT . '/service/UserService.php';
require_once ROOT . '/service/PostService.php';
showHeader();
$userService = new UserService();
$data = [];
$user_id = $_GET["id"];
if ($userService->getAuthUser()->getId() == $user_id) {
    $data["form"] = true;
}
$postService = new PostService();
$user = $userService->getUserById($user_id);
$data["user"] = $user;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["theme"]) && strlen($_POST["theme"]) > 0 && strlen($_POST["theme"]) < 100) {
        if (isset($_POST["text"]) && strlen($_POST["text"]) > 0 && strlen($_POST["text"]) < 10000) {
            $postService->addPost($_POST["theme"], $_POST["text"],
                $userService->getAuthUser());
        } else {
            $data["error"] = "Текст должен быть от 1 до 10000 символов";
        }
    } else {
        $data["error"] = "Тема должна быть от 1 до 100 символов";
    }
}
$count = $postService->getPostsCountByUser($user);
if (isset($_GET["page"]) && $_GET["page"] <= ($count - 1) / 10 + 1) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$posts = $postService->getPostsByUserAndPage($user, $page);
$data["posts"] = $posts;
$data["count"] = $count;
$data["page"] = $page;
showTemplate($data, "templates/profile");