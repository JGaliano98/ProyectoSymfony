<?php

namespace App\Controller;

use App\Repository\AlumnoRepository;
use App\Repository\TutorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TutorController extends AbstractController
{
    #[Route('/tutor/{id}', name: 'tutor_id')]

    public function tutorID(int $id, TutorRepository $tutorRepo): Response
    {


        $tutor = $tutorRepo -> find($id);


        return $this->render('/tutor/tutor.html.twig', [
            'tutor' => $tutor,
        ]);
    }
    
    #[Route('/tutores', name: 'todo_tutor')]

    public function verTutores( TutorRepository $tutorRepo): Response
    {


        $tutores = $tutorRepo -> findAll();


        return $this->render('/tutor/ver_tutores.html.twig', [
            'tutores' => $tutores
        ]);
    }

    #[Route('/tutor/{id}/alumnos', name: 'alumnos_tutor')]

    public function verAlumnosDeTutor(int $id, TutorRepository $tutorRepo): Response
    {

        $tutor = $tutorRepo ->find($id);

 


        return $this->render('/tutor/ver_alumnos.html.twig', [
            'alumnos' => $tutor->getAlumnos()
        ]);
    }



}