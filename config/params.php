<?php

declare(strict_types=1);

use App\Command;
use App\ViewInjection\ContentViewInjection;
use App\ViewInjection\LayoutViewInjection;
use App\ViewInjection\LinkTagsViewInjection;
use App\ViewInjection\MetaTagsViewInjection;
use Cycle\Schema\Generator;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Factory\Definitions\Reference;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Router\UrlMatcherInterface;

return [
    'yiisoft/yii-debug' => [
        // 'enabled' => false,
    ],

    'yiisoft/aliases' => [
        'aliases' => [
            '@root' => dirname(__DIR__),
            '@views' => '@root/views',
            '@resources' => '@root/resources',
            '@src' => '@root/src',
            '@assets' => '@public/assets',
            '@assetsUrl' => '@baseUrl/assets',
        ],
    ],

    'mailer' => [
        'adminEmail' => 'admin@example.com',
    ],

    'yiisoft/form' => [
        'fieldConfig' => [
            'inputCssClass()' => ['form-control input field'],
            'labelOptions()' => [['label' => '']],
        ],
    ],

    'yiisoft/session' => [
        'session' => [
            'options' => ['cookie_secure' => 0],
        ],
    ],

    'yiisoft/view' => [
        'basePath' => '@views',
        'defaultParameters' => [
            'assetManager' => Reference::to(AssetManager::class),
            'urlGenerator' => Reference::to(UrlGeneratorInterface::class),
            'urlMatcher' => Reference::to(UrlMatcherInterface::class),
        ],
    ],

    'yiisoft/yii-console' => [
        'commands' => [
            'user/create' => Command\User\CreateCommand::class,
            'user/assignRole' => Command\User\AssignRoleCommand::class,
            'fixture/add' => Command\Fixture\AddCommand::class,
            'router/list' => Command\Router\ListCommand::class,
        ],
    ],

    'yiisoft/yii-cycle' => [
        'dbal' => [
            'default' => 'default',
            'aliases' => [],
            'databases' => [
                'default' => ['connection' => 'sqlite'],
            ],
            'connections' => [
                'sqlite' => [
                    'driver' => \Spiral\Database\Driver\SQLite\SQLiteDriver::class,
                    'connection' => 'sqlite:@runtime/database.db',
                    'username' => '',
                    'password' => '',
                ],
            ],
            // 'query-logger' => \Yiisoft\Yii\Cycle\Logger\StdoutQueryLogger::class,
        ],
        // 'orm-promise-factory' => \Cycle\ORM\Promise\ProxyFactory::class,
        'migrations' => [
            'directory' => '@root/migrations',
            'namespace' => 'App\\Migration',
            'table' => 'migration',
            'safe' => false,
        ],
        'schema-providers' => [
            \Yiisoft\Yii\Cycle\Schema\Provider\SimpleCacheSchemaProvider::class => [
                'key' => 'cycle-orm-cache-key',
            ],
            // \Yiisoft\Yii\Cycle\Schema\Provider\FromFileSchemaProvider::class => [
            //     'file' => '@runtime/schema.php'
            // ],
            \Yiisoft\Yii\Cycle\Schema\Provider\FromConveyorSchemaProvider::class => [
                'generators' => [
                    Generator\SyncTables::class, // sync table changes to database
                ],
            ],
        ],
        'annotated-entity-paths' => [
            '@src/Entity',
            '@src/Blog/Entity',
        ],
    ],

    'yiisoft/yii-view' => [
        'injections' => [
            Reference::to(ContentViewInjection::class),
            Reference::to(LayoutViewInjection::class),
            Reference::to(LinkTagsViewInjection::class),
            Reference::to(MetaTagsViewInjection::class),
        ],
    ],
];
