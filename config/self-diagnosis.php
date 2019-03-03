<?php

return [

    /*
     * A list of environment aliases mapped to the actual environment configuration.
     */
    'environment_aliases' => [
        'prod' => 'production',
        'live' => 'production',
        'staging' => 'production',
        'dev' => 'development',
        'local' => 'development',
    ],

    /*
     * Common checks that will be performed on all environments.
     */
    'checks' => [
        \BeyondCode\SelfDiagnosis\Checks\AppKeyIsSet::class,
        \BeyondCode\SelfDiagnosis\Checks\CorrectPhpVersionIsInstalled::class,
        \BeyondCode\SelfDiagnosis\Checks\PhpExtensionsAreInstalled::class => [
            'extensions' => [
                'openssl',
                'PDO',
                'mbstring',
                'tokenizer',
                'xml',
                'ctype',
                'json',
                'simplexml',
                'sockets',
            ],
            'include_composer_extensions' => true,
        ],
        \BeyondCode\SelfDiagnosis\Checks\DirectoriesHaveCorrectPermissions::class => [
            'directories' => [
                storage_path(),
                base_path('bootstrap/cache'),
            ],
        ],
        \BeyondCode\SelfDiagnosis\Checks\EnvFileExists::class,
        \BeyondCode\SelfDiagnosis\Checks\ExampleEnvironmentVariablesAreSet::class,
        \BeyondCode\SelfDiagnosis\Checks\LocalesAreInstalled::class => [
            'required_locales' => [
                'en_US',
                //'en_US.utf8',
            ],
        ],
        \BeyondCode\SelfDiagnosis\Checks\StorageDirectoryIsLinked::class,
        \BeyondCode\SelfDiagnosis\Checks\MaintenanceModeNotEnabled::class,
        \BeyondCode\SelfDiagnosis\Checks\DatabaseCanBeAccessed::class => [
            'default_connection' => true,
            'connections' => [],
        ],
        //\BeyondCode\SelfDiagnosis\Checks\MigrationsAreUpToDate::class,
        //\BeyondCode\SelfDiagnosis\Checks\RedisCanBeAccessed::class => [
        //    'default_connection' => true,
        //    'connections' => [],
        //],
        \BeyondCode\SelfDiagnosis\Checks\ServersArePingable::class => [
            'servers' => [
                ['host' => 'www.google.com', 'port' => 80],
                ['host' => '8.8.8.8', 'timeout' => 5],
            ],
        ],
    ],

    /*
     * Environment specific checks that will only be performed for the corresponding environment.
     */
    'environment_checks' => [
        'development' => [
            //\BeyondCode\SelfDiagnosis\Checks\ComposerWithDevDependenciesIsUpToDate::class,
            \BeyondCode\SelfDiagnosis\Checks\ConfigurationIsNotCached::class,
            \BeyondCode\SelfDiagnosis\Checks\RoutesAreNotCached::class,
            \BeyondCode\SelfDiagnosis\Checks\ExampleEnvironmentVariablesAreUpToDate::class,
        ],
        'production' => [
            //\BeyondCode\SelfDiagnosis\Checks\ComposerWithoutDevDependenciesIsUpToDate::class,
            \BeyondCode\SelfDiagnosis\Checks\ConfigurationIsCached::class,
            \BeyondCode\SelfDiagnosis\Checks\RoutesAreCached::class,
            \BeyondCode\SelfDiagnosis\Checks\DebugModeIsNotEnabled::class,
            \BeyondCode\SelfDiagnosis\Checks\PhpExtensionsAreDisabled::class => [
                'extensions' => [
                    'xdebug',
                ],
            ],
            //\BeyondCode\SelfDiagnosis\Checks\SupervisorProgramsAreRunning::class => [
            //    'programs' => [
            //        'horizon',
            //    ],
            //    'restarted_within' => 300,
            //],
        ],
    ],

];
