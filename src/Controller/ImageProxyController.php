<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Attribute\Route;

class ImageProxyController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    // Méthode permettant la récupération et l'affichage d'une image

    #[Route('/image_proxy_display/{id}', name: 'app_image_proxy_display')]
    public function fetchImage(Request $request, int $id): Response
    {


        $apiUrl = "http://localhost:8002/image-display/$id";
            

        // Faire une requête vers le serveur API
        $response = $this->httpClient->request('GET', $apiUrl);

        // Vérifie si l'image a été récupérée avec succès
        if ($response->getStatusCode() !== 200) {
            return new Response('Image not found', 404);
        }

        $content = $response->getContent();
        $mimeType = $response->getHeaders()['content-type'][0];
        
        $test = new Response($content, 200, ['Content-Type' => $mimeType]);
        return $test ; 
    }
    // Route permettant la récupération et le téléchargement d'une image
    #[Route('/image_proxy_download/{id}', name: 'app_image_proxy_download')]
    public function downloadImage(Request $request, int $id): Response
    {



        try {
            $apiUrl = "http://localhost:8002/image-download/$id";
            
            $imageResponse = $this->httpClient->request('GET', $apiUrl);
            
            if ($imageResponse->getStatusCode() !== 200) {
                throw new \Exception('Erreur lors du téléchargement de l\'image.');
            }

            $response = new Response($imageResponse->getContent());
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Content-Type', $imageResponse->getHeaders()['content-type'][0]);


           
            $response->headers->set('Content-Disposition', 'attachment; filename="' . $id . '.jpeg"');


            return $response;

        } catch (\Exception $e) {
            return new Response('Erreur: ' . $e->getMessage(), 500);
        }
    }
}