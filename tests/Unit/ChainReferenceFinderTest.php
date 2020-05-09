<?php


namespace Phpactor\ReferenceFinder\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\ReferenceFinder\ChainReferenceFinder;
use Phpactor\ReferenceFinder\ClassReferenceFinder;
use Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\Location;
use Phpactor\TextDocument\Locations;
use Phpactor\TextDocument\TextDocument;
use Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor\TextDocument\TextDocumentUri;
use Prophecy\Prophecy\ObjectProphecy;

class ChainReferenceFinderTest extends TestCase
{
    /**
     * @var ObjectProphecy|ClassReferenceFinder
     */
    private $locator1;

    /**
     * @var ObjectProphecy|ClassReferenceFinder
     */
    private $locator2;

    /**
     * @var TextDocument
     */
    private $document;

    /**
     * @var ByteOffset
     */
    private $offset;

    public function setUp()
    {
        $this->locator1 = $this->prophesize(ReferenceFinder::class);
        $this->locator2 = $this->prophesize(ReferenceFinder::class);

        $this->document = TextDocumentBuilder::create('<?php ')->build();
        $this->offset = ByteOffset::fromInt(1234);
    }

    public function testProvidesAggregateLocations()
    {
        $locator = new ChainReferenceFinder([
            $this->locator1->reveal(),
            $this->locator2->reveal()
        ]);

        $location1 = $this->createLocation();
        $this->locator1->findReferences($this->document, $this->offset)->willReturn(new Locations([$location1]));

        $location2 = $this->createLocation();
        $this->locator2->findReferences($this->document, $this->offset)->willReturn(new Locations([$location2]));

        $locations = $locator->findReferences($this->document, $this->offset);
        $this->assertEquals(new Locations([$location1, $location2], $locations), $locations);
    }

    private function createLocation(): Location
    {
        return new Location(TextDocumentUri::fromString('/path/to.php'), ByteOffset::fromInt(1234));
    }
}
