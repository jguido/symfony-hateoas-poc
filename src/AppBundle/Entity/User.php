<?php


namespace AppBundle\Entity;

use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @Hateoas\Relation("self", href = "expr('/api/users/' ~ object.getId())")
 * @Hateoas\Relation(
 *     "ns:enterprise",
 *     href = "expr('/api/enterprises/' ~ object.getEnterprise().getId())",
 *     exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getEnterprise() === null)")
 * )
 * @ORM\Entity()
 * @ORM\Table(name="USERS")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(name="ID", type="string", length=36)
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(name="FIRSTNAME", type="string")
     */
    protected $firstName;
    /**
     * @var string
     * @ORM\Column(name="LASTNAME", type="string")
     */
    protected $lastName;
    /**
     * @var Enterprise
     * @Serializer\Exclude()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise")
     * @ORM\JoinColumn(name="ENTERPRISE_ID", referencedColumnName="ID")
     */
    protected $enterprise;

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