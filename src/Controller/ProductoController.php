<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


/**
 * @Route("/producto")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/", name="producto_index")
     */
    public function index(ProductoRepository $productoRepository)
    {

    	$form_new= $this->getFormNew();

         return $this->render('producto/index.html.twig', [
            'form_new'=>$form_new->createView(),
            'productos' => $productoRepository->findAll()
        ]);


    }


    /**
    * @Route("/new/ajax", name="producto_new_ajax")
    */
    public function newAjax(Request $request){ 

        if ($request->isXmlHttpRequest()) 
        {
            $data = $request->request->get('producto');
            $producto = new Producto();

            $producto->setBarcode($data['barcode']);
            $producto->setNombre($data['nombre']);
            $producto->setIsIva($data['isIva']);
            $producto->setCantPack($data['cantPack']);
            $producto->setCantUnit($data['cantUnit']);
            $producto->setCantTotal($data['cantTotal']);
            $producto->setPrecioPack($data['precioPack']);
            $producto->setPrecioUnit($data['precioUnit']);
            $producto->setFchIngreso(new \DateTime(date($data['fchIngreso'] )) );

            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $result = $serializer->serialize($producto, 'json');

            return new JsonResponse($result);
        }

        return new JsonResponse("Error server");

    }



    public function getFormNew(){ 

        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);

        return $form;

    }

}
