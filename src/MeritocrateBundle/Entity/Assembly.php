<?php

namespace MeritocrateBundle\Entity;

/**
 * Assembly
 */
class Assembly
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $attachment;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \MeritocrateBundle\Entity\User
     */
    private $user;

    /**
     * @var \MeritocrateBundle\Entity\Discussion
     */
    private $discussion;


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
     * Set text
     *
     * @param string $text
     *
     * @return Assembly
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Constructor
     */

     public function __construct()
     {
         $this->date = new \DateTime();
     }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param \MeritocrateBundle\Entity\User $user
     *
     * @return Assembly
     */
    public function setUser(\MeritocrateBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MeritocrateBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set discussion
     *
     * @param \MeritocrateBundle\Entity\Discussion $discussion
     *
     * @return Assembly
     */
    public function setDiscussion(\MeritocrateBundle\Entity\Discussion $discussion = null)
    {
        $this->discussion = $discussion;

        return $this;
    }

    /**
     * Get discussion
     *
     * @return \MeritocrateBundle\Entity\Discussion
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * Set attachment
     *
     * @param string $attachment
     *
     * @return Assembly
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Assembly
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}