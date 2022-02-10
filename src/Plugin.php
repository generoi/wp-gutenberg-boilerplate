<?php

namespace GeneroWP\BlockBoilerplate;

use Illuminate\Support\Str;
use ReflectionClass;

class Plugin
{
    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init()
    {
        foreach (glob(__DIR__ . '/blocks/*/*.php') as $file) {
            $composer = __NAMESPACE__ . str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($file, __DIR__)
            );

            if (is_subclass_of($composer, Block::class) && ! (new ReflectionClass($composer))->isAbstract()) {
                (new $composer())->compose();
            }
        }
    }
}
