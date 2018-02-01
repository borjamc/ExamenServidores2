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
   * @Route("/inicio", name="index")
   */
  public function indexAction()
  {
      return $this->render('TurismoBundle:Default:inicio.html.twig');
  }

  /**
   * @Route("/datos", name="datos")
   */
  public function datosAction()
  {
      return $this->render('TurismoBundle:Default:datos.html.twig');
  }

  /**
   * @Route("/listado", name="listado")
   */
  public function listadoAction()
  {
      return $this->render('TurismoBundle:Default:listado.html.twig');
  }
}
