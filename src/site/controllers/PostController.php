<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 16.06.17
 * Time: 21:44
 */
require_once SITE_PATH."/service/PostService.php";
require_once SITE_PATH."/service/UserService.php";
require_once SITE_PATH."/service/CommentService.php";
class PostController
{
    private $postService;
    private $userService;
    private $commentService;
    public function __construct()
    {
        $this->postService = new PostService();
        $this->userService = new UserService();
        $this->commentService = new CommentService();
    }

    public function get_posts(){
        if($this->userService->getAuthUser()!= null) {
            $data = [];
            $postService = new PostService();
            $count = $postService->getPostsCount();
            if (isset($_GET["page"]) && $_GET["page"] <= ($count-1)/10 + 1){
                $page= $_GET["page"];
            }else{
                $page= 1;
            }
            $data["user"] = $this->userService->getAuthUser();
            $posts = $postService->getPostsByPage($page);
            $data["count"] = $count;
            $data["posts"] = $posts;
            $data["page"]= $page;
            return ['view' => 'post/posts',
                'data' => $data];
        }else{
            return ['redirect'=>"login"];
        }
    }
    public function get_post($pathParams){
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user =  $this->userService->getAuthUser();
            if (isset($_POST["post_id"]) && $_POST["post_id"]!=0){
                if (isset($_POST["text"])&&strlen($_POST["text"])>0
                    &&strlen($_POST["text"])<200){
                    $parentId = isset($_POST["parent_id"])?$_POST["parent_id"]:null;
                    $this->commentService->addComment($_POST["post_id"],$user,
                        $_POST["text"],$parentId);
                }else{
                    $data["error"] = "некорректный текст";
                }
            }else{
                $data["error"] = "плохой запрос";
            }
        }
        if ($this->userService->getAuthUser() != null) {
            if (isset($pathParams[0])&& $pathParams[0]) {
                $id = $pathParams[0];
            } else {
                $id = 1;
            }
            $data["user"] = $this->userService->getAuthUser();
            $post = $this->postService->getPostById($id);
            if ($post!=null){
            $post->setComments($this->commentService->getCommentsByPostId($id));
            $data["post"] = $post;
            return ['view' => 'post/post',
                'data' => $data];
            }else{
                return ['view'=>"error_404", "data"=> $data];
            }
        } else{
            return ['redirect'=>"login"];
        }
    }
    public function get_user_info($pathParams){
        $data = [];
        if (isset($pathParams[0])) {
            $user_id = $pathParams[0];
        }else{
            $user_id = $this->userService->getAuthUser()->getId();
        }
        if ($this->userService->getAuthUser()->getId() == $user_id) {
            $data["form"] = true;
        }
        $user = $this->userService->getUserById($user_id);
        $data["user"] = $user;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["theme"]) && strlen($_POST["theme"]) > 0 && strlen($_POST["theme"]) < 100) {
                if (isset($_POST["text"]) && strlen($_POST["text"]) > 0 && strlen($_POST["text"]) < 10000) {
                    $this->postService->addPost($_POST["theme"], $_POST["text"],
                        $this->userService->getAuthUser());
                } else {
                    $data["error"] = "Текст должен быть от 1 до 10000 символов";
                }
            } else {
                $data["error"] = "Тема должна быть от 1 до 100 символов";
            }
        }
        $count = $this->postService->getPostsCountByUser($user);
        if (isset($pathParams[1]) && $pathParams[1] <= ($count - 1) / 10 + 1) {
            $page = $pathParams[1];
        } else {
            $page = 1;
        }
        $posts = $this->postService->getPostsByUserAndPage($user, $page);
        $data["posts"] = $posts;
        $data["count"] = $count;
        $data["page"] = $page;
        return ['view' => 'post/profile',
            'data' => $data];
    }
}