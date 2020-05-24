<?php

namespace Phpactor\ReferenceFinder\Search;

use Phpactor\Name\FullyQualifiedName;

class NameSearchResult
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var FullyQualifiedName
     */
    private $name;

    private function __construct(string $type, FullyQualifiedName $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    /**
     * @param string|FullyQualifiedName $name
     */
    public static function create(string $type, $name): self
    {
        return new self($type, is_string($name) ? FullyQualifiedName::fromString($name) : $name);
    }

    public function name(): FullyQualifiedName
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }
}
