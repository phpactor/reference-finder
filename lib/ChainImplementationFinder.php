<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\Locations;
use Phpactor\TextDocument\TextDocument;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class ChainImplementationFinder implements ClassImplementationFinder
{
    /**
     * @var ClassImplementationFinder[]
     */
    private $finders = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(array $finders, LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
        foreach ($finders as $finder) {
            $this->add($finder);
        }
    }

    private function add(ClassImplementationFinder $finder)
    {
        $this->finders[] = $finder;
    }

    public function findImplementations(TextDocument $document, ByteOffset $byteOffset): Locations
    {
        $messages = [];
        $locations = [];
        foreach ($this->finders as $finder) {
            $locations = array_merge($locations, iterator_to_array($finder->findImplementations($document, $byteOffset)));
        }

        return new Locations($locations);
    }
}
