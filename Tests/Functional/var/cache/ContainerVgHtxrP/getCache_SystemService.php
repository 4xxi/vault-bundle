<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'cache.system' shared service.

return $this->services['cache.system'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('Y6IPGgWMQp', 0, 'wUmb2gDrwB1gxO5JW7hKW2', ($this->targetDirs[0].'/pools'), ($this->privates['logger'] ?? $this->privates['logger'] = new \Symfony\Component\HttpKernel\Log\Logger()));
