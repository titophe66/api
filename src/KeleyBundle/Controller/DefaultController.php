<?php

namespace KeleyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KeleyBundle:Default:index.html.twig');
    }
}
