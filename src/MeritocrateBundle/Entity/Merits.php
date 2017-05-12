<?php

namespace MeritocrateBundle\Entity;

/**
 * Merits
 */
class Merits
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $datecreation;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Merits
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }
    /**
     * @var \MeritocrateBundle\Entity\User
     */
    private $users;


    /**
     * Set users
     *
     * @param \MeritocrateBundle\Entity\User $users
     *
     * @return Merits
     */
    public function setUsers(\MeritocrateBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \MeritocrateBundle\Entity\User
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @var \MeritocrateBundle\Entity\User
     */
    private $user;

    /**
     * @var \MeritocrateBundle\Entity\Discussion
     */
    private $discussion;


    /**
     * Set user
     *
     * @param \MeritocrateBundle\Entity\User $user
     *
     * @return Merits
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
     * @return Merits
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
     * @var \MeritocrateBundle\Entity\Rator
     */
    private $rator;


    /**
     * Set rator
     *
     * @param \MeritocrateBundle\Entity\Rator $rator
     *
     * @return Merits
     */
    public function setRator(\MeritocrateBundle\Entity\Rator $rator = null)
    {
        $this->rator = $rator;

        return $this;
    }

    /**
     * Get rator
     *
     * @return \MeritocrateBundle\Entity\Rator
     */
    public function getRator()
    {
        return $this->rator;
    }
}
