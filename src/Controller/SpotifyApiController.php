<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SpotifyApiController extends AbstractController
{
    /**
     * @Route("/spotify/api", name="spotify_api")
     */
    public function index()
    {
        return $this->render('spotify_api/index.html.twig', [
            'controller_name' => 'SpotifyApiController',
        ]);
    }
}
