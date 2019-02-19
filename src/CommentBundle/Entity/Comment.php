<?php

namespace CommentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 * @package CommentBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToMany(targetEntity="\PageBundle\Entity\Page", inversedBy="comments")
     * @ORM\JoinTable(name="pages_comments")
     */
    private $pages;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    public function __construct() {
        $this->date_add = new \DateTime();
        $this->pages = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return Comment
     */
    public function setDateAdd($dateAdd)
    {
        $this->date_add = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->date_add;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Add page
     *
     * @param \PageBundle\Entity\Page $page
     *
     * @return Comment
     */
    public function addPage(\PageBundle\Entity\Page $page)
    {
        $this->pages[] = $page;
//        $page->addComment($this);

        return $this;
    }

    /**
     * Remove page
     *
     * @param \PageBundle\Entity\Page $page
     */
    public function removePage(\PageBundle\Entity\Page $page)
    {
        $this->pages->removeElement($page);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }
}
