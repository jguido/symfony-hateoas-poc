<?php


namespace AppBundle\Entity;

use Hateoas\Configuration\Annotation as Hateoas;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @Hateoas\Relation("self", href = "expr('/api/enterprises/' ~ object.getId())")
 * @ORM\Entity()
 * @ORM\Table(name="ENTERPRISES")
 */
class Enterprise
{

    /**
     * @ORM\Id
     * @ORM\Column(name="ID", type="string", length=36)
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(name="NAME", type="string")
     */
    protected $name;

    /**
     * Enterprise constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}