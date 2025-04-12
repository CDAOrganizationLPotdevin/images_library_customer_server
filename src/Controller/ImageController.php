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
        $response = $this->client->request('GET', 'http://127.0.0.1:8002/images')->toArray();
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

    #[Route('/image/add', name: 'app_image_add', methods: ['GET', 'POST'])]
    public function add_image(Request $request): Response
    {
        return $this->render('image/add_image.html.twig');
    }

    #[Route('/image/download', name:'app_image_download', methods: ['GET'])]
    public function proxyImage(Request $request): Response
    {
        $client = HttpClient::create();

        try {
            $url = $request->query->get('url');
            $imageResponse = $client->request('GET', $url);
            
            if ($imageResponse->getStatusCode() !== 200) {
                throw new \Exception('Erreur lors du téléchargement de l\'image.');
            }

            $response = new Response($imageResponse->getContent());
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Content-Type', $imageResponse->getHeaders()['content-type'][0]);


            $filename = basename($url);
            $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');


            return $response;

        } catch (\Exception $e) {
            return new Response('Erreur: ' . $e->getMessage(), 500);
        }
    }
}
