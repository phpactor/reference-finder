<?php

namespace Phpactor\ReferenceFinder\Search;

use Phpactor\Name\FullyQualifiedName;

final class NameSearchResult
{
    /**
     * @var NameSearchResultType
     */
    private $type;

    /**
     * @var FullyQualifiedName
     */
    private $name;

    private function __construct(NameSearchResultType $type, FullyQualifiedName $name)
    {
        $this->type = $type;
        $this->name = $name;
    }

    /**
     * @param string|FullyQualifiedName $name
     * @param string|NameSearchResultType $name
     */
    public static function create($type, $name): self
    {
        return new self(
            is_string($type) ? new NameSearchResultType($type) : $type,
            is_string($name) ? FullyQualifiedName::fromString($name) : $name
        );
    }

    public function name(): FullyQualifiedName
    {
        return $this->name;
    }

    public function type(): NameSearchResultType
    {
        return $this->type;
    }
}
