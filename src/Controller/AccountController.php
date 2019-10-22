<?php

namespace App\Controller;

use App\Entity\Option;
use App\Entity\Media;
use App\Entity\File;
use App\Entity\Property;
use App\Form\MediaFormType;
use App\Form\UserFormType;
use App\Form\PropertyType;
use App\Form\EditAccountFormType;
use App\Form\EditImageAccountFormType;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller
 */
class AccountController extends AbstractController
{

    public function __construct(UserRepository $repository, ObjectManager $em)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('account/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/account/edit", name="account/edit")
     */
    public function edit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditAccountFormType::class, $user);
        $media = new Media();
        //dd($media);
        //$form += $this->createForm(MediaFormType::class, $media);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
            dd($form);

        }

        return $this->render('account/edit.html.twig', [
            'editAccountForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account/edit/image", name="account/edit/image")
     */
    public function editImage(Request $request)
    {
        $user = $this->getUser();
        $media = $user->getImage();
        $form = $this->createForm(MediaFormType::class, $media);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($media);
            $entityManager->flush();

            $media->setImageFile();

            return $this->render('account/index.html.twig', [
                'user' => $user
            ]);
        }

        return $this->render('account/edit.html.twig', [
            'editAccountForm' => $form->createView(),
        ]);
    }

}
