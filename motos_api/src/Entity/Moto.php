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
            denormalizationContext: ['groups' => ['moto:create']],
            validationContext: ['groups' => ['moto:create']]
        ),
        new Get(),
        new Put(
            normalizationContext: ['groups' => ['moto:read']],
            denormalizationContext: ['groups' => ['moto:update']],
            validationContext: ['groups' => ['moto:update']]
        ),
        new Patch(
            normalizationContext: ['groups' => ['moto:read']],
            denormalizationContext: ['groups' => ['moto:update']],
            validationContext: ['groups' => ['moto:update']]
        ),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['moto:read']]
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
    #[Groups(['moto:read'])]
    private ?int $id = null;

    /**
     * Modelo de la moto.
     */
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(groups: ['moto:create', 'moto:update'])]
    #[Assert\Length(max: 50)]
    #[Groups(['moto:read', 'moto:create', 'moto:update'])]
    private string $modelo;

    /**
     * Cilindrada de la moto
     */
    #[ORM\Column]
    #[Assert\NotNull(groups: ['moto:create', 'moto:update'])]
    #[Assert\Positive]
    #[Groups(['moto:read', 'moto:create', 'moto:update'])]
    private int $cilindrada;

    /**
     * Marca de la moto.
     */
    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(groups: ['moto:create', 'moto:update'])]
    #[Assert\Length(max: 40)]
    #[Groups(['moto:read', 'moto:create', 'moto:update'])]
    private string $marca;

    /**
     * Tipo de la moto. No se indica límite de carácteres en el enunciado, pero se le ha asignado uno coherente aún así.
     *
     * Los tipos de moto serán constantes almacenados en el listado de MotoTipoEnum.
     */
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(groups: ['moto:create', 'moto:update'])]
    #[Groups(['moto:read', 'moto:create', 'moto:update'])]
    private string $tipo;

    /**
     * Listado de extras de la moto.
     */
    #[ORM\Column(type: Types::JSON)]
    #[Assert\NotNull(groups: ['moto:create', 'moto:update'])]
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
    #[Groups(['moto:read', 'moto:create', 'moto:update'])]
    private array $extras = [];

    /**
     * Peso de la moto (opcional).
     */
    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
    #[Groups(['moto:read', 'moto:create', 'moto:update'])]
    private ?int $peso = null;

    /**
     * Fecha de creación de la moto.
     * Se crea automáticamente desde MotoProcessor antes de que Doctrine persista el objeto.
     * Se podría hacer también utilizando Doctrine, pero se le da prioridad al uso de ApiPlatform debido a requerimientos de la prueba.
     */
    #[ORM\Column]
    #[Groups(['moto:read'])]
    private DateTimeImmutable $createdAt;

    /**
     * Fecha de actualización de la moto.
     * Se actualiza automáticamente desde MotoProcessor antes de que Doctrine persista el objeto.
     * Se podría hacer también utilizando Doctrine, pero se le da prioridad al uso de ApiPlatform debido a requerimientos de la prueba.
     */
    #[ORM\Column]
    #[Groups(['moto:read'])]
    private DateTimeImmutable $updatedAt;

    /**
     * Indica si la moto es de edición limitada.
     * Solo se indica al crearse la entidad de moto, después de esto no se puede cambiar, (no se le indica el grupo de update).
     *
     * Se define como nullable y sin valor por defecto, siendo obligatorio únicamente en el grupo de create.
     * De este modo no se asume ningún valor implícito, se evita su modificación posterior y se mantiene la integridad del dominio.
     */
    #[ORM\Column(nullable: true)]
    #[Assert\NotNull(groups: ['moto:create'])]
    #[Groups(['moto:read', 'moto:create'])]
    private ?bool $edicionLimitada = null;

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

    public function isEdicionLimitada(): ?bool
    {
        return $this->edicionLimitada;
    }

    public function setEdicionLimitada(?bool $edicionLimitada): self
    {
        $this->edicionLimitada = $edicionLimitada;
        return $this;
    }
}
