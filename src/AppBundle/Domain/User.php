<?php


namespace AppBundle\Domain;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 *
 * @Hateoas\Relation("self", href = "expr('/api/users/' ~ object.getId())")
 * @Hateoas\Relation(
 *     "ns:enterprise",
 *     href = "expr('/api/enterprises/' ~ object.getEnterprise().getId())",
 *     exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getEnterprise() === null)")
 * )
 */
class User
{

    private $id;
    private $firstName;
    private $lastName;
    /**
     * @var Enterprise
     * @Serializer\Exclude()
     */
    private $enterprise;

    /**
     * User constructor.
     * @param $id
     * @param $firstName
     * @param $lastName
     * @param Enterprise $enterprise
     */
    public function __construct($id, $firstName, $lastName, Enterprise $enterprise)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->enterprise = $enterprise;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Enterprise
     */
    public function getEnterprise(): Enterprise
    {
        return $this->enterprise;
    }
}