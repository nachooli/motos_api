<?php

namespace App\DataFixtures;

use App\Entity\Moto;
use App\Entity\MotoTipoEnum;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Clase para persistir en bbdd motos de ejemplo
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Crear y persistir varias motos con diferentes características
        $motos = [
            [
                'modelo' => 'Honda Rebel 500',
                'cilindrada' => 471,
                'marca' => 'Honda',
                'tipo' => MotoTipoEnum::TIPO_MOTO_CUSTOM,
                'peso' => 190,
                'extras' => ['ABS', 'Alarma'],
                'edicionLimitada' => true
            ],
            [
                'modelo' => 'Yamaha MT-07',
                'cilindrada' => 689,
                'marca' => 'Yamaha',
                'tipo' => MotoTipoEnum::TIPO_MOTO_NAKED,
                'peso' => 184,
                'extras' => ['ABS', 'Control de tracción'],
                'edicionLimitada' => false
            ],
            [
                'modelo' => 'Ninja H2',
                'cilindrada' => 1200,
                'marca' => 'Kawsaki',
                'tipo' => MotoTipoEnum::TIPO_MOTO_DEPORTIVA,
                'peso' => 202,
                'extras' => ['ABS', 'Alerones'],
                'edicionLimitada' => true
            ],
            [
                'modelo' => 'Honda SH125',
                'cilindrada' => 125,
                'marca' => 'Honda',
                'tipo' => MotoTipoEnum::TIPO_MOTO_SCOOTER,
                'peso' => 135,
                'extras' => ['ABS', 'CBS'],
                'edicionLimitada' => false
            ]
        ];

        foreach ($motos as $motoData) {
            $moto = $this->crearMoto(
                $motoData['modelo'],
                $motoData['cilindrada'],
                $motoData['marca'],
                $motoData['tipo'],
                $motoData['peso'],
                $motoData['extras'],
                $motoData['edicionLimitada']
            );

            $manager->persist($moto);
        }

        // Guardar todas las motos persistidas
        $manager->flush();
    }

    /**
     * Función auxiliar para la creación de motos.
     */
    private function crearMoto(
        string $modelo,
        int $cilindrada,
        string $marca,
        string $tipo,
        ?int $peso,
        array $extras,
        bool $edicionLimitada
    ): Moto {
        $moto = new Moto();

        return $moto->setModelo($modelo)
            ->setCilindrada($cilindrada)
            ->setMarca($marca)
            ->setTipo($tipo)
            ->setPeso($peso)
            ->setExtras($extras)
            ->setCreatedAt(new DateTimeImmutable())
            ->setUpdatedAt(new DateTimeImmutable())
            ->setEdicionLimitada($edicionLimitada);
    }
}
