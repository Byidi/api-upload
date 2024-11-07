<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class MediaEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING)]
    private string $path;

    #[ORM\ManyToOne(targetEntity: AdEntity::class, inversedBy: 'medias')]
    private AdEntity $ad;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getAd(): AdEntity
    {
        return $this->ad;
    }

    public function setAd(AdEntity $ad): self
    {
        $this->ad = $ad;

        return $this;
    }
}
