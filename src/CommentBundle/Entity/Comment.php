<?php

namespace CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PageBundle\Entity\Page;

/**
 * Class Comment
 * @package CommentBundle\Entity
 * @ORM\Entity(repositoryClass="CommentBundle\Repository\CommentRepository")
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
     * @ORM\ManyToOne(targetEntity="\PageBundle\Entity\Page", inversedBy="comments")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    private $page;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    public function __construct() {
        $this->date_add = new \DateTime();
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
     * Set page
     *
     * @param \PageBundle\Entity\Page $page
     *
     * @return Comment
     */
    public function setPage(\PageBundle\Entity\Page $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Get page
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }
}
