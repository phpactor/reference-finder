<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;

class TestDefinitionLocator implements DefinitionLocator
{
    /**
     * @var DefinitionLocation
     */
    private $location;

    private function __construct(DefinitionLocation $location)
    {
        $this->location = $location;
    }

    public static function fromLocation(DefinitionLocation $location): self
    {
        return new self($location);
    }

    /**
     * {@inheritDoc}
     */
    public function locateDefinition(TextDocument $document, ByteOffset $byteOffset): DefinitionLocation
    {
        return $this->location;
    }
}
