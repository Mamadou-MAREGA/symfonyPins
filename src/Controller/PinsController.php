<?php

namespace App\Controller;

use App\Entity\Pins;
use App\Repository\PinsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinsRepository $pinsRepository): Response
    {
        $pins = $pinsRepository->findBy([], ['createdAt' => 'DESC'] );
        return $this->render('pins/index.html.twig',compact('pins'));
    }

    /**
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show")
     */
    public function show(Pins $pin)
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }
}
