<?php

use Triquanta\AccessibilityMonitor\Application;
use Triquanta\AccessibilityMonitor\Console\Console;
use Triquanta\AccessibilityMonitor\Console\YamlCommandDiscovery;

include __DIR__ . '/vendor/autoload.php';

Application::bootstrap();

$container = Application::getContainer();
$console = new Console($container, new YamlCommandDiscovery(), $container->get('event_dispatcher'), $container->get('phantomjs'));
$console->run();
