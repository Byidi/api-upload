<?php

// api/src/Entity/MediaObject.php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\ApiResource\Ad;
use App\State\Processor\MediaStateProcessor;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Post(
            processor: MediaStateProcessor::class,
            inputFormats: ['multipart' => ['multipart/form-data']],
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                    'ad' => [
                                        'type' => 'string',
                                        'format' => '$iri-reference',
                                    ],
                                ],
                            ],
                        ],
                    ]),
                ),
            ),
        ),
    ],
    normalizationContext: [
        'groups' => [
            Media::SERIALIZATION_GET,
        ],
    ],
    denormalizationContext: [
        'groups' => [
            Media::SERIALIZATION_POST,
        ],
    ],
    outputFormats: ['jsonld' => ['application/ld+json']],
)]
class Media
{
    public const SERIALIZATION_POST = 'media:post';
    public const SERIALIZATION_GET = 'media:get';

    #[ApiProperty(identifier: true)]
    #[Groups([self::SERIALIZATION_GET])]
    #[NotBlank(groups: [self::SERIALIZATION_GET])]
    public Uuid $id;

    #[Vich\UploadableField(mapping: 'media', fileNameProperty: 'path')]
    #[Groups([self::SERIALIZATION_POST])]
    public ?File $file = null;

    #[Groups([self::SERIALIZATION_GET])]
    public string $path;

    #[Groups([self::SERIALIZATION_GET, self::SERIALIZATION_POST])]
    public Ad $ad;
}
