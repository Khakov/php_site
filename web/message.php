<?php
/**
 * Created by PhpStorm.
 * User: khan
 * Date: 22.05.17
 * Time: 17:50
 */
require_once '../system/core/utils/core.php';
require_once ROOT.'/service/CommentService.php';
require_once ROOT.'/service/UserService.php';
require_once ROOT.'/service/PostService.php';
$userService = new UserService();
if($userService->getAuthUser()!= null) {
    $data = [];
    $commentService = new CommentService();
    $postService = new PostService();
    $data["user"] = $userService->getAuthUser();
    $post = $postService->getPostById(1);
    $post->setComments($commentService->getCommentsByPostId(1));
    $data["post"] = $post;
    showTemplate($data, "templates/message");
}else{
    header("Location:/login.php");
    exit();
}
