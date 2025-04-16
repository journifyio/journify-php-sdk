<?php

declare(strict_types=1);

namespace Journify\Test;

use PHPUnit\Framework\TestCase;
use Journify\Journify;
use Journify\JournifyException;

class AnalyticsTest extends TestCase
{
    public function setUp(): void
    {
        date_default_timezone_set('UTC');
        Journify::init('oq0vdlg7yi', ['debug' => true]);
    }

    public function testTrack(): void
    {
        self::assertTrue(
            Journify::track(
                [
                    'userId' => 'john',
                    'event'  => 'Module PHP Event',
                ]
            )
        );
    }

    public function testGroup(): void
    {
        self::assertTrue(
            Journify::group(
                [
                    'groupId' => 'group-id',
                    'userId'  => 'user-id',
                    'traits'  => [
                        'plan' => 'startup',
                    ],
                ]
            )
        );
    }

    public function testGroupAnonymous(): void
    {
        self::assertTrue(
            Journify::group(
                [
                    'groupId'     => 'group-id',
                    'anonymousId' => 'anonymous-id',
                    'traits'      => [
                        'plan' => 'startup',
                    ],
                ]
            )
        );
    }

    public function testGroupNoUser(): void
    {
        $this->expectExceptionMessage('Journify::group() requires userId or anonymousId');
        $this->expectException(JournifyException::class);
        Journify::group(
            [
                'groupId' => 'group-id',
                'traits'  => [
                    'plan' => 'startup',
                ],
            ]
        );
    }

    public function testMicrotime(): void
    {
        self::assertTrue(
            Journify::page(
                [
                    'anonymousId' => 'anonymous-id',
                    'name'        => 'analytics-php-microtime',
                    'category'    => 'docs',
                    'timestamp'   => microtime(true),
                    'properties'  => [
                        'path' => '/docs/libraries/php/',
                        'url'  => 'https://journify.io/docs/libraries/php/',
                    ],
                ]
            )
        );
    }

    public function testPage(): void
    {
        self::assertTrue(
            Journify::page(
                [
                    'anonymousId' => 'anonymous-id',
                    'name'        => 'analytics-php',
                    'category'    => 'docs',
                    'properties'  => [
                        'path' => '/docs/libraries/php/',
                        'url'  => 'https://journify.io/docs/libraries/php/',
                    ],
                ]
            )
        );
    }

    public function testBasicPage(): void
    {
        self::assertTrue(Journify::page(['anonymousId' => 'anonymous-id']));
    }

    public function testScreen(): void
    {
        self::assertTrue(
            Journify::screen(
                [
                    'anonymousId' => 'anonymous-id',
                    'name'        => '2048',
                    'category'    => 'game built with php :)',
                    'properties'  => [
                        'points' => 300,
                    ],
                ]
            )
        );
    }

    public function testBasicScreen(): void
    {
        self::assertTrue(Journify::screen(['anonymousId' => 'anonymous-id']));
    }

    public function testIdentify(): void
    {
        self::assertTrue(
            Journify::identify(
                [
                    'userId' => 'doe',
                    'traits' => [
                        'loves_php' => false,
                        'birthday'  => time(),
                    ],
                ]
            )
        );
    }

    public function testEmptyTraits(): void
    {
        self::assertTrue(Journify::identify(['userId' => 'empty-traits']));

        self::assertTrue(
            Journify::group(
                [
                    'userId'  => 'empty-traits',
                    'groupId' => 'empty-traits',
                ]
            )
        );
    }

    public function testEmptyArrayTraits(): void
    {
        self::assertTrue(
            Journify::identify(
                [
                    'userId' => 'empty-traits',
                    'traits' => [],
                ]
            )
        );

        self::assertTrue(
            Journify::group(
                [
                    'userId'  => 'empty-traits',
                    'groupId' => 'empty-traits',
                    'traits'  => [],
                ]
            )
        );
    }

    public function testEmptyProperties(): void
    {
        self::assertTrue(
            Journify::track(
                [
                    'userId' => 'user-id',
                    'event'  => 'empty-properties',
                ]
            )
        );

        self::assertTrue(
            Journify::page(
                [
                    'category' => 'empty-properties',
                    'name'     => 'empty-properties',
                    'userId'   => 'user-id',
                ]
            )
        );
    }

    public function testEmptyArrayProperties(): void
    {
        self::assertTrue(
            Journify::track(
                [
                    'userId'     => 'user-id',
                    'event'      => 'empty-properties',
                    'properties' => [],
                ]
            )
        );

        self::assertTrue(
            Journify::page(
                [
                    'category'   => 'empty-properties',
                    'name'       => 'empty-properties',
                    'userId'     => 'user-id',
                    'properties' => [],
                ]
            )
        );
    }

    public function testAlias(): void
    {
        self::assertTrue(
            Journify::alias(
                [
                    'previousId' => 'previous-id',
                    'userId'     => 'user-id',
                ]
            )
        );
    }

    public function testContextEmpty(): void
    {
        self::assertTrue(
            Journify::track(
                [
                    'userId'  => 'user-id',
                    'event'   => 'Context Test',
                    'context' => [],
                ]
            )
        );
    }

    public function testContextCustom(): void
    {
        self::assertTrue(
            Journify::track(
                [
                    'userId'  => 'user-id',
                    'event'   => 'Context Test',
                    'context' => ['active' => false],
                ]
            )
        );
    }

    public function testTimestamps(): void
    {
        self::assertTrue(
            Journify::track(
                [
                    'userId'    => 'user-id',
                    'event'     => 'integer-timestamp',
                    'timestamp' => (int)mktime(0, 0, 0, (int)date('n'), 1, (int)date('Y')),
                ]
            )
        );

        self::assertTrue(
            Journify::track(
                [
                    'userId'    => 'user-id',
                    'event'     => 'string-integer-timestamp',
                    'timestamp' => (string)mktime(0, 0, 0, (int)date('n'), 1, (int)date('Y')),
                ]
            )
        );

        self::assertTrue(
            Journify::track(
                [
                    'userId'    => 'user-id',
                    'event'     => 'iso8630-timestamp',
                    'timestamp' => date(DATE_ATOM, mktime(0, 0, 0, (int)date('n'), 1, (int)date('Y'))),
                ]
            )
        );

        self::assertTrue(
            Journify::track(
                [
                    'userId'    => 'user-id',
                    'event'     => 'iso8601-timestamp',
                    'timestamp' => date(DATE_ATOM, mktime(0, 0, 0, (int)date('n'), 1, (int)date('Y'))),
                ]
            )
        );

        self::assertTrue(
            Journify::track(
                [
                    'userId'    => 'user-id',
                    'event'     => 'strtotime-timestamp',
                    'timestamp' => strtotime('1 week ago'),
                ]
            )
        );

        self::assertTrue(
            Journify::track(
                [
                    'userId'    => 'user-id',
                    'event'     => 'microtime-timestamp',
                    'timestamp' => microtime(true),
                ]
            )
        );

        self::assertTrue(
            Journify::track(
                [
                    'userId'    => 'user-id',
                    'event'     => 'invalid-float-timestamp',
                    'timestamp' => ((string)mktime(0, 0, 0, (int)date('n'), 1, (int)date('Y'))) . '.',
                ]
            )
        );
    }
}
