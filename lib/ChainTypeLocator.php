<?php

namespace Phpactor\ReferenceFinder;

use Phpactor\ReferenceFinder\Exception\CouldNotLocateType;
use Phpactor\ReferenceFinder\Exception\UnsupportedDocument;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\Location;
use Phpactor\TextDocument\TextDocument;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class ChainTypeLocator implements TypeLocator
{
    /**
     * @var TypeLocator[]
     */
    private $locators = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(array $locators, LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
        foreach ($locators as $locator) {
            $this->add($locator);
        }
    }

    private function add(TypeLocator $locator)
    {
        $this->locators[] = $locator;
    }

    public function locateType(TextDocument $document, ByteOffset $byteOffset): Location
    {
        $messages = [];
        foreach ($this->locators as $locator) {
            try {
                return $locator->locateType($document, $byteOffset);
            } catch (UnsupportedDocument $unsupported) {
                $this->logger->debug(sprintf(
                    'Document is unsupported by "%s": %s',
                    get_class($locator),
                    $unsupported->getMessage()
                ));
            } catch (CouldNotLocateType $exception) {
                $this->logger->info(sprintf('Could not locate definition ""%s"', $exception->getMessage()));
                $messages[] = $exception->getMessage();
            }
        }

        if ($messages) {
            throw new CouldNotLocateType(implode(', ', $messages));
        }

        throw new CouldNotLocateType('Unable to locate definition');
    }
}