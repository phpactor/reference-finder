<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;
use Phpactor\ReferenceFinder\DefinitionLocator;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class ChainDefinitionLocationProvider implements DefinitionLocator
{
    /**
     * @var DefinitionLocator[]
     */
    private $providers = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(array $providers, LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
        foreach ($providers as $provider) {
            $this->add($provider);
        }
    }

    private function add(DefinitionLocator $provider)
    {
        $this->providers[] = $provider;
    }

    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset): DefinitionLocation
    {
        foreach ($this->providers as $provider) {
            try {
                return $provider->locateDefinition($document, $byteOffset);
            } catch (CouldNotLocateDefinition $exception) {
                $this->logger->info(sprintf('Could not locate definition ""%s"', $exception->getMessage()));
            }
        }

        throw new CouldNotLocateDefinition(sprintf('Could not locate definition with "%s" locators', count($this->providers)));
    }
}
