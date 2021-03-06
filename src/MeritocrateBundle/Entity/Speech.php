<?php

namespace MeritocrateBundle\Entity;

/**
 * Speech
 */
class Speech
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $timestamp;

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
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime();

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set user
     *
     * @param \MeritocrateBundle\Entity\User $user
     *
     * @return Speech
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
     * @return Speech
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
}
