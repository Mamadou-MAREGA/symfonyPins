<?php

namespace App\Entity;


use App\Repository\PinsRepository;
use Doctrine\ORM\Mapping as ORM;
use ORM\Mapping\HasLifecycleCallBacks;
use App\Entity\Traits\Timestampable;

/**
 * @ORM\Entity(repositoryClass=PinsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Pins
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
