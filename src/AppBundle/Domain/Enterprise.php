<?php


namespace AppBundle\Domain;

use Hateoas\Configuration\Annotation as Hateoas;

/**
 *
 * @Hateoas\Relation("self", href = "expr('/api/enterprises/' ~ object.getId())")
 */
class Enterprise
{


    private $id;
    private $name;

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