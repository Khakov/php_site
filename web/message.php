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
$commentService = new CommentService();
$postService = new PostService();
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user =  $userService->getAuthUser();
    if (isset($_POST["post_id"]) && $_POST["post_id"]!=0){
        if (isset($_POST["text"])&&strlen($_POST["text"])>0
            &&strlen($_POST["text"])<200){
            $parentId = isset($_POST["parent_id"])?$_POST["parent_id"]:null;
            $commentService->addComment($_POST["post_id"],$user,
                $_POST["text"],$parentId);
        }else{
            $data["error"] = "некорректный текст";
        }
    }else{
        $data["error"] = "плохой запрос";
    }
}
if ($userService->getAuthUser() != null) {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    } else {
        $id = 1;
    }
    $data["user"] = $userService->getAuthUser();
    $post = $postService->getPostById($id);
    $post->setComments($commentService->getCommentsByPostId($id));
    $data["post"] = $post;
    showTemplate($data, "templates/message");
} else {
    header("Location:/login.php");
    exit();
}