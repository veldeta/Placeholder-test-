<?php

class Post 
{
    public $curl;

    public static function init()
    {
        $class = new self();
        $class->curl = Curl::init();
        return $class;
    }
    
    // Метод который добавляет посты
    public function createPost($userId, $title, $body)
    {
        return $this->curl->setoptMethod('posts',"POST", 
            json_encode(
            [
                'userId' => $userId,
                'title' => $title,
                'body' => $body,
            ], 
            JSON_THROW_ON_ERROR)
        );
    }

    // Метод который изменяет посты
    public function updatePost($id, $title, $body, $userId)
    {
        return $this->curl->setoptMethod('posts/' . $id,"PUT",
            json_encode([
                'id' => $id,
                'title' => $title,
                'body' => $body,
                'userId' => $userId,
            ],
            JSON_THROW_ON_ERROR)
        );

    }
    // Метод который удаляет посты
    public function deletePost($id)
    {
        return $this->curl->setoptMethod('posts/' . $id, "DELETE");
    }
}