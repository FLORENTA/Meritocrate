<?php

namespace MeritocrateBundle\Entity;

/**
 * PrivateAssembly
 */
class PrivateAssembly
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $attachment;


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
     * Set text
     *
     * @param string $text
     *
     * @return PrivateAssembly
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

        return $this;
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
     * Set attachment
     *
     * @param string $attachment
     *
     * @return PrivateAssembly
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
     * @var \MeritocrateBundle\Entity\PrivateChat
     */
    private $privatechat;


    /**
     * Set privatechat
     *
     * @param \MeritocrateBundle\Entity\PrivateChat $privatechat
     *
     * @return PrivateAssembly
     */
    public function setPrivatechat(\MeritocrateBundle\Entity\PrivateChat $privatechat = null)
    {
        $this->privatechat = $privatechat;

        return $this;
    }

    /**
     * Get privatechat
     *
     * @return \MeritocrateBundle\Entity\PrivateChat
     */
    public function getPrivatechat()
    {
        return $this->privatechat;
    }
    /**
     * @var \MeritocrateBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \MeritocrateBundle\Entity\User $user
     *
     * @return PrivateAssembly
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
}
