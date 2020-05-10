<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\TextDocument\Location;

final class PotentialLocation
{
    /**
     * @var Location
     */
    private $location;

    /**
     * @var bool
     */
    private $confirmed;

    public function __construct(Location $location, bool $confirmed)
    {
        $this->location = $location;
        $this->confirmed = $confirmed;
    }

    public function location(): Location
    {
        return $this->location;
    }

    public function confirmed(): bool
    {
        return $this->confirmed;
    }
}
