<?php

namespace Brother\QuestBundle\Entity;

use Brother\CommonBundle\Mailer\MailerEntryInterface;
use Brother\CommonBundle\Model\Entry\EntryInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entry
 */
class Entry implements EntryInterface, MailerEntryInterface
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
     * @Assert\NotBlank()
     */
    private $q;

    /**
     * @var string
     */
    private $a;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

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
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var integer
     */
    private $created_by;

    /**
     * @var integer
     */
    private $updated_by;

    /**
     * @var \DateTime
     */
    private $deleted_at;

    /**
     * @var string
     */
    protected $state=0;

    function __toString()
    {
     return $this->q;
    }

    function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
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
     * Set name
     *
     * @param string $name
     * @return Entry
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
     * @return Entry
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
     * @return Entry
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
     * @return Entry
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
     * @return Entry
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
     * @return Entry
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
     * @return Entry
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

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Entry
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Entry
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }


    /**
     * Set created_by
     *
     * @param integer $createdBy
     * @return Entry
     */
    public function setCreatedBy($createdBy)
    {
        $this->created_by = $createdBy;

        return $this;
    }

    /**
     * Get created_by
     *
     * @return integer 
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set updated_by
     *
     * @param integer $updatedBy
     * @return Entry
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updated_by = $updatedBy;

        return $this;
    }

    /**
     * Get updated_by
     *
     * @return integer 
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set deleted_at
     *
     * @param \DateTime $deletedAt
     * @return Entry
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deleted_at = $deletedAt;

        return $this;
    }

    /**
     * Get deleted_at
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * Set status
     *
     * @param $state
     * @internal param string $status
     * @return Entry
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Pre persist
     */
    public function prePersist()
    {
        $this->created_at = new \DateTime();
    }

    /**
     * Pre update
     */
    public function preUpdate()
    {
        $this->updated_at = new \DateTime();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * Set phone
     *
     * @param string $phone
     * @return Entry
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

}
