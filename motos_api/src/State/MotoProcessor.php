<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Moto;
use DateTimeImmutable;

/**
 * Procesador para Moto.
 */
final readonly class MotoProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [])
    {
        if ($data instanceof Moto) {
            if (null === $data->getId()) {
                $data->setCreatedAt(new DateTimeImmutable());
            }

            $data->setUpdatedAt(new DateTimeImmutable());
        }

        // Se procesa aquí para tenerlo centralizado, no siendo necesario así indicar en la entidad mediante atributs
        return $this->persistProcessor->process(
            $data,
            $operation,
            $uriVariables,
            $context
        );
    }
}
