<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectReward
 *
 * @ORM\Table(name="project_reward")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRewardRepository")
 */
class ProjectReward
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="projectRewards")
     */
    private $project;

     /**
     * @var Reward
     * @ORM\ManyToOne(targetEntity="Reward", inversedBy="projectRewards")
     */
    private $reward;


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
     * @return ProjectReward
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
     * Set description
     *
     * @param string $description
     * @return ProjectReward
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     * @return ProjectReward
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set reward
     *
     * @param \AppBundle\Entity\Reward $reward
     * @return ProjectReward
     */
    public function setReward(\AppBundle\Entity\Reward $reward = null)
    {
        $this->reward = $reward;

        return $this;
    }

    /**
     * Get reward
     *
     * @return \AppBundle\Entity\Reward 
     */
    public function getReward()
    {
        return $this->reward;
    }
}
