<?php

declare(strict_types=1);

namespace Journify\Test;

use PHPUnit\Framework;
use Journify\Journify;
use Journify\JournifyException;

final class JournifyTest extends Framework\TestCase
{
    protected function setUp(): void
    {
        self::resetJournify();
    }

    public function testAliasThrowsJournifyExceptionWhenClientHasNotBeenInitialized(): void
    {
        $this->expectException(JournifyException::class);
        $this->expectExceptionMessage('Journify::init() must be called before any other tracking method.');

        Journify::alias([]);
    }
    public function testFlushThrowsJournifyExceptionWhenClientHasNotBeenInitialized(): void
    {
        $this->expectException(JournifyException::class);
        $this->expectExceptionMessage('Journify::init() must be called before any other tracking method.');

        Journify::flush();
    }
    public function testGroupThrowsJournifyExceptionWhenClientHasNotBeenInitialized(): void
    {
        $this->expectException(JournifyException::class);
        $this->expectExceptionMessage('Journify::init() must be called before any other tracking method.');

        Journify::group([]);
    }
    public function testIdentifyThrowsJournifyExceptionWhenClientHasNotBeenInitialized(): void
    {
        $this->expectException(JournifyException::class);
        $this->expectExceptionMessage('Journify::init() must be called before any other tracking method.');

        Journify::identify([]);
    }
    public function testPageThrowsJournifyExceptionWhenClientHasNotBeenInitialized(): void
    {
        $this->expectException(JournifyException::class);
        $this->expectExceptionMessage('Journify::init() must be called before any other tracking method.');

        Journify::page([]);
    }
    public function testScreenThrowsJournifyExceptionWhenClientHasNotBeenInitialized(): void
    {
        $this->expectException(JournifyException::class);
        $this->expectExceptionMessage('Journify::init() must be called before any other tracking method.');

        Journify::screen([]);
    }
    public function testTrackThrowsJournifyExceptionWhenClientHasNotBeenInitialized(): void
    {
        $this->expectException(JournifyException::class);
        $this->expectExceptionMessage('Journify::init() must be called before any other tracking method.');

        Journify::track([]);
    }

    private static function resetJournify(): void
    {
        $property = new \ReflectionProperty(
            Journify::class,
            'client'
        );

        $property->setAccessible(true);
        $property->setValue(null);
    }
}