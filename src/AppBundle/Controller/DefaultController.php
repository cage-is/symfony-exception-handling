<?php

namespace AppBundle\Controller;

use AppBundle\Exceptions\DefaultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Exceptions\ExceptionWithCustomResponseBuilder;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
//        throw new ExceptionWithCustomResponseBuilder("This is the message..");
        // replace this example code with whatever you need
        return $this->render('default/abc.html.twig');
    }

    /**
     * @Route("/submit", name="submit")
     */
    public function submitAction(Request $request)
    {
        throw new DefaultException("Message is required!");
        // replace this example code with whatever you need
        return $this->render('default/abc.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

}
