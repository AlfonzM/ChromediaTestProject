<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class PasswordResetToken{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $userId;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
	protected $created_at;

    /**
     * Set token
     *
     * @param integer $token
     * @return PasswordResetToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return integer 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return PasswordResetToken
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
     * Set userId
     *
     * @param integer $userId
     * @return PasswordResetToken
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
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
}
