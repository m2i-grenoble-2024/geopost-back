<?php

namespace App\Repository;
use App\Entity\Category;
use App\Entity\Post;
use DateTimeImmutable;

class PostRepository {

    public function findAll(): array {
        $connection = Database::connect();
        $query = $connection->prepare('SELECT *, post.id post_id FROM post LEFT JOIN category ON post.category_id=category.id');
        $query->execute();
        $results = $query->fetchAll();

        $list = [];
        foreach($results as $line) {
            $category = new Category($line['label'], $line['category_id']);
            $post = new Post(
                $line['message'],
                $line['latitude'],
                $line['longitude'], 
                new DateTimeImmutable($line['posted_at']),
                $line['author'],
                $line['picture'],
                $line['post_id']
            );
            if($category->getId() != null) {
                $post->setCategory($category);
            }
            $list[]  = $post;
        }
        return $list;
    }

    public function persist(Post $post) {
        $connection = Database::connect();
        $query = $connection->prepare('INSERT INTO post (message, posted_at, latitude,longitude,author,picture, category_id) VALUES(:message,:postedAt,:latitude,:longitude,:author,:picture,:categoryId)');
        $query->bindValue(':message', $post->getMessage());
        $query->bindValue(':postedAt', $post->getPostedAt()->format('Y-m-d H:m:s'));
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