<?php

namespace Overwatch\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(
 *   name="Test",
 *   uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_actual_expection", columns={"actual", "expectation"})
 *   }
 * )
 * @ORM\Entity(repositoryClass="Overwatch\TestBundle\Entity\TestRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Test
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="actual", type="string", length=100)
     */
    private $actual;

    /**
     * @var string
     *
     * @ORM\Column(name="expectation", type="string", length=50)
     */
    private $expectation;

    /**
     * @var string
     *
     * @ORM\Column(name="expected", type="string", length=100, nullable=true)
     */
    private $expected;
    
    /**
     * @ORM\OneToMany(targetEntity="Overwatch\ResultBundle\Entity\TestResult", mappedBy="test")
     */
    private $results;
    
    /**
     * @ORM\ManyToOne(targetEntity="TestGroup", inversedBy="tests")
     */
    private $group;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Test
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
     * Set actual
     *
     * @param string $actual
     * @return Test
     */
    public function setActual($actual)
    {
        $this->actual = $actual;

        return $this;
    }

    /**
     * Get actual
     *
     * @return string 
     */
    public function getActual()
    {
        return $this->actual;
    }

    /**
     * Set expectation
     *
     * @param string $expectation
     * @return Test
     */
    public function setExpectation($expectation)
    {
        $this->expectation = $expectation;

        return $this;
    }

    /**
     * Get expectation
     *
     * @return string 
     */
    public function getExpectation()
    {
        return $this->expectation;
    }

    /**
     * Set expected
     *
     * @param string $expected
     * @return Test
     */
    public function setExpected($expected)
    {
        $this->expected = $expected;

        return $this;
    }

    /**
     * Get expected
     *
     * @return string 
     */
    public function getExpected()
    {
        return $this->expected;
    }

    /**
     * Set createdAt
     *
     * @ORM\PrePersist
     * @return Test
     */
    public function setCreatedAt()
    {
        if ($this->createdAt === NULL) {
            $this->createdAt = new \DateTime;
        }
        
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return Test
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set group
     *
     * @param \Overwatch\TestBundle\Entity\TestGroup $group
     * @return Test
     */
    public function setGroup(\Overwatch\TestBundle\Entity\TestGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Overwatch\TestBundle\Entity\TestGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add results
     *
     * @param \Overwatch\ResultBundle\Entity\TestResult $results
     * @return Test
     */
    public function addResult(\Overwatch\ResultBundle\Entity\TestResult $results)
    {
        $this->results[] = $results;

        return $this;
    }

    /**
     * Remove results
     *
     * @param \Overwatch\ResultBundle\Entity\TestResult $results
     */
    public function removeResult(\Overwatch\ResultBundle\Entity\TestResult $results)
    {
        $this->results->removeElement($results);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResults()
    {
        return $this->results;
    }
}
