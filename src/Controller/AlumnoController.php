<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Repository\AlumnoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AlumnoController extends AbstractController
{
    #[Route('/crearAlumno', name: 'crear_alumno')]
    public function createAlumno(EntityManagerInterface $entityManager): Response
    {
        $alumno = new Alumno();
        $alumno ->setNombre('Mariangeles');
        $alumno ->setApellido('Galiano');
        $alumno ->setFechaNacimiento(DateTime::createFromFormat('j-M-Y', '02-Apr-2024'));
        $alumno ->setFoto('2');

        $entityManager->persist($alumno);

        $entityManager->flush();




        return $this->render('alumno/crear_alumno.html.twig', [
            'alumno' => $alumno
        ]);
    }

    #[Route('/alumno/{id}', name: 'alumno_id')]

    public function alumnoID(int $id, AlumnoRepository $alumnoRepo): Response
    {


        $alumno = $alumnoRepo -> find($id);


        return $this->render('/alumno/ver_alumno.html.twig', [
            'alumno' => $alumno,
        ]);
    }

    #[Route('/alumnos', name: 'todo_alumno')]

    public function verAlumnos( AlumnoRepository $alumnoRepo): Response
    {


        $alumnos = $alumnoRepo -> findAll();


        return $this->render('/alumno/ver_alumnos.html.twig', [
            'alumnos' => $alumnos,
        ]);
    }

    #[Route('/alumno/{id}/tutor', name: 'tutor_alumno')]

    public function verTutorDeAlumno(int $id, AlumnoRepository $alumnoRepo): Response
    {

        $alumno = $alumnoRepo ->find($id);


        return $this->render('/alumno/ver_tutor.html.twig', [
            'tutor' => $alumno->getTutor()
        ]);
    }

    #[Route('/alumno/{id}/asignaturas', name: 'alumno_asignaturas')]

    public function verAsignaturasDeAlumno(int $id, AlumnoRepository $alumnoRepo): Response
    {

        $alumno = $alumnoRepo ->find($id);


        return $this->render('/alumno/ver_asignaturas.html.twig', [
            'asignaturas' => $alumno->getAsignatura()
        ]);
    }
}
