<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArtistRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Artist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=6, unique=true, nullable=false)
     * @Serializer\Expose
     */
    private $token;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Album", mappedBy="artist")
     * @Serializer\Expose
     */
    private $albums;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Song", mappedBy="artist")
     */
    private $songs;

    /**
     * Artist constructor.
     */
    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->songs = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Artist
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Artist
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
