<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ImageController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {}

    #[Route('/', name: 'app_images', methods: ['GET'])]
    public function index(): Response
    {
        $response = $this->client->request('GET', 'http://127.0.0.1:8002/api/images')->toArray();
        $images = $response['member'];

        return $this->render('image/index.html.twig', [
            'images' => $images,
        ]);
    }

    #[Route('/image', name: 'app_image_detail', methods: ['POST'])]
    public function detail(Request $request): Response
    {
        $url = $request->request->get('url');
        $filename = basename($url);
        $name = $request->request->get('name');

        return $this->render('image/detail.html.twig', [
            'url' => $url,
            'name' => $name,
            'filename' => $filename,
        ]);
    }
}
