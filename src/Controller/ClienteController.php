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

        $data = $request->request->get('cliente');
        $cliente = new Cliente();

        $cliente->setNombre($data['nombre']);
        $cliente->setEmail($data['email']);
        $cliente->setDireccion($data['direccion']);
        $cliente->setCedula($data['cedula']);
        $cliente->setFechaCreacion(new \DateTime(date('d-m-Y')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($cliente);
        $em->flush();

        return new JsonResponse($cliente->getId());

    }

 

    /**
     * @Route("/{id}", name="cliente_show", methods="GET")
     */
    public function show(Cliente $cliente): Response
    {
        return $this->render('cliente/show.html.twig', ['cliente' => $cliente]);
    }

    /**
     * @Route("/{id}/edit", name="cliente_edit", methods="GET|POST")
     */
    public function edit(Request $request, Cliente $cliente): Response
    {
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliente_index', ['id' => $cliente->getId()]);
        }

        return $this->render('cliente/edit.html.twig', [
            'cliente' => $cliente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cliente_delete", methods="DELETE")
     */
    public function delete(Request $request, Cliente $cliente): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cliente->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cliente);
            $em->flush();
        }

        return $this->redirectToRoute('cliente_index');
    }



    public function getFormNew(){ 

        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);

        return $form;

    }


}
