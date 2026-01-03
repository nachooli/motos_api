<?php

declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entidad de Moto
 */
#[ORM\Entity]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            denormalizationContext: ['groups' => ['motorcycle:create']],
            validationContext: ['groups' => ['motorcycle:create']]
        ),
        new Get(),
        new Put(
            denormalizationContext: ['groups' => ['motorcycle:update']],
            validationContext: ['groups' => ['motorcycle:update']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['motorcycle:update']],
            validationContext: ['groups' => ['motorcycle:update']]
        ),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['motorcycle:read']]
)]
class Moto
{
    /**
     * Id autogenerado de la moto.
     *
     * Se podría hacer en un trait común si se utilizase en más ocasiones, pero debido a la simpleza de la prueba
     * se indica aquí, en la única entidad con id.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['motorcycle:read'])]
    private ?int $id;

    /**
     * Modelo de la moto.
     */
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(groups: ['motorcycle:create', 'motorcycle:update'])]
    #[Assert\Length(max: 50)]
    #[Groups(['motorcycle:read', 'motorcycle:create', 'motorcycle:update'])]
    private string $modelo;

    /**
     * Cilindrada de la moto
     */
    #[ORM\Column]
    #[Assert\NotNull(groups: ['motorcycle:create', 'motorcycle:update'])]
    #[Assert\Positive]
    #[Groups(['motorcycle:read', 'motorcycle:create', 'motorcycle:update'])]
    private int $cilindrada;

    /**
     * Marca de la moto.
     */
    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(groups: ['motorcycle:create', 'motorcycle:update'])]
    #[Assert\Length(max: 40)]
    #[Groups(['motorcycle:read', 'motorcycle:create', 'motorcycle:update'])]
    private string $marca;

    /**
     * Tipo de la moto. No se indica límite de carácteres en el enunciado, pero se le ha asignado uno coherente aún así.
     *
     * Los tipos de moto serán constantes almacenados en el listado de MotoTipoEnum.
     */
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(groups: ['motorcycle:create', 'motorcycle:update'])]
    #[Groups(['motorcycle:read', 'motorcycle:create', 'motorcycle:update'])]
    private string $tipo;

    /**
     * Listado de extras de la moto.
     */
    #[ORM\Column(type: Types::JSON)]
    #[Assert\NotNull(groups: ['motorcycle:create', 'motorcycle:update'])]
    #[Assert\Count(max: 20)]
    #[Assert\All([
        new Assert\Type('string'),
        new Assert\NotBlank()
    ])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'array',
            'items' => ['type' => 'string'],
            'maxItems' => 20
        ]
    )]
    #[Groups(['motorcycle:read', 'motorcycle:create', 'motorcycle:update'])]
    private array $extras;

    /**
     * Peso de la moto (opcional).
     */
    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
    #[Groups(['motorcycle:read', 'motorcycle:create', 'motorcycle:update'])]
    private ?int $peso;

    /**
     * Fecha de creación de la moto.
     * Se crea automáticamente desde MotoProcessor antes de que Doctrine persista el objeto.
     * Se podría hacer también utilizando Doctrine, pero se le da prioridad al uso de ApiPlatform debido a requerimientos de la prueba.
     */
    #[ORM\Column]
    #[Groups(['motorcycle:read'])]
    private DateTimeImmutable $createdAt;

    /**
     * Fecha de actualización de la moto.
     * Se actualiza automáticamente desde MotoProcessor antes de que Doctrine persista el objeto.
     * Se podría hacer también utilizando Doctrine, pero se le da prioridad al uso de ApiPlatform debido a requerimientos de la prueba.
     */
    #[ORM\Column]
    #[Groups(['motorcycle:read'])]
    private DateTimeImmutable $updatedAt;

    /**
     * Indica si la moto es de edición limitada.
     *
     * Solo se indica al crearse la entidad de moto, después de esto no se puede cambiar, (no se le indica el grupo de update)
     */
    #[ORM\Column]
    #[Assert\NotNull(groups: ['motorcycle:create'])]
    #[Groups(['motorcycle:read', 'motorcycle:create'])]
    private bool $edicionLimitada;

    /**
     * Constructor para inicializaciones
     */
    public function __construct() {
        $this->extras = [];
        $this->id = null;
        $this->peso = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;
        return $this;
    }

    public function getCilindrada(): int
    {
        return $this->cilindrada;
    }

    public function setCilindrada(int $cilindrada): self
    {
        $this->cilindrada = $cilindrada;
        return $this;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): self
    {
        $this->marca = $marca;
        return $this;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getExtras(): array
    {
        return $this->extras;
    }

    public function setExtras(array $extras): self
    {
        $this->extras = $extras;
        return $this;
    }

    public function getPeso(): ?int
    {
        return $this->peso;
    }

    public function setPeso(?int $peso): self
    {
        $this->peso = $peso;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function isEdicionLimitada(): bool
    {
        return $this->edicionLimitada;
    }

    public function setEdicionLimitada(bool $edicionLimitada): self
    {
        $this->edicionLimitada = $edicionLimitada;
        return $this;
    }
}
