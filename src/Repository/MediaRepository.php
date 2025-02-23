<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MediaEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MediaEntity>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, MediaEntity::class);
    }
}
