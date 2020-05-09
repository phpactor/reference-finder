<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\Locations;
use Phpactor\TextDocument\TextDocument;

final class ChainReferenceFinder implements ReferenceFinder
{
    /**
     * @var ReferenceFinder[]
     */
    private $finders = [];

    public function __construct(array $finders)
    {
        foreach ($finders as $finder) {
            $this->add($finder);
        }
    }

    private function add(ReferenceFinder $finder)
    {
        $this->finders[] = $finder;
    }

    public function findReferences(TextDocument $document, ByteOffset $byteOffset): Locations
    {
        $messages = [];
        $locations = [];
        foreach ($this->finders as $finder) {
            $locations = array_merge($locations, iterator_to_array($finder->findReferences($document, $byteOffset)));
        }

        return new Locations($locations);
    }
}
