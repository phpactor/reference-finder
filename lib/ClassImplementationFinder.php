<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\Name\FullyQualifiedName;
use Phpactor\TextDocument\Locations;

interface ClassImplementationFinder
{
    public function findImplementations(FullyQualifiedName $name): Locations;
}
