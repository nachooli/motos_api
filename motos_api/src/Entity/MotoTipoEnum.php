<?php

declare(strict_types = 1);

namespace App\Entity;

/**
 * Tipos de motos.
 *
 * Se indican como constantes en un enum simple dado que no es necesario complicarlo de más.
 */
class MotoTipoEnum
{
    public const TIPO_MOTO_SCOOTER = "scooter";
    public const TIPO_MOTO_CROSS = "cross";
    public const TIPO_MOTO_NAKED = "naked";
    public const TIPO_MOTO_CRUISER = "cruiser";
    public const TIPO_MOTO_ENDURO = "enduro";
    public const TIPO_MOTO_DEPORTIVA = "deportiva";
    public const TIPO_MOTO_CUSTOM = "custom";
}
