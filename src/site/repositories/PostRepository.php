<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 04.06.17
 * Time: 21:21
 */
require_once SITE_PATH."/models/Post.php";
require_once SITE_PATH."/models/User.php";
require_once SITE_PATH."/database/DBConnection.php";
class PostRepository
{
    private $connection = null;
    public function __construct()
    {
        $this->connection = DBConnection::getConnection();
    }

    /**
     * @return array
     */
    public function getAllPosts(){
        $stmt = $this->connection->prepare("SELECT p.id, p.text, p.theme, p.time, 
        my_user.id, my_user.email, my_user.first_name, my_user.last_name
        FROM post AS p INNER JOIN my_user ON p.user_id = my_user.id ORDER BY p.time DESC");
        $posts = [];
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                $newPost = new Post();
                $user = new User();
                $newPost->setId($row[0]);
                $newPost->setText($row[1]);
                $newPost->setTheme($row[2]);
                $newPost->setTime($row[3]);
                $user->setId($row[4]);
                $user->setEmail($row[5]);
                $user->setFirstName($row[6]);
                $user->setLastName($row[7]);
                $newPost->setUser($user);
                $posts[] = $newPost;
            }
        }
        return $posts;
    }
    public function getPostById($id){
        $stmt = $this->connection->prepare("SELECT p.id, p.text, p.theme, p.time, 
        my_user.id, my_user.email, my_user.first_name, my_user.nickname
        FROM post AS p INNER JOIN my_user ON p.user_id = my_user.id WHERE p.id=?");
        if ($stmt->execute(array($id))) {
            if ($row = $stmt->fetch()) {
                $newPost = new Post();
                $user = new User();
                $newPost->setId($row[0]);
                $newPost->setText($row[1]);
                $newPost->setTheme($row[2]);
                $newPost->setTime($row[3]);
                $user->setId($row[4]);
                $user->setEmail($row[5]);
                $user->setFirstName($row[6]);
                $user->setNickname($row[7]);
                $newPost->setUser($user);
                return $newPost;
            }
        }
        return null;
    }
    public function getPostsByUser(User $user){
        $stmt = $this->connection->prepare("SELECT p.id, p.text, p.theme, p.time
        FROM post AS p WHERE p.user_id =? ORDER BY p.time DESC");
        $posts = [];
        if ($stmt->execute(array((int)$user->getId()))) {
            while ($row = $stmt->fetch()) {
                $newPost = new Post();
                $newPost->setId($row[0]);
                $newPost->setText($row[1]);
                $newPost->setTheme($row[2]);
                $newPost->setTime($row[3]);
                $newPost->setUser($user);
                $posts[] = $newPost;
            }
        }
        return $posts;
    }
    public function getPostsCountByUser(User $user){
        $stmt = $this->connection->prepare("SELECT count(p) FROM post AS p 
        WHERE p.user_id =?");
        if ($stmt->execute(array($user->getId()))) {
            while ($row = $stmt->fetch()) {
                return $row[0];
            }
        }
        return 0;
    }
    public function getPostsCount(){
        $stmt = $this->connection->prepare("SELECT count(post.id) FROM post");
        if ($stmt->execute()) {
            while ($row = $stmt->fetch()) {
                return $row[0];
            }
        }
        return 0;
    }

    public function getPostsByPage($page)
    {
        $stmt = $this->connection->prepare("SELECT p.id, p.text, p.theme, p.time, 
        my_user.id, my_user.email, my_user.first_name, my_user.nickname
        FROM post AS p INNER JOIN my_user ON p.user_id = my_user.id ORDER BY 
        p.time DESC LIMIT 10 OFFSET ?");
        $posts = [];
        if ($stmt->execute([($page - 1) * 10])) {
            while ($row = $stmt->fetch()) {
                $newPost = new Post();
                $user = new User();
                $newPost->setId($row[0]);
                $newPost->setText($row[1]);
                $newPost->setTheme($row[2]);
                $newPost->setTime($row[3]);
                $user->setId($row[4]);
                $user->setEmail($row[5]);
                $user->setFirstName($row[6]);
                $user->setNickname($row[7]);
                $newPost->setUser($user);
                $posts[] = $newPost;
            }
        }
        return $posts;
    }

    public function addPost($theme, $text, $user)
    {
        $text = html_script($text);
        $theme = html_replace($theme);
        $stmt = $this->connection->prepare("INSERT INTO post VALUES (DEFAULT,?,?,?,?)");
        $userId = $user->getId();
        $time = new DateTime();
        $timeMills = $time->getTimestamp();
        $stmt->bindParam(1, $text);
        $stmt->bindParam(2, $theme);
        $stmt->bindParam(3, $timeMills);
        $stmt->bindParam(4, $userId);
        $stmt->execute();
        return true;
    }

    public function getPostsByUserAndPage(User $user, $page)
    {
        $stmt = $this->connection->prepare("SELECT p.id, p.text, p.theme, p.time
        FROM post AS p WHERE p.user_id = ? ORDER BY p.time DESC LIMIT 10 OFFSET ?");
        $posts = [];
        if ($stmt->execute([$user->getId(), ($page - 1) * 10])) {
            while ($row = $stmt->fetch()) {
                $newPost = new Post();
                $user = new User();
                $newPost->setId($row[0]);
                $newPost->setText($row[1]);
                $newPost->setTheme($row[2]);
                $newPost->setTime($row[3]);
                $newPost->setUser($user);
                $posts[] = $newPost;
            }
        }
        return $posts;
    }
}