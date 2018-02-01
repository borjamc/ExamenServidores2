<?php

namespace UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UsuariosBundle\Entity\Usuarios;
use UsuariosBundle\Form\UsuariosType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/usuarios", name="usuarios")
     */
    public function allAction()
    {
        $repository = $this->getDoctrine()->getRepository('UsuariosBundle:Usuarios');
        $usuario = $repository->findAll();
        return $this->render('UsuariosBundle:Default:all.html.twig',array("usuarios"=>$usuario));
    }

    /**
       * @Route("/usuarios/registro", name="registro")
       */
      public function registroAction(Request $request)
      {
          // 1) build the form
          $user = new Usuarios();
          $form = $this->createForm(UsuariosType::class, $user);

          // 2) handle the submit (will only happen on POST)
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {

              // 3) Encode the password (you could also do this via Doctrine listener)
              $password = $this->get('security.password_encoder')
                  ->encodePassword($user, $user->getPlainPassword());
              $user->setPassword($password);

              // 4) save the User!
              $em = $this->getDoctrine()->getManager();
              $em->persist($user);
              $em->flush();

              // ... do any other work - like sending them an email, etc
              // maybe set a "flash" success message for the user

              return $this->redirectToRoute('usuarios');
          }

          return $this->render(
              'UsuariosBundle:Default:registro.html.twig',
              array('form' => $form->createView())
          );
      }

      /**
     * @Route("/usuarios/editarusuario/{id}", name="editar")
     */
    public function editarUsuarioAction(Request $request, $id)
    {
      $user=$this->getDoctrine()->getRepository(Usuarios::class)->find($id);
      $form=$this->createForm(UsuariosType::class, $user);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->persist($user);
         $em->flush();
         return $this->redirectToRoute('usuarios');
       }
      return $this-> render('UsuariosBundle:Default:registro.html.twig', array('form'=>$form->createView()));
    }


    /**
    * @Route("/usuarios/borrar/{id}", name="borrar")
    */
    public function borrarAction($id)
    {
      $db=$this->getDoctrine()->getManager();
      $eliminar = $db ->getRepository(Usuarios::class)->find($id);
      $db->remove($eliminar);
      $db->flush();
        return $this->redirectToRoute('usuarios');
    }

    /**
     * @Route("/usuarios/login", name="login")
     */
    public function loginAction(Request $request)
    {
      $authenticationUtils = $this->get('security.authentication_utils');

      // get the login error if there is one
      $error = $authenticationUtils->getLastAuthenticationError();

      // last username entered by the user
      $lastUsername = $authenticationUtils->getLastUsername();

      return $this->render('UsuariosBundle:Default:login.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
      ));
    }
}
