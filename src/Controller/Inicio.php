<?php

namespace App\Controller;

use App\Repository\AlumnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Inicio extends AbstractController
{
    #[Route('/inicio/{hola}', name: 'hola')]

    
    public function hola(string $hola, AlumnoRepository $alumnoRepo): Response
    {

        //$personas = ['Manolo', 'Antonio', 'Clara', 'Paula'];

        $personas = $alumnoRepo->findAll();

        return $this->render('inicio.html.twig', [
            'hola' => $hola,
            'personas' => $personas
        ]);
    }
}