<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 12/22/18
 * Time: 1:29 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

}