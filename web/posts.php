<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 06.06.17
 * Time: 22:55
 */
require_once '../system/core/utils/core.php';
require_once ROOT.'/service/UserService.php';
require_once ROOT.'/service/PostService.php';
showHeader();
$userService = new UserService();
if($userService->getAuthUser()!= null) {
    $data = [];
    $postService = new PostService();
    $count = $postService->getPostsCount();
    if (isset($_GET["page"]) && $_GET["page"] <= ($count-1)/10 + 1){
        $page= $_GET["page"];
    }else{
        $page= 1;
    }
    $data["user"] = $userService->getAuthUser();
    $posts = $postService->getPostsByPage($page);
    $data["count"] = $count;
    $data["posts"] = $posts;
    $data["page"]= $page;
    showTemplate($data, "templates/posts");
}else{
    header("Location:/login.php");
    exit();
}
