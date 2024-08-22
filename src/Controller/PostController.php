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
        //Upload d'image
        if($post->getPicture() != null) {
            //On génère un nom de fichier unique
            $filename = uniqid().'.jpg';
            //On décode le base64 envoyé par le front dans la requête
            $decoded = base64_decode($post->getPicture());
            //On le met dans un fichier accessible sur le web (en l'occurrence le dossier public)
            file_put_contents(__DIR__.'/../../public/'.$filename, $decoded);
            //On assigne le nom du fichier à notre post pour sauvegarder ça en base de donnée plutôt que l'image elle même
            $post->setPicture($filename);
        }


        $this->repo->persist($post);
        return $this->json($post, 201);    
    }

}