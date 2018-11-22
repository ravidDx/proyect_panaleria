<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConfiguracionController extends AbstractController
{
    /**
     * @Route("/configuracion", name="configuracion")
     */
    public function index()
    {
        return $this->render('configuracion/index.html.twig', [
            'controller_name' => 'ConfiguracionController',
        ]);
    }
}
