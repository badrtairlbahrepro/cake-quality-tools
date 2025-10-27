<?php
/**
 * Routes configuration for CakeQualityTools plugin
 */

declare(strict_types=1);

use Cake\Routing\RouteBuilder;

return function (RouteBuilder $builder) {
    $builder->prefix('quality', function (RouteBuilder $builder) {
        $builder->connect('/', ['plugin' => 'CakeQualityTools', 'controller' => 'QualityTools', 'action' => 'index']);
        $builder->connect('/run-tests', ['plugin' => 'CakeQualityTools', 'controller' => 'QualityTools', 'action' => 'runTests']);
        $builder->connect('/run-stan', ['plugin' => 'CakeQualityTools', 'controller' => 'QualityTools', 'action' => 'runStan']);
        $builder->connect('/run-cs', ['plugin' => 'CakeQualityTools', 'controller' => 'QualityTools', 'action' => 'runCodeSniffer']);
    });
};
