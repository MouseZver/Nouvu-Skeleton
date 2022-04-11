<?php

use Nouvu\Framework\Foundation\Application;

$composer = require 'vendor/autoload.php';

//$composer -> addPsr4( \Nouvu\Framework :: class . '\\', dirname ( __DIR__ ) . "/Nouvu-Framework/src/Nouvu" );

return static function ( string $name ) use ( $composer ): Application
{
	$composer -> addPsr4( \Nouvu\Resources :: class . '\\', __DIR__ . "/{$name}/Resources" );
	
	return new Application( new \Nouvu\Container\Container, include __DIR__ . "/{$name}/tools.php" );
};
