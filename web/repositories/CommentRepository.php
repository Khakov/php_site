<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 22.05.17
 * Time: 18:00
 */
require_once ROOT."/models/User.php";
require_once ROOT."/database/DBConnection.php";
require ROOT."/models/Comment.php";
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
        my_user.last_name, my_user.email, my_user.id, s.parent_id FROM comment AS s INNER JOIN my_user ON 
        s.user_id = my_user.id WHERE s.post_id =?");
        $comments = [];
        if ($stmt->execute(array($id))) {
            while($row = $stmt->fetch()) {
                $newComment = new Comment();
                $user = new User();
                $newComment->setId($row[0]);
                $newComment->setCommentText($row[1]);
                $newComment->setParentId($row[6]);
                $user->setFirstName($row[2]);
                $user->setLastName($row[3]);
                $user->setEmail($row[4]);
                $user->setId($row[5]);
                $newComment->setUser($user);
                $comments[] = $newComment;
            }
        }
        return $comments;
    }
    function addComment(Comment $comment){
        $stmt = $this->connection->prepare("INSERT INTO comment VALUES (?,DEFAULT,?,?,?)");
        $commentText = $comment->getCommentText();
        $userId = $comment->getUser()->getId();
        $parentId = $comment->getParentId();
        $postId = $comment->getPostId();
        $stmt->bindParam(1, $commentText);
        $stmt->bindParam(2, $userId);
        $stmt->bindParam(3, $parentId);
        $stmt->bindParam(4, $postId);
        $stmt->execute();
        return $comment;
    }
}