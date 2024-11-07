<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Table(name: 'ads')]
#[ORM\Entity(repositoryClass: AdRepository::class)]
class AdEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    /** @var Collection<int,MediaEntity> */
    #[ORM\OneToMany(targetEntity: MediaEntity::class, mappedBy: 'ad')]
    private Collection $medias;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int,MediaEntity>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(MediaEntity $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
        }

        return $this;
    }

    public function removeMedia(MediaEntity $media): self
    {
        if ($this->medias->contains($media)) {
            $this->medias->removeElement($media);
        }

        return $this;
    }

    /**
     * @param array<int,MediaEntity> $medias
     */
    public function setMedias(array $medias): self
    {
        $this->medias = new ArrayCollection($medias);

        return $this;
    }
}
