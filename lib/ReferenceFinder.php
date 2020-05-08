<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\TextDocument\Locations;

use Phpactor\TextDocument\ByteOffset;

use Phpactor\TextDocument\TextDocument;

interface ReferenceFinder
{
    /**
     * Find references to the symbol at the given byte offset.
     */
    public function findReferences(TextDocument $document, ByteOffset $byteOffset): Locations;
}
