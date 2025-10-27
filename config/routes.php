<?php
/**
 * Routes configuration for CakeQualityTools plugin
 */

declare(strict_types=1);

use Cake\Routing\RouteBuilder;

return function (RouteBuilder $builder) {
    $builder->connect('/', ['controller' => 'QualityTools', 'action' => 'index']);
    $builder->connect('/run-tests', ['controller' => 'QualityTools', 'action' => 'runTests']);
    $builder->connect('/run-stan', ['controller' => 'QualityTools', 'action' => 'runStan']);
    $builder->connect('/run-cs', ['controller' => 'QualityTools', 'action' => 'runCodeSniffer']);
};
