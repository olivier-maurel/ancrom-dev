<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
       
        $server = [
            'host' => $request->server->get('HTTP_HOST'),
            'status' => $request->server->get('REDIRECT_STATUS'),
            'agent' => $request->server->get('HTTP_USER_AGENT'),
            'protocol' => explode('/', $request->server->get('SERVER_PROTOCOL'))[0],
            'addrip' => $request->server->get('REMOTE_ADDR'),
            'method' => $request->server->get('REQUEST_METHOD'),
            'cache' => $request->server->get('HTTP_CACHE_CONTROL'),
        ];

        return $this->render('index/index.html.twig', [
            'server' => $server
        ]);
    }

    #[Route('/change/page', name: 'app_change_page')]
    public function changePage(Request $request): Response
    {
        $page = $request->query->get('page');

        if (is_file('../templates/index/_'.$page.'.html.twig'))
            $html = $this->renderView('index/_'.$page.'.html.twig');
        else 
            $html = false;

        return new JsonResponse([
            'html' => $html
        ]);
    }

    #[Route('/change/window', name: 'app_change_window')]
    public function changeWindow(Request $request): Response
    {
        $app = $request->query->get('app');

        if (is_dir('../templates/window/'.$app))
            $html = [
                'head' => $this->renderView('window/'.$app.'/_head.html.twig'),
                'body' => $this->renderView('window/'.$app.'/_body.html.twig')
            ];
        else 
            $html = false;

        return new JsonResponse([
            'html' => $html
        ]);
    }
}
