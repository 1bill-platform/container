<?php
namespace OneFramework\Container\Contracts;

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

use OneFramework\Container\Container;

/**
 * Interface Definition: ContainerAwareContract
 *
 * Interface defining the structure of the ContainerAwareTrait.
 *
 * @package     oneframework/container
 * @subpackage  ContainerAwareContract
 * @license     MIT License
 * @link        https://www.elixant.ca
 * @author      Alexander Schmautz <ceo@elixant.ca>
 * @copyright   Copyright (c) 2018 Elixant Technoloy Ltd. All Rights Reserved.
 */
interface ContainerAwareContract
{
    const CONTAINER_AWARE = true;
    
    /**
     * Return the attached Container Instance, and if one isn't already
     * attached, then grab the main one from the global Namespace.
     *
     * @return Container
     */
    public function getContainer();
    
    /**
     * Define or Attach a Container Instance to the defining Class.
     * This is typically used in the event that there's need for a custom
     * container instance.
     *
     * @param Container $container
     *
     * @return void
     */
    public function setContainer(Container $container);
}