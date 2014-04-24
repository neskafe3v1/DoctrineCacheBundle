<?php

namespace Doctrine\Bundle\DoctrineCacheBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Cache\Cache;

/**
 * Flush a cache provider.
 */
abstract class CacheCommand extends ContainerAwareCommand
{
    /**
     * Get the requested cache provider service.
     */
    protected function getCacheProvider($cacheName)
    {
        $container = $this->getContainer();

        // Try to use user input as cache service alias.
        $cacheProvider = $container->get($cacheName, ContainerInterface::NULL_ON_INVALID_REFERENCE);

        // If cache provider was not found try the service provider name.
        if ( ! $cacheProvider instanceof Cache) {
            $cacheProvider = $container->get('doctrine_cache.providers.' . $cacheName, ContainerInterface::NULL_ON_INVALID_REFERENCE);
        }
        // Cache provider was not found.
        if ( ! $cacheProvider instanceof Cache) {
            throw new \InvalidArgumentException('Cache provider not found.');
        }

        return $cacheProvider;
    }
}
