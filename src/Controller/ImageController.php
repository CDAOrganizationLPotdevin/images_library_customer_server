<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ImageController extends AbstractController
{
    #[Route('/', name: 'app_images', methods: ['GET'])]
    public function index(): Response
    {
        $images = [
            ['url' => 'http://127.0.0.1:8002/images/chacripan.jpeg', 'name' => 'chacripan'],
            ['url' => 'http://127.0.0.1:8002/images/chat.jpeg', 'name' => 'chat'],
            ['url' => 'http://127.0.0.1:8002/images/chat2.jpeg', 'name' => 'chat2'],
            ['url' => 'http://127.0.0.1:8002/images/chat3.jpeg', 'name' => 'chat3'],
            ['url' => 'http://127.0.0.1:8002/images/chat4.jpeg', 'name' => 'chat4'],
            ['url' => 'http://127.0.0.1:8002/images/chat5.jpeg', 'name' => 'chat5'],
            ['url' => 'http://127.0.0.1:8002/images/jetevois.jpg', 'name' => 'jetevois'],
            ['url' => 'http://127.0.0.1:8002/images/chat6.jpeg', 'name' => 'chat6'],
            ['url' => 'http://127.0.0.1:8002/images/chat7.jpeg', 'name' => 'chat7'],
            ['url' => 'http://127.0.0.1:8002/images/chat_a_la_retraite.jpeg', 'name' => 'chat_a_la_retraite'],
            ['url' => 'http://127.0.0.1:8002/images/chat_affreux.jpeg', 'name' => 'chat_affreux'],
            ['url' => 'http://127.0.0.1:8002/images/chat_alien.jpeg', 'name' => 'chat_alien'],
            ['url' => 'http://127.0.0.1:8002/images/chat_appi.jpeg', 'name' => 'chat_appi'],
            ['url' => 'http://127.0.0.1:8002/images/chat_dev.jpeg', 'name' => 'chat_dev'],
            ['url' => 'http://127.0.0.1:8002/images/chat_fleur.jpeg', 'name' => 'chat_fleur'],
            ['url' => 'http://127.0.0.1:8002/images/chat_fraise.jpeg', 'name' => 'chat_fraise'],
            ['url' => 'http://127.0.0.1:8002/images/chat_magique.jpeg', 'name' => 'chat_magique'],
            ['url' => 'http://127.0.0.1:8002/images/chat_peur_effro.jpeg', 'name' => 'chat_peur_effro'],
            ['url' => 'http://127.0.0.1:8002/images/chat_se_moque.jpeg', 'name' => 'chat_se_moque'],
            ['url' => 'http://127.0.0.1:8002/images/chat_sourcil.jpeg', 'name' => 'chat_sourcil'],
            ['url' => 'http://127.0.0.1:8002/images/chat_toutriste.jpeg', 'name' => 'chat_toutriste'],
            ['url' => 'http://127.0.0.1:8002/images/chat_uwu.jpeg', 'name' => 'chat_uwu'],
            ['url' => 'http://127.0.0.1:8002/images/chatmoche.jpeg', 'name' => 'chatmoche'],
        ];

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
