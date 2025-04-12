<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use GuzzleHttp\Client;


final class ImageUploaderToApiController extends AbstractController
{
    #[Route('/image/uploader', name: 'app_image_uploader_to_api', methods: ['POST'])]
    public function uploadImageToApi(Request $request):Response

    {
        try {
            $client = new Client();
            $uploadedFile = $request->files->get('uploaded_image');
            $name = $request->request->get('name');
            $contents = $uploadedFile->getRealPath();



            $client->post('http://localhost:8002/upload/images', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen($contents, 'r'),
                        'filename' => $name,
                    ],
                ],
            ]);
            
            return $this->redirectToRoute('app_images');
            
            

        }
        catch(\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }
}
