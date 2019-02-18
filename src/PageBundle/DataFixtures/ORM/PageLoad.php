<?php
/**
 * Created by PhpStorm.
 * User: dimit
 * Date: 17-Feb-19
 * Time: 7:48 PM
 */

namespace PageBundle\DataFixtures\ORM;


use CategoryBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PageBundle\Entity\Page;

class PageLoad extends Fixture implements ORMFixtureInterface {

    public function load(ObjectManager $manager)
    {
        $categoryRepo = $manager->getRepository(Category::class);
        for ($i = 1; $i <= 3; $i++) {
            $page = new Page();
            $page->setTitle('Page ' . $i);
            $page->setBody('Body ' . $i);
            $category = $categoryRepo->findOneByName('Category ' . $i);
            if (!empty($category)) {
                $page->setCategory($category);
            }
            $manager->persist($page);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [
            Category::class
        ];
    }
}