<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    
    #[ORM\Column(type: 'string', length: 255)]
    #[ORM\JoinColumn(nullable:false)]


    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burger;

    #[ORM\ManyToMany(targetEntity: Complement::class, inversedBy: 'menus')]
    private $complement;

    #[ORM\ManyToMany(targetEntity: Image::class, inversedBy: 'menus',cascade:['persist'])]
    private $images;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    public function __construct()
    {
        $this->complement = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->etat ='non-archiver';
        $this->type ='menu';

        

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    /**
     * @return Collection<int, Complement>
     */
    public function getComplement(): Collection
    {
        return $this->complement;
    }

    public function addComplement(Complement $complement): self
    {
        if (!$this->complement->contains($complement)) {
            $this->complement[] = $complement;
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self
    {
        $this->complement->removeElement($complement);

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $this->images->removeElement($image);

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

}
