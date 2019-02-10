<?php namespace OneFramework\Container;

/**
 * OneFramework
 *
 * Copyright (c) 2019 Elixant Technology Ltd.
 *
 * OneFramework is a PHP Software Development Framework created by
 * Elixant Technology for use within our Proprietary Licensed Software;
 * however we acknowledge that there's some things that shouldn't be kept
 * secret and may be useful for the Development Community as a whole. Therefore
 * we have released OneFramework under the MIT Open Source License. Please
 * refer to the LICENSE file included with this package for more info.
 *
 * @package   oneframework/container
 * @license   MIT License
 * @link      https://www.elixant.ca
 * @author    Alexander Schmautz <ceo@elixant.ca>
 * @copyright Copyright (c) 2018 Elixant Technoloy Ltd. All Rights Reserved.
 */

use Illuminate\Container\Container as BaseContainer;
use Illuminate\Contracts\Container\Container as BaseContainerContract;
use Illuminate\Foundation\Application;
use OneFramework\Container\Contracts\ContainerContract;
use OneFramework\Events\Contracts\DispatcherContract;
use OneFramework\Events\Dispatcher;
use Psr\Container\ContainerInterface;
use OneFramework\ServiceLoader\Loader;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Definition: Container
 *
 * Nothing here, yet at least. This will serve as a simple whitelabelling solution
 * in regards to Laravel's Container Package.
 *
 * @package     oneframework/container
 * @subpackage  Container
 * @license     MIT License
 * @link        https://www.elixant.ca
 * @author      Alexander Schmautz <ceo@elixant.ca>
 * @copyright   Copyright (c) 2018 Elixant Technoloy Ltd. All Rights Reserved.
 */
class Container extends BaseContainer implements ContainerContract
{
    protected static $aliasMap = [
        'container'     =>      [Container::class, ContainerContract::class, ContainerInterface::class, BaseContainer::class, BaseContainerContract::class, Application::class, \Illuminate\Contracts\Foundation\Application::class],
        'events'        =>      [Dispatcher::class, DispatcherContract::class, \Illuminate\Events\Dispatcher::class, \Illuminate\Contracts\Events\Dispatcher::class, EventDispatcher::class, EventDispatcherInterface::class],
        'loader'        =>      [Loader::class]
    ];
    
    /**
     * Container constructor.
     *
     * @return void
     */
    public function __construct()
    {
        if (class_exists($loader_class = static::SERVICE_LOADER))
        {
            $this->instance('loader', new $loader_class($this));
        }
        
        $this->bindContainer();
        $this->bindAliasesToContainer();
    }
    
    /**
     * Bind the Container and any Modifications to
     * the base container.
     *
     * @return void
     */
    private function bindContainer()
    {
        parent::setInstance($this);
        
        $this->instance('container', $this);
        $this->instance(BaseContainer::class, $this);
    }
    
    /**
     * @param string $abstract
     * @param array  $parameters
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make($abstract, array $parameters = [])
    {
        $abstract = $this->getAlias($abstract);
    
        return parent::make($abstract, $parameters);
    }
    
    /**
     * Bind the Aliases for OneFramework to the Container... No matter what, I guess.
     *
     * @return void
     */
    private function bindAliasesToContainer()
    {
        foreach (static::$aliasMap as $alias => $classes)
        {
            foreach ($classes as $class)
            {
                $this->alias($alias, $class);
            }
        }
    }
}