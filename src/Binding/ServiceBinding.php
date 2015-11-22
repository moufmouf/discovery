<?php

/*
 * This file is part of the webmozart/booking package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Puli\Discovery\Binding;

use Puli\Discovery\Api\Type\MissingParameterException;
use Puli\Discovery\Api\Type\NoSuchParameterException;
use Rhumsaa\Uuid\Uuid;

/**
 * Binds a service name to a binding type.
 *
 * @since  1.0
 *
 * @author David Négrier <d.negrier@thecodingmachine.com>
 */
class ServiceBinding extends AbstractBinding
{
    /**
     * @var string
     */
    private $serviceName;

    /**
     * Creates a new class binding.
     *
     * @param string    $serviceName     The identifier of the bound service.
     * @param string    $typeName        The name of the type to bind against.
     * @param array     $parameterValues The values of the parameters defined
     *                                   for the type.
     * @param Uuid|null $uuid            The UUID of the binding. A new one is
     *                                   generated if none is passed.
     *
     * @throws NoSuchParameterException  If an invalid parameter was passed.
     * @throws MissingParameterException If a required parameter was not passed.
     */
    public function __construct($serviceName, $typeName, array $parameterValues = array(), Uuid $uuid = null)
    {
        parent::__construct($typeName, $parameterValues, $uuid);

        $this->serviceName = $serviceName;
    }

    /**
     * Returns the name of the bound class.
     *
     * @return string The fully-qualified class name.
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * {@inheritdoc}
     */
    protected function preSerialize(array &$data)
    {
        parent::preSerialize($data);

        $data[] = $this->serviceName;
    }

    /**
     * {@inheritdoc}
     */
    protected function postUnserialize(array &$data)
    {
        $this->serviceName = array_pop($data);

        parent::postUnserialize($data);
    }
}
