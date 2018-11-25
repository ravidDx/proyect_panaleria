<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
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
 * @Route("/cliente")
 */
class ClienteController extends AbstractController
{


    /**
     * @Route("/", name="cliente_index", methods="GET")
     */
    public function index(ClienteRepository $clienteRepository): Response
    {

        $form_new= $this->getFormNew();

        return $this->render('cliente/index.html.twig', [
             'form_new'=>$form_new->createView(),
            'clientes' => $clienteRepository->findAll()

        ]);
    }


    /**
     * @Route("/new/ajax", name="cliente_new_ajax")
     */
    public function newAjax(Request $request){ 

        if ($request->isXmlHttpRequest()) 
        {
            $data = $request->request->get('cliente');
            $cliente = new Cliente();

            $cliente->setNombre($data['nombre']);
            $cliente->setEmail($data['email']);
            $cliente->setDireccion($data['direccion']);
            $cliente->setCedula($data['cedula']);
            $cliente->setFechaCreacion(new \DateTime(date($data['fecha'] )) );

            $em = $this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $result = $serializer->serialize($cliente, 'json');

            return new JsonResponse($result);
        }

        return new JsonResponse("Error server");

    }

    /**
     * @Route("/list/ajax", name="cliente_list_ajax")
     */
    public function listAjax(ClienteRepository $clienteRepository){

        
        $clientes = $clienteRepository->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($clientes, 'json');

         return new JsonResponse($jsonContent);

    }

 

    /**
     * @Route("/{id}", name="cliente_show", methods="GET")
     */
    public function show(Cliente $cliente): Response
    {
        return $this->render('cliente/show.html.twig', ['cliente' => $cliente]);
    }

    /**
     * @Route("/edit/ajax", name="cliente_edit_ajax", methods="GET|POST")
     */
    public function edit(Request $request): Response
    {

        if ($request->isXmlHttpRequest()) 
        {
            $data = $request->request->get('cliente');
            $id = $data['id'];

            $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find($id);
            $cliente->setNombre($data['nombre']);
            $cliente->setEmail($data['email']);
            $cliente->setDireccion($data['direccion']);
            $cliente->setCedula($data['cedula']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return new JsonResponse($cliente->getId());
        }

        return new JsonResponse("Error server");


    }

    /**
     * @Route("/delete/ajax", name="cliente_delete_ajax")
     */
    public function delete(Request $request): Response
    {

        if ($request->isXmlHttpRequest()) 
        {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();

            $cliente= $em->getRepository(Cliente::class)->find($id);
            $em->remove($cliente);
            $em->flush();
            
            return new JsonResponse($id);

        }

        return new JsonResponse("Error server");



        /*
        if ($this->isCsrfTokenValid('delete'.$cliente->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cliente);
            $em->flush();
        }
        */

        
    }



    public function getFormNew(){ 

        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);

        return $form;

    }


}
