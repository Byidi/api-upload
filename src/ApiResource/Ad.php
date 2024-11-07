<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Entity\AdEntity;
use App\Entity\Media;
use App\State\Processor\AdStateProcessor;
use App\State\Provider\AdStateProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Delete(),
        new Post(
            denormalizationContext: [
                'groups' => [
                    self::SERIALIZATION_POST,
                ],
            ],
        ),
    ],
    shortName: 'Ads',
    stateOptions: new Options(entityClass: AdEntity::class),
    provider: AdStateProvider::class,
    processor: AdStateProcessor::class,
    normalizationContext: [
        'groups' => [
            self::SERIALIZATION_GET,
        ],
    ],
)]
class Ad
{
    public const SERIALIZATION_POST = 'ad:post';
    public const SERIALIZATION_GET = 'ad:get';

    #[ApiProperty(identifier: true)]
    #[Groups([self::SERIALIZATION_GET])]
    #[NotBlank(groups: [self::SERIALIZATION_GET])]
    public Uuid $id;

    #[Groups([self::SERIALIZATION_GET, self::SERIALIZATION_POST])]
    #[NotBlank()]
    public string $title;

    /** @var array<int, Media> */
    #[Groups([self::SERIALIZATION_GET])]
    public array $medias = [];
}
