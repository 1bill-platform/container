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
use OneFramework\Container\Contracts\ContainerContract;
use Psr\Container\ContainerInterface;
use OneFramework\ServiceLoader\Loader;

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
    protected $abstractAliases = [
        
        'container'                 =>  [
            Container::class,
            BaseContainer::class,
            ContainerInterface::class,

            "Illuminate\\Contracts\\Container\\Container",
            "Illuminate\\Contracts\\Foundation\\Application",
            "Illuminate\\Foundation\\Application"
        ]
        
    ];
    
    protected $aliases   =      [
        
        "Illuminate\\Contracts\\Container\\Container"               =>          'container',
        "Illuminate\\Contracts\\Foundation\\Application"            =>          'container',
        "Illuminate\\Foundation\\Application"                       =>          'container',
        
        Container::class                =>          'container',
        BaseContainer::class            =>          'container',
        ContainerInterface::class       =>          'container',
        
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
    }
    
    /**
     * Bind the Container and any Modifications to
     * the base container.
     *
     * @return void
     */
    protected function bindContainer()
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
     */
    public function make($abstract, array $parameters = [])
    {
        $abstract = $this->getAlias($abstract);
    
        return parent::make($abstract, $parameters);
    }
}