<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;

interface DefinitionLocator
{
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset): DefinitionLocation;
}
