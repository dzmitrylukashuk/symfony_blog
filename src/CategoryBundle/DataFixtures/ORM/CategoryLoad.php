<?php
/**
 * Created by PhpStorm.
 * User: dimit
 * Date: 17-Feb-19
 * Time: 7:47 PM
 */

namespace CategoryBundle\DataFixtures\ORM;


use CategoryBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryLoad extends Fixture implements ORMFixtureInterface {

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setName('Category ' . $i);
            $category->setDescription('Description ' . $i);
            $manager->persist($category);
        }

        $manager->flush();
    }
}