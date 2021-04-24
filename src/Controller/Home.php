<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route(path="/", name="home")
 */
final class Home extends AbstractController
{
    public function __invoke(Request $request)
    {
        return $this->render('home.html.twig');
    }
}