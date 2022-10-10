<?php

namespace App\Controller;

use App\Entity\Application;
use App\Repository\ApplicationRepository;
use App\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, ApplicationService $appService): Response
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
            'server' => $server,
            'setting' => $appService->getSettingCookie($request)
        ]);
    }

    #[Route('/change/page', name: 'app_change_page')]
    public function changePage(Request $request, ApplicationService $appService): Response
    {
        $page = $request->query->get('page');

        if (is_file('../templates/index/_'.$page.'.html.twig')) 
            $html = $this->renderView(
                'index/_page.html.twig', 
                $appService->getParametersPage($page)
            );
        else 
            $html = false;

        return new JsonResponse([
            'html' => $html
        ]);
    }

    #[Route('/change/window', name: 'app_change_window')]
    public function changeWindow(Request $request, ApplicationService $appService): Response
    {
        $app     = $request->query->get('app');
        $explode = explode('_',$app);

        if (count($explode) > 1)
            $app    = $explode[0];

        $param  = [
            'param' => ((isset($explode[1])) ? $explode[1] : null),
            'setting' => $appService->getSettingCookie($request)
        ];

        if (is_dir('../templates/window/'.$app))
            $html = [
                'head' => $this->renderView('window/'.$app.'/_head.html.twig', $param),
                'body' => $this->renderView('window/'.$app.'/_body.html.twig', $param)
            ];
        else 
            $html = false;

        return new JsonResponse([
            'html' => $html
        ]);
    }

    #[Route('/change/setting', name: 'app_change_setting')]
    public function changeSetting(Request $request, ApplicationService $appService): Response
    {
        $appService->setSettingCookie($request);

        return new JsonResponse([
            'html' => 'ok'
        ]);
    }

    #[Route('/open/file', name: 'app_open_file')]
    public function openFile(Request $request): BinaryFileResponse
    {
        $file = $request->query->get('file');

        return new BinaryFileResponse('assets/file/'.$file);
    }

    #[Route('/display/window', name: 'app_display_window')]
    public function displayWindow(Request $request, ApplicationRepository $applicationRepository, Environment $twig): Response
    {
        $idApp     = $request->query->get('application');
        $application = $applicationRepository->findOneById($idApp);
        $content = $application->getApplicationContent();
        
        // $header = $twig->createTemplate($content->getHeader());
        $header = $this->renderView('window/'.$content->getBody().'/_head.html.twig', ['application' => $application]);
        $body = $this->renderView('window/'.$content->getBody().'/_body.html.twig', ['application' => $application]);

        return new JsonResponse([
            'html' => [
                'head' => $header,
                'body' => $body
            ]
        ]);
    }
}
