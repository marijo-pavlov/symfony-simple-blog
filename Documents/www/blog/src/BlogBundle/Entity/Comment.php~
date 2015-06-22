<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\CommentRepository")
 */
class Comment
{
    /**
    * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
    * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
    */
    private $post;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published", type="datetime")
     */
    private $published;


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
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param \DateTime $published
     * @return Comment
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime 
     */
    public function getPublished()
    {
        return $this->published->format('Y F d, H:i');
    }

    /**
     * Set post
     *
     * @param \BlogBundle\Entity\Post $post
     * @return Comment
     */
    public function setPost(\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \BlogBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}
