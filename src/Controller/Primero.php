<?php

namespace App\Controller;

use App\Repository\AlumnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Primero extends AbstractController
{
    #[Route('/saluda/{nombre}', name: 'saluda')]

    public function saluda(string $nombre, AlumnoRepository $alumnoRepo): Response
    {

        $personas = $alumnoRepo->findOneBy(['nombre' => $nombre]);

        return $this->render('saluda.html.twig', [
            'nombre' => $nombre,
            'personas' => $personas
        ]);
    }
}