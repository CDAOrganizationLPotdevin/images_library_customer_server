<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;

final class ImageController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {}

    #[Route('/', name: 'app_images', methods: ['GET'])]
    public function index(): Response
    {
        $response = $this->client->request('GET', 'http://127.0.0.1:8002/api/images?pagination=false')->toArray();
        $images = $response['member'];
        $request = new Request();

        
        return $this->render('image/index.html.twig', [
            'images' => $images,
        ]);
    }

    #[Route('/image', name: 'app_image_detail', methods: ['POST'])]
    public function detail(Request $request): Response
    {
        $url = $request->request->get('id');
        $filename = basename($url);
        $name = $request->request->get('name');

        return $this->render('image/detail.html.twig', [
            'id' => $url,
            'name' => $name,
            'filename' => $filename,
        ]);
    }


}
