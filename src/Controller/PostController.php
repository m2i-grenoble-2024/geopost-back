<?php

namespace App\Controller;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;

#[Route('/api/post')]
class PostController extends AbstractController {

    public function __construct(private PostRepository $repo) {}

    #[Route(methods:'POST')]
    public function add(#[MapRequestPayload] Post $post) {
        $post->setPostedAt(new \DateTimeImmutable());
        $this->repo->persist($post);
        return $this->json($post, 201);    
    }

}