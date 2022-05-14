<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;
use ArrayObject;

use function PHPSTORM_META\type;

class OpenApiFactory implements OpenApiFactoryInterface
{

    public function __construct(private OpenApiFactoryInterface $decorateur) {}

    public function __invoke(array $context = []): OpenApi
    {
        $openAPi = $this->decorateur->__invoke($context);
        foreach($openAPi->getPaths()->getPaths() as $key => $path) {
            
            if ($path->getGet()->getSummary() === "hidden") {
                $openAPi->getPaths()->addPath($key, $path->withGet(null));
            }
        }

        $shemas = $openAPi->getComponents()->getSecuritySchemes();
        
        $shemas['bearerAuth'] = new ArrayObject([
            'type' => "http",
            'scheme' => "bearer",
            'bearerFormat' => "JWT"
        ]);
        $shemas = $openAPi->getComponents()->getSchemas();
        $shemas['Credentials'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'azad@gmail.com' 
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'mina'
                ]
            ]
        ]);
        $shemas['SignIn'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'first name' => [
                    'type' => 'string',
                ],
                'second name' => [
                    'type' => 'string',
                ],
                'username' => [
                    'type' => 'string',
                ],
                'password' => [
                    'type' => 'string',
                ]
            ]
        ]);
        $shemas['Token'] = new ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true
                ]
            ]
        ]);

        $meOperation = $openAPi->getPaths()->getPath('/api/me')->getGet()->withParameters([]);
        $mePath = $openAPi->getPaths()->getPath('/api/me')->withGet($meOperation);
        $openAPi->getPaths()->addPath('/api/me', $mePath);

        $pathItemToken = new PathItem(
            post: new Operation(
                operationId: 'postCredentialsItem',
                tags: ['Auth'],
                responses: [
                    '200' => [
                        'description' => 'Get JWT token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#components/schemas/Token'
                                ]
                            ]
                        ]
                    ]
                ],
                requestBody: new RequestBody(
                    content: new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#components/schemas/Credentials'
                            ]
                        ]
                    ])
                )
            )
        );

        $pathItemSignIn = new PathItem(
            post: new Operation(
                operationId: 'postOperationSignIn',
                tags: ['Auth'],
                requestBody: new RequestBody(
                    content: new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#components/schemas/SignIn'
                            ]
                        ]
                    ])
                ),
                responses: [
                    '200' => [
                        'description' => 'Utilisateur inscrit',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#components/schemas/User-read.User.collection'
                                ]
                            ]
                        ]
                    ] 
                ]
            )
        );

        $openAPi->getPaths()->addPath('/api/login', $pathItemToken);
        //$openAPi->getPaths()->addPath('/api/signin', $pathItemSignIn);

        return $openAPi;
    }
}