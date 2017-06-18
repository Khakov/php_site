<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 04.06.17
 * Time: 21:17
 */
class Post
{
    private $time;
    private $id;
    private $user;
    private $text;
    private $theme;
    private $comments;
public function __construct()
{
}

    /**
     * @return int
     */
    public function getTime()
    {
        return html_entity_decode($this->time);
    }

    /**
     * @param int $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return html_entity_decode($this->text);
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return html_entity_decode($this->theme);
    }

    /**
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }
    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }/**
     * @param array $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

}