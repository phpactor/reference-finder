<?php

namespace Phpactor\ReferenceFinder;

use Generator;
use Phpactor\TextDocument\ByteOffset;
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

    public function findReferences(TextDocument $document, ByteOffset $byteOffset): Generator
    {
        foreach ($this->finders as $finder) {
            yield from $finder->findReferences($document, $byteOffset);
        }
    }
}
