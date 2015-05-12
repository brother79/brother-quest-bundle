<?php

namespace Brother\QuestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quest
 */
class Quest
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $q;

    /**
     * @var string
     */
    private $a;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $executor;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $priority;


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
     * Set name
     *
     * @param string $name
     * @return Quest
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set q
     *
     * @param string $q
     * @return Quest
     */
    public function setQ($q)
    {
        $this->q = $q;

        return $this;
    }

    /**
     * Get q
     *
     * @return string 
     */
    public function getQ()
    {
        return $this->q;
    }

    /**
     * Set a
     *
     * @param string $a
     * @return Quest
     */
    public function setA($a)
    {
        $this->a = $a;

        return $this;
    }

    /**
     * Get a
     *
     * @return string 
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Quest
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set executor
     *
     * @param string $executor
     * @return Quest
     */
    public function setExecutor($executor)
    {
        $this->executor = $executor;

        return $this;
    }

    /**
     * Get executor
     *
     * @return string 
     */
    public function getExecutor()
    {
        return $this->executor;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Quest
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
     * Set priority
     *
     * @param string $priority
     * @return Quest
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string 
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
