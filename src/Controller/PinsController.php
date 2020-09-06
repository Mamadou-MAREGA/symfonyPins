<?php

namespace App\Controller;

use App\Entity\Pins;
use App\Form\PinType;
use App\Repository\PinsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods="GET")
     */
    public function index(PinsRepository $pinsRepository): Response
    {
        $pins = $pinsRepository->findBy([], ['createdAt' => 'DESC'] );
        return $this->render('pins/index.html.twig',compact('pins'));
    }

    /**
     * @Route("/pins/create", name="app_pins_create", methods="GET|POST")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pin = new Pins();

        $form = $this->createForm(PinType::class, $pin);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //$pin = $form->getData();
            $entityManager->persist($pin);
            $entityManager->flush();

            $this->addFlash("success", "Pin succefully created");

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/pins/{id<[0-9]+>}/edit", name="app_pins_edit", methods={"GET", "PUT"})
     */
    public function edit(Pins $pin, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PinType::class, $pin, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            $this->addFlash("success", "Pin succefully updated");

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/edit.html.twig', [
            "pin" => $pin ,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/pins/{id<[0-9]+>}/delete", name="app_pins_delete", methods="DELETE")
     */

    public function delete(Pins $pin, EntityManagerInterface $entityManager, Request $request): Response
    {
        if ($this->isCsrfTokenValid('pin_delete' . $pin->getId(), $request->request->get('csrf_token')))
        {
            $entityManager->remove($pin);
            $entityManager->flush();
            $this->addFlash("info", "Pin succefully deleted");
        }

        return $this->redirectToRoute('app_home');
    }


    /**
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show",  methods="GET")
     */
    public function show(Pins $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }


}
