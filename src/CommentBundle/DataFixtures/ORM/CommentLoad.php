<?php

namespace CommentBundle\DataFixtures\ORM;


use CommentBundle\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PageBundle\DataFixtures\ORM\PageLoad;
use PageBundle\Entity\Page;

class CommentLoad extends Fixture implements ORMFixtureInterface {

    public function load(ObjectManager $manager)
    {
        $pageRepo = $manager->getRepository('PageBundle:Page');
        $pages = $pageRepo->findAll();
        foreach ($pages as $page){
            for ($i = 1; $i <= 3; $i++) {
                $comment = new Comment();
                $comment->setComment('Comment '.$i.' > '.$page->getTitle());
                $page->addComment($comment);
            }
            $manager->persist($page);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [
            PageLoad::class
        ];
    }
}