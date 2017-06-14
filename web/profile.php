<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 06.06.17
 * Time: 23:29
 */
require_once '../system/core/utils/core.php';
require_once ROOT.'/service/UserService.php';
require_once ROOT.'/service/PostService.php';
showHeader();
$userService = new UserService();
$data = [];
$user_id = $_GET["id"];
if($userService->getAuthUser()->getId()== $user_id) {
     $data["form"] = true;
}
    $postService = new PostService();
    $user = $userService->getUserById($user_id);
    $posts = $postService->getPostsByUser($user);
    $data["user"]= $user;
    $data["posts"] = $posts;
    showTemplate($data, "templates/profile");