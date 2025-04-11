<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use GuzzleHttp\Client;


final class ImageUploaderToApiController extends AbstractController
{
    #[Route('/image/uploader', name: 'app_image_uploader_to_api')]
    public function uploadImageToApi():Response      

    {
        try {

            $client = new Client();

            // Envoie de l'image via la méthode POST vers l'api via la route upload/images (voir imageUploaderController sur le serveur api)
            $client->post('http://localhost:8002/upload/images', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen('C:\Users\Decks\Pictures\Cyberpunk 2077\photomode_10042025_234038.png', 'r'),
                        'filename' => 'limage.jpg',
                    ],
                ],
            ]);
            // Redirection vers la liste des images
            return $this->redirectToRoute('app_images');
            
            

        }
        catch(\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }
}
