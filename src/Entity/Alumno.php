<?php

namespace App\Entity;

use App\Repository\AlumnoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlumnoRepository::class)]
class Alumno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 50)]
    private ?string $apellido = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaNacimiento = null;

    #[ORM\Column(length: 255)]
    private ?string $Foto = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Tutor $tutor = null;

    #[ORM\ManyToMany(targetEntity: Asignatura::class, inversedBy: 'alumnos')]
    private Collection $asignatura;

    #[ORM\OneToMany(targetEntity: Nota::class, mappedBy: 'alumno')]
    private Collection $notas;

    public function __construct()
    {
        $this->asignatura = new ArrayCollection();
        $this->notas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->FechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $FechaNacimiento): static
    {
        $this->FechaNacimiento = $FechaNacimiento;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->Foto;
    }

    public function setFoto(string $Foto): static
    {
        $this->Foto = $Foto;

        return $this;
    }

    public function getTutor(): ?Tutor
    {
        return $this->tutor;
    }

    

    public function setTutor(?Tutor $tutor): self
    {
        $this->tutor = $tutor;
        return $this;
    }

    public function getTutorId(): ?int {
        return $this->tutor ? $this->tutor->getId() : null;
    }

    /**
     * @return Collection<int, Asignatura>
     */
    public function getAsignatura(): Collection
    {
        return $this->asignatura;
    }

    public function addAsignatura(Asignatura $asignatura): static
    {
        if (!$this->asignatura->contains($asignatura)) {
            $this->asignatura->add($asignatura);
        }

        return $this;
    }

    public function removeAsignatura(Asignatura $asignatura): static
    {
        $this->asignatura->removeElement($asignatura);

        return $this;
    }

    /**
     * @return Collection<int, Nota>
     */
    public function getNotas(): Collection
    {
        return $this->notas;
    }

    public function addNota(Nota $nota): static
    {
        if (!$this->notas->contains($nota)) {
            $this->notas->add($nota);
            $nota->setAlumno($this);
        }

        return $this;
    }

    public function removeNota(Nota $nota): static
    {
        if ($this->notas->removeElement($nota)) {
            // set the owning side to null (unless already changed)
            if ($nota->getAlumno() === $this) {
                $nota->setAlumno(null);
            }
        }

        return $this;
    }
}
