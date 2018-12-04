<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Form\FacturaType;
use App\Repository\FacturaRepository;
use App\Repository\ProductoRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FacturaController extends AbstractController
{
    /**
     * @Route("/factura", name="factura")
     */
    public function index(FacturaRepository $facturaRepository, ProductoRepository $productoRepository)
    {

    	$form_new= $this->getFormNew();

        return $this->render('factura/index.html.twig', [
            'form_new'=>$form_new->createView(),
            'facturas' => $facturaRepository->findAll(),
            'productos' => $productoRepository->findAll()
        ]);
    }


    public function getFormNew(){ 

        $factura = new Factura();
        $form = $this->createForm(FacturaType::class, $factura);

        return $form;

    }


}
