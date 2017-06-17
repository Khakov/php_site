<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 22.05.17
 * Time: 18:00
 */
require_once SITE_PATH."/models/User.php";
require_once SITE_PATH."/database/DBConnection.php";
require SITE_PATH."/models/Comment.php";
class CommentRepository
{
    private $connection = null;
    public function __construct()
    {
        $this->connection = DBConnection::getConnection();
    }

    function getCommentsByPostId($id)
    {
        $stmt = $this->connection->prepare("SELECT s.id, s.comment_text, my_user.first_name, 
        my_user.last_name, my_user.nickname, my_user.id, s.parent_id, s.time FROM comment AS s INNER JOIN my_user ON 
        s.user_id = my_user.id WHERE s.post_id =?");
        $comments = [];
        if ($stmt->execute(array($id))) {
            while($row = $stmt->fetch()) {
                $newComment = new Comment();
                $user = new User();
                $newComment->setId($row[0]);
                $newComment->setCommentText($row[1]);
                $newComment->setParentId($row[6]);
                $newComment->setTime($row[7]);
                $user->setFirstName($row[2]);
                $user->setLastName($row[3]);
                $user->setNickname($row[4]);
                $user->setId($row[5]);
                $newComment->setUser($user);
                $comments[] = $newComment;
            }
        }
        return $comments;
    }
    function addComment(Comment $comment){
        $time = new DateTime();
        $curr_time = $time->getTimestamp();
        $stmt = $this->connection->prepare("INSERT INTO comment VALUES (?,DEFAULT,?,?,?,?)");
        $commentText = html_replace($comment->getCommentText());
        $userId = $comment->getUser()->getId();
        $parentId = $comment->getParentId();
        $postId = $comment->getPostId();
        $stmt->bindParam(1, $commentText);
        $stmt->bindParam(2, $userId);
        $stmt->bindParam(3, $parentId);
        $stmt->bindParam(4, $postId);
        $stmt->bindParam(5,$curr_time);
        $stmt->execute();
        return $comment;
    }
}