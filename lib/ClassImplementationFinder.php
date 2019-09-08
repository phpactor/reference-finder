<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\Locations;

interface ClassImplementationFinder
{
    public function findImplementations(TextDocument $document, ByteOffset $byteOffset): Locations;
}
