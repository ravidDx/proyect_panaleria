<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UsuarioType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/usuario")
 */
class UsuarioController extends AbstractController
{

	private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
       $this->encoder = $encoder;
    }

    /**
     * @Route("/", name="usuario")
     */
    public function index( UserRepository $userRepository )
    {
    	$form_new= $this->getFormNew();

        return $this->render('usuario/index.html.twig', [
            'form_new'=>$form_new->createView(),
            'usuarios' => $userRepository->findAll()
        ]);
    }


    /**
    * @Route("/new/ajax", name="usuario_new_ajax")
    */
    public function newAjax(Request $request){ 

        if ($request->isXmlHttpRequest()) 
        {
            $data = $request->request->get('usuario');
            $usuario = new User();

            $usuario->setNombre($data['nombre']);
            $usuario->setEmail($data['email']);
            $usuario->setUsername($data['username']);

            $usuario->setPassword(
                 $this->encoder->encodePassword($usuario, $data['password'])
            );

            $usuario->setRole('ROLE_ADMIN');


            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $result = $serializer->serialize($usuario, 'json');

            return new JsonResponse($result);
        }

        return new JsonResponse("Error server");

    }


    /**
    * @Route("/edit/ajax", name="usuario_edit_ajax")
    */
    public function edit(Request $request)
    {

        if ($request->isXmlHttpRequest()) 
        {
            $data = $request->request->get('usuario');
            $id = $data['id'];

            $usuario = $this->getDoctrine()->getRepository(User::class)->find($id);
            $usuario->setNombre($data['nombre']);
            $usuario->setEmail($data['email']);
            $usuario->setusername($data['username']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return new JsonResponse($usuario->getId());
        }

        return new JsonResponse("Error server");

    }


    /**
    * @Route("/delete/ajax", name="usuario_delete_ajax")
    */
    public function delete(Request $request)
    {

        if ($request->isXmlHttpRequest()) 
        {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();

            $usuario= $em->getRepository(User::class)->find($id);
            $em->remove($usuario);
            $em->flush();
            
            return new JsonResponse($id);

        }

        return new JsonResponse("Error server");
    
    }




    public function getFormNew(){ 

        $usuario = new User();
        $form = $this->createForm(UsuarioType::class, $usuario);

        return $form;

    }


}
