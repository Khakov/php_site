<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 04.06.17
 * Time: 22:42
 */

require_once SITE_PATH . "/repositories/UserRepository.php";
require_once SITE_PATH . "/repositories/CommentRepository.php";
require_once SITE_PATH . "/repositories/PostRepository.php";
class PostService
{
    private $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function getPostById($id){
        return $this->postRepository->getPostById($id);
    }
    public function getPostsByUser(User $user){
        return $this->postRepository->getPostsByUser($user);
    }
    public function getAllPosts(){
        return $this->postRepository->getAllPosts();
    }
    public function getPostsByPage($page){
        return $this->postRepository->getPostsByPage($page);
    }
    public function getPostsByUserAndPage(User $user, $page){
        return $this->postRepository->getPostsByUserAndPage($user, $page);
    }
    public function getPostsCount(){
        return $this->postRepository->getPostsCount();
    }

    public function getPostsCountByUser($user)
    {
        return $this->postRepository->getPostsCountByUser($user);
    }

    public function addPost($theme, $text, $user)
    {
        $this->postRepository->addPost($theme,$text,$user);
    }
}