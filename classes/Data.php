<?php
class Data 
{
    public $curl;
    
    public static function init()
    {
        $class = new self();
        $class->curl = Curl::init();
        return $class;
    }

    // Метод который возвращает список пользователей
    public function getUser( $id = null)
    {
        return $this->curl->setopt('users/', $id);
    }
    
    // Метод который возвращает список постов пользователя
    public function getPost($id)
    {
        return $this->curl->setopt('posts?userId=', $id);
    }

    // Метод который возвращает список заданий пользователя
    public function getTodos($id)
    {
        return $this->curl->setopt('todos?userId=',  $id);
    }

}
