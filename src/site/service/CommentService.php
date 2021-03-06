<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 22.05.17
 * Time: 18:01
 */
require_once SITE_PATH . "/repositories/UserRepository.php";
require_once SITE_PATH . "/repositories/CommentRepository.php";

class CommentService
{
    private $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    public function getCommentsByPostId($id)
    {
        $comments = $this->commentRepository->getCommentsByPostId($id);
        $return_comments = [];
        foreach ($comments as $key=>$comment){
            if ($comment->getParentId() === null){
                $return_comments[] = $comment;
                unset($comments[$key]);
            }
        }
        foreach ($return_comments as $key=> $comment){
            $comment->setChilds($this->getCommentsByComment($comments,$comment->getId()));
            $return_comments[$key] = $comment;
        }
        return $return_comments;
    }
    public function getCommentsByComment($comments, $commentId){
        $childs = [];
        foreach ($comments as $key=> $comment){
            if ($comment->getParentId()=== $commentId){
                $childs[]=$comment;
                unset($comments[$key]);
            }
        }
        if (count($childs)>0){
            foreach ($childs as $key => $child){
                $child->setChilds($this->getCommentsByComment($comments,$child->getId()));
                $childs[$key] = $child;
            }
        }
        return $childs;
    }
    public function addComment($posId, $user, $text, $parent_id){
        $comment = new Comment();
        $comment->setUser($user);
        $comment->setCommentText($text);
        $comment->setParentId($parent_id);
        $comment->setPostId($posId);
        return $this->commentRepository->addComment($comment);
    }
}