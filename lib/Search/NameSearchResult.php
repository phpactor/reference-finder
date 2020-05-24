<?php

namespace Phpactor\ReferenceFinder\Search;

use Phpactor\Name\FullyQualifiedName;
use RuntimeException;

class NameSearchResult
{
    const TYPE_CLASS = 'class';
    const TYPE_FUNCTION = 'function';

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
        $validTypes = [self::TYPE_FUNCTION, self::TYPE_CLASS];
        if (!in_array($type, $validTypes)) {
            throw new RuntimeException(sprintf(
                'Name search result type "%s" is invalid, must be one of "%s"',
                $type,implode('", "', $validTypes)
            ));
        }
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
