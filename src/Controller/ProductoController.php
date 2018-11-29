<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{
    /**
     * @Route("/producto", name="producto")
     */
    public function index(ProductoRepository $productoRepository)
    {

    	$form_new= $this->getFormNew();

         return $this->render('producto/index.html.twig', [
            'form_new'=>$form_new->createView(),
            'productos' => $productoRepository->findAll()
        ]);
    }



    public function getFormNew(){ 

        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);

        return $form;

    }

}
