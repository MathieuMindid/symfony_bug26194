<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function createUser(string $username)
    {
        $user = new User();
        $user->setUsername($username);

        # On encode le password suivant la methode definie dans le security.yaml
        /** @var UserPasswordEncoderInterface $encoder */
        $encoder = $this->container->get('security.password_encoder');

        $user->setPassword($encoder->encodePassword($user, $username));

        $this->manager->persist($user);
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->createUser("john.doe");
        $this->createUser("m-smith");

        $this->manager->flush();
    }

    public function getOrder()
    {
        // Define the order n which fixtures will be loaded (1 = first)
        return 1;
    }
}
