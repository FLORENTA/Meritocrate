<?php

namespace MeritocrateBundle\Entity;

/**
 * PrivateChat
 */
class PrivateChat
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $creator;


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
     * Set token
     *
     * @param string $token
     *
     * @return PrivateChat
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set creator
     *
     * @param string $creator
     *
     * @return PrivateChat
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return string
     */
    public function getCreator()
    {
        return $this->creator;
    }
    /**
     * @var string
     */
    private $classmate;


    /**
     * Set classmate
     *
     * @param string $classmate
     *
     * @return PrivateChat
     */
    public function setClassmate($classmate)
    {
        $this->classmate = $classmate;

        return $this;
    }

    /**
     * Get classmate
     *
     * @return string
     */
    public function getClassmate()
    {
        return $this->classmate;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $privateassemblies;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->privateassemblies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add privateassembly
     *
     * @param \MeritocrateBundle\Entity\PrivateAssembly $privateassembly
     *
     * @return PrivateChat
     */
    public function addPrivateassembly(\MeritocrateBundle\Entity\PrivateAssembly $privateassembly)
    {
        $this->privateassemblies[] = $privateassembly;

        return $this;
    }

    /**
     * Remove privateassembly
     *
     * @param \MeritocrateBundle\Entity\PrivateAssembly $privateassembly
     */
    public function removePrivateassembly(\MeritocrateBundle\Entity\PrivateAssembly $privateassembly)
    {
        $this->privateassemblies->removeElement($privateassembly);
    }

    /**
     * Get privateassemblies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrivateassemblies()
    {
        return $this->privateassemblies;
    }
}
