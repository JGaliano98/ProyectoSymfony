<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Form\Type\AlumnoType;
use App\Repository\AlumnoRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AlumnoController extends AbstractController
{
    #[Route('/crearAlumno', name: 'crear_alumno')]
    public function createAlumno(EntityManagerInterface $entityManager, Request $request): Response
    {
        $alumno = new Alumno();
        $alumno ->setNombre('Mariangeles');
        $alumno ->setApellido('Galiano');
        $alumno ->setFechaNacimiento(DateTime::createFromFormat('j-M-Y', '02-Apr-2024'));
        $alumno ->setFoto('2');
        $alumno ->getTutorId();


        $form = $this->createForm(AlumnoType::class, $alumno);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $alumno = $form->getData();

            $entityManager->persist($alumno);

            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }



        return $this->render('prueba.html.twig', [
            'form' => $form
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

    #[Route('/index', name: 'inicio_alumnos')]

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

        //$alumno = $alumnoRepo ->find($id);

        $asignaturas = $alumnoRepo -> verAsignaturasAlumno($id);


        return $this->render('/alumno/ver_asignaturas.html.twig', [
            'asignaturas' => $asignaturas
        ]);
    }

    #[Route('/editar/{id}', name: 'alumno_editar')]

    public function editarAlumno(int $id, AlumnoRepository $alumnoRepo, Request $request, EntityManagerInterface $em): Response
    {

        $alumno = $alumnoRepo ->find($id);

        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($alumno);
            $em->flush();
    
            $this->addFlash('success', 'Alumno actualizado correctamente.');
            return $this->redirectToRoute('inicio_alumnos'); // Asumiendo que tienes una ruta definida para listar alumnos
        }



        return $this->render('/alumno/editar_alumno.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/borrar/{id}', name: 'alumno_borrar')]

    public function borrarAlumno(int $id, AlumnoRepository $alumnoRepo,EntityManagerInterface $em): Response
    {

        $alumno = $alumnoRepo ->find($id);

        $em->remove($alumno);
        $em->flush();

        return $this->redirectToRoute('inicio_alumnos');

    }

    #[Route('/new', name: 'alumno_crear')]
    
    public function crearAlumno(Request $request, EntityManagerInterface $em): Response
    {
        $alumno = new Alumno();

        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($alumno);
            $em->flush();

            $this->addFlash('success', 'Alumno creado correctamente.');
            return $this->redirectToRoute('inicio_alumnos');
        }

        return $this->render('/alumno/crear_alumno.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/listaAlumnos/{letra}', name: 'alumno_listar')]
    
    public function listaAlumnosA(string $letra, AlumnoRepository $alumnoRepo): Response
    {
        
       $alumnos = $alumnoRepo ->buscarApellidosPorA($letra);

       // $alumnos = $alumnoRepo ->paginaCinco();

        return $this->render('/alumno/ver_alumnos.html.twig', [
            'alumnos' => $alumnos,
        ]);
    }

    #[Route('/cuantosAlumnos', name: 'alumno_contar')]
    
    public function cuentaAlumno( AlumnoRepository $alumnoRepo): Response
    {
        
       $alumnos = $alumnoRepo ->cuantosHay();


        return $this->render('/alumno/cuantosHay.html.twig', [
            'totalAlumnos' => $alumnos,
        ]);
    }

    #[Route('/Alumnos/{page}/{pagesize}', name: 'paginar')]

    public function paginacion(AlumnoRepository $alumnoRepo, int $page, int $pagesize): Response
    {
        // Obtener el número total de alumnos
        $totalAlumnos = $alumnoRepo->cuantosHay();
        $totalPages = ceil($totalAlumnos / $pagesize);

        // Obtener los alumnos para la página actual
        $alumnos = $alumnoRepo->paginacion($page, $pagesize);

        return $this->render('/alumno/ver_alumnos.html.twig', [
            'alumnos' => $alumnos,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'pagesize' => $pagesize
        ]);
    }

    #[Route('/contar', name: 'contar')]

    public function contarAsig(AlumnoRepository $alumnoRepo): Response
    {
        
        $conteoAsignaturas = $alumnoRepo->contarAsignaturasPorAlumno();


        return $this->render('/alumno/conteo_asignaturas.html.twig', [
            
            'conteoAsignaturas' => $conteoAsignaturas

        ]);
    }
    
}
