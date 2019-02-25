<?php

namespace PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Page
 * @package PageBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="page")
 */
class Page {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="\CategoryBundle\Entity\Category", inversedBy="pages")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_add;

    /**
     * @ORM\OneToMany(targetEntity="\CommentBundle\Entity\Comment", mappedBy="page", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $comments;


    public function __construct() {
        $this->date_add = new \DateTime();
        $this->comments = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Page
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return Page
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
     * Set category
     *
     * @param \CategoryBundle\Entity\Category $category
     *
     * @return Page
     */
    public function setCategory(\CategoryBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \CategoryBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add comment
     *
     * @param \CommentBundle\Entity\Comment $comment
     *
     * @return Page
     */
    public function addComment(\CommentBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setPage($this);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \CommentBundle\Entity\Comment $comment
     */
    public function removeComment(\CommentBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
