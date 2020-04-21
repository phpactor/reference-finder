<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\Locations;
use Phpactor\TextDocument\TextDocument;

final class ChainImplementationFinder implements ClassImplementationFinder
{
    /**
     * @var ClassImplementationFinder[]
     */
    private $finders = [];

    public function __construct(array $finders)
    {
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
