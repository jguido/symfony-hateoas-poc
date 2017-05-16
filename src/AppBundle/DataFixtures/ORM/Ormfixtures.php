<?php


namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Enterprise;
use AppBundle\Entity\User;
use AppBundle\Helper\Guid;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Ormfixtures implements FixtureInterface
{
    use Guid;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (range(1, 100000) as $i) {
            $enterprise = new Enterprise($this->guid(), "cyber Corp $i.");
            $manager->persist($enterprise);
            $user = new User($this->guid(), "firstname$i", "lastname$i", $enterprise);
            $manager->persist($user);
        }
        $manager->flush();
    }
}