<?php

namespace App\Repository;
use App\Entity\Post;

class PostRepository {


    public function persist(Post $post) {
        $connection = Database::connect();
        $query = $connection->prepare('INSERT INTO post (message, posted_at, latitude,longitude,author,picture, category_id) VALUES(:message,:postedAt,:latitude,:longitude,:author,:picture,:categoryId)');
        $query->bindValue(':message', $post->getMessage());
        $query->bindValue(':postedAt', $post->getPostedAt()->format('Y-m-d'));
        $query->bindValue(':latitude', $post->getLatitude());
        $query->bindValue(':longitude', $post->getLongitude());
        $query->bindValue(':author', $post->getAuthor());
        $query->bindValue(':picture', $post->getPicture());
        if($post->getCategory() != null) {
            $query->bindValue(':categoryId',$post->getCategory()->getId());
        } else {
            $query->bindValue(':categoryId', null);
        }
        $query->execute();
        $post->setId($connection->lastInsertId());
        


    }
}