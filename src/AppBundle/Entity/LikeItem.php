<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LikeItem
 *
 * @ORM\Table(name="like_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LikeItemRepository")
 */
class LikeItem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="addAt", type="datetime")
     */
    private $addAt;

    /**
     * @var string
     *
     * @ORM\Column(name="objectType", type="string", length=32)
     */
    private $objectType;

    /**
     * @var int
     *
     * @ORM\Column(name="objectId", type="integer")
     */
    private $objectId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=true)
     */
    private $ip;


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
     * Set addAt
     *
     * @param \DateTime $addAt
     * @return LikeItem
     */
    public function setAddAt($addAt)
    {
        $this->addAt = $addAt;

        return $this;
    }

    /**
     * Get addAt
     *
     * @return \DateTime 
     */
    public function getAddAt()
    {
        return $this->addAt;
    }

    /**
     * Set objectType
     *
     * @param string $objectType
     * @return LikeItem
     */
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;

        return $this;
    }

    /**
     * Get objectType
     *
     * @return string 
     */
    public function getObjectType()
    {
        return $this->objectType;
    }

    /**
     * Set objectId
     *
     * @param integer $objectId
     * @return LikeItem
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Get objectId
     *
     * @return integer 
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return LikeItem
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }
}
