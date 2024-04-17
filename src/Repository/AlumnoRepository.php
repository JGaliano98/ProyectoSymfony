<?php

namespace App\Repository;

use App\Entity\Alumno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Alumno>
 *
 * @method Alumno|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alumno|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alumno[]    findAll()
 * @method Alumno[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlumnoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alumno::class);
    }

    public function buscarApellidosPorA( string $letra): array
    {
     
        $qb = $this->createQueryBuilder('a')
         ->where('a.apellido LIKE :letra')
         ->setParameter('letra', $letra.'%');

        $query = $qb->getQuery();

        return $query->execute();

    }

    public function paginaCinco(): array
    {

        $qb = $this->createQueryBuilder('a');
        $qb->setMaxResults(5); 

        
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function cuantosHay(): int
    {

        $qb = $this->createQueryBuilder('a');
        $qb->select('count(a.id)');

        
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    
    public function paginacion (int $pagina, int $tamaño): array
    {

        $qb = $this->createQueryBuilder('a');

        $qb -> setFirstResult(($pagina -1) * $tamaño)
        ->setMaxResults($tamaño);

    
        return $qb -> getQuery()->getResult();
    }

    public function verAsignaturasAlumno(int $id): array
{
    $qb = $this->createQueryBuilder('a');
    $qb->select('asig.id, asig.nombre')
        ->innerJoin('a.asignatura', 'asig')
        ->where('a.id = :id')
        ->setParameter('id', $id);

    return $qb->getQuery()->getResult();
}



public function contarAsignaturasPorAlumno()
{
    $qb = $this->createQueryBuilder('a');
    $qb->select('a.nombre, COUNT(asignatura.id) AS num_asignaturas')
       ->leftJoin('a.asignatura', 'asignatura')
       ->groupBy('a.id, a.nombre');

    return $qb->getQuery()->getResult();
}

    //    /**
    //     * @return Alumno[] Returns an array of Alumno objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Alumno
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
