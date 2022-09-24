<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class ApplicationService
{
    public function setSettingCookie($request)
    {
        $res        = new Response();
        $param      = (array) json_decode($request->query->get('setting'));
        $settings   = (array) json_decode($request->cookies->get('settings'));
        $settings[key($param)] = $param[key($param)];
        $cookie     = new Cookie(
            'settings',
            json_encode($settings, true),
            strtotime('+30 days', strtotime('now'))
        );

        $res->headers->setCookie( $cookie );
        $res->send();

        return true;
    }

    public function getSettingCookie($request)
    {
        return (array) json_decode($request->cookies->get('settings'));
    }
}