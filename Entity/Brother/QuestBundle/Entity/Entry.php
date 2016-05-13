<?php

namespace Brother\QuestBundle\Entity;

/**
 * Entry
 */
class Entry
{
    /**
     * @var int
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
     * @var int
     */
    private $created_by;

    /**
     * @var int
     */
    private $updated_by;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @var \DateTime
     */
    private $deleted_at;

    /**
     * @var int
     */
    private $state;


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
     * Set name
     *
     * @param string $name
     *
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
     *
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
     *
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
     *
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
     * Set phone
     *
     * @param string $phone
     *
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

    /**
     * Set executor
     *
     * @param string $executor
     *
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
     *
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
     *
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
     * Set createdBy
     *
     * @param int $createdBy
     *
     * @return Entry
     */
    public function setCreatedBy($createdBy)
    {
        $this->created_by = $createdBy;
    
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Set updatedBy
     *
     * @param int $updatedBy
     *
     * @return Entry
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updated_by = $updatedBy;
    
        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Entry
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Entry
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Entry
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deleted_at = $deletedAt;
    
        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * Set state
     *
     * @param int $state
     *
     * @return Entry
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }
    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        // Add your code here
    }
    /**
     * @var int
     */
    private $old_id;


    /**
     * Set oldId
     *
     * @param int $oldId
     *
     * @return Entry
     */
    public function setOldId($oldId)
    {
        $this->old_id = $oldId;
    
        return $this;
    }

    /**
     * Get oldId
     *
     * @return int
     */
    public function getOldId()
    {
        return $this->old_id;
    }
}
