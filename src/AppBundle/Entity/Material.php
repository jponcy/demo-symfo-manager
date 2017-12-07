<?php

/**************************************************************************
 * Material.php, Manager
 *
 * Mickael Gaillard Copyright 2017
 * Description :
 * Author(s)   : Jonathan Poncy <jonathan.poncy@tactfactory.com>
 * Licence     : All right reserved.
 * Last update : 4 déc. 2017
 *
 **************************************************************************/
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Material.
 *
 * @ORM\Table(name="app_material")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaterialRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @UniqueEntity("name")
 */
class Material extends EntityBase
{

    /**
     * @ORM\Column(type="string", name="type", nullable=true)
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $type;
    
    /**
     * @ORM\Column(type="integer", name="number")
     * 
     * @var int
     */
    private $number;
    
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Personel", inversedBy="materials", cascade={"persist", "remove"})
     * @JoinColumn(name="personel_id", referencedColumnName="id")
     * @var Personel
     */
    private $personel;    
    
    /**
     * @ORM\OneToMany(targetEntity="Material", mappedBy="material", cascade={"persist", "remove"})
     * 
     * @var ArrayCollection
     */
    private $materials;

    /**
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="materials", cascade={"persist", "remove"})
     * @var Material
     */
    private $material;
    
    
    public function __construct()
    {
        $this->materials = new ArrayCollection();
    }
    

    /**
     * Set the number
     *
     * @param int $number
     */
    public function setNumber(int $number)
    {
        $this->number = $number;
        return $this;
    }
    
    /**
     * get the number
     *
     * @return $number
     */
    public function getNumber()
    {
        return $this->number;
    }
    
    
    /**
     * Set the personel
     *
     * @param Personel $personel
     */
    public function setPersonel(Personel $personel)
    {
        $this->personel = $personel;
        return $this;
    }
    
    /**
     * get the personel
     *
     * @return $personel
     */
    public function getPersonel()
    {
        return $this->personel;
    }
    
    
    /**
     * Set the material
     *
     * @param Material $material
     */
    public function setMaterial(Material $material)
    {
        $this->material = $material;
        return $this;
    }
    
    /**
     * get the material
     *
     * @return $material
     */
    public function getMaterial()
    {
        return $this->material;
    }
    
    
    /**
     * Set the materials
     *
     * @param Collection $materials
     */
    public function setMaterials(ArrayCollection $materials)
    {
        $this->materials = $materials;
        return $this;
    }
    
    /**
     * get the materials
     *
     * @return $materials
     */
    public function getMaterials()
    {
        return $this->materials;
    }
    

    /**
     * Get the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type.
     *
     * @param string $type
     *
     * @return Material
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

}




















