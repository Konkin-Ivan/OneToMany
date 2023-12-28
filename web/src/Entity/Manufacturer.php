<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "manufacturers")]

class Manufacturer
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: "string")]
    private $name;
    #[ORM\Column(type: "string")]
    #[ORM\OneToMany(mappedBy: "manufacturer", targetEntity: "Product")]
    private $products;
}