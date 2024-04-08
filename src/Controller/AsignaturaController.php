<?php

namespace App\Controller;

use App\Repository\AsignaturaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AsignaturaController extends AbstractController
{
    #[Route('/asignaturas', name: 'ver_asignaturas')]

    public function ver_asignaturas(AsignaturaRepository $asignaturaRepo): Response
    {

        $asignaturas = $asignaturaRepo ->findAll();


        return $this->render('asignatura/index.html.twig', [
            'asignaturas' => $asignaturas
        ]);
    }


    #[Route('/asignatura/{id}/alumnos', name: 'alumnos_en_asignatura')]

    public function ver_alumnos_en_asignatura(int $id,AsignaturaRepository $asignaturaRepo): Response
    {

        $asignaturas = $asignaturaRepo ->find($id);


        return $this->render('asignatura/index.html.twig', [
            'asignaturas' => $asignaturas -> getAlumnos()
        ]);
    }
}
