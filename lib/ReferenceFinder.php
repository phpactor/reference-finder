<?php

namespace Phpactor\ReferenceFinder;

use Generator;
use Phpactor\TextDocument\Location;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;

interface ReferenceFinder
{
    /**
     * Find references to the symbol at the given byte offset.
     *
     * @return Generator<Location>
     */
    public function findReferences(TextDocument $document, ByteOffset $byteOffset): Generator;
}
