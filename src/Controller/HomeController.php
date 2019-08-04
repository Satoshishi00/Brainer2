<?php
namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index() : Response
    {

        $user = $this->getUser();
        if ($user == null){
            return $this->render('pages/home.html.twig');
        }
        return $this->render('pages/home.html.twig', [
            'user' => $user
        ]);
    }
}