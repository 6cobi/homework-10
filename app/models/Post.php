<?php

namespace app\models;

//using the database class namespace
use app\models\Model;

class Post extends Model {

    public function getAllPostsByTitle($title) {
        $query = "select * from title WHERE title like :title";
        return $this->fetchAllWithParams($query, ['title' => '%' . $title . '%']);
    }

    public function getAllPosts() {
        $query = "select * from posts";
        return $this->fetchAll($query);
    }

    public function getPostById($id){
        $query = "select * from posts where id = :id";
        return $this->fetchAllWithParams($query, ['id' => $id]);
    }

    public function savePost($inputData){
        $query = "insert into posts (title, content) values (:title, :content);";
        return $this->fetchAllWithParams($query, $inputData);
    }

    public function updatePost($inputData){
        $query = "update posts set title = :title, content = :content where id = :id";
        return $this->fetchAllWithParams($query, $inputData);
    }

    public function deletePost($inputData){
        $query = "DELETE FROM posts where id = :id";
        return $this->fetchAllWithParams($query, $inputData);
    }
}