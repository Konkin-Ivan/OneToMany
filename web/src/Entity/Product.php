<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "products")]

class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: "string")]
    private $name;
    #[ORM\Column(type: "string")]
    #[ORM\ManyToOne(targetEntity: "Manufacturer", inversedBy: "products")]
    #[ORM\JoinColumn(name: "manufacturer_id", referencedColumnName: "id", nullable: false)]
    private $manufacturer;
}