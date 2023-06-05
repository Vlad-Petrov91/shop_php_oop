<?php

namespace app\engine;

use app\interfaces\IRender;
use Twig\Loader\FilesystemLoader;


class TwigRender implements IRender
{

    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader,[
        'debug' => true,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function renderTemplate($template, $params = [])
    {
        return $this->twig->render($template . '.twig', $params);
    }
}