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
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/change/page', name: 'app_change_page')]
    public function contact(Request $request): Response
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
}
