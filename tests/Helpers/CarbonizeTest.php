<?php

namespace Malbrandt\Lori\Tests\Helpers;


use DateTime;
use DateTimeImmutable;
use Illuminate\Support\Carbon;
use Malbrandt\Lori\Tests\TestCase;

class CarbonizeTest extends TestCase
{
    //tests
    //todo: date as string
    const DATES = [
        '2018-06-15 12:34:00',
        '2018-06-15 17:34:15.984512',
        'first day of May 2000',
        '2015-02-05',
    ];

    /** @test */
    public function unifies_date_passed_as_a_string()
    {
        foreach (self::DATES as $date) {
            $this->assertInstanceOf(Carbon::class, carbonize($date));
        }
    }

    /** @test */
    public function unifies_carbon_carbon_objects()
    {
        $this->assertInstanceOf(Carbon::class,
            carbonize(\Carbon\Carbon::parse(self::DATES[0])));
    }

    /** @test */
    public function clones_illuminate_support_carbon_objects()
    {
        $actual = Carbon::parse(self::DATES[0]);
        $carbonized = carbonize($actual);
        $this->assertInstanceOf(Carbon::class, $carbonized);
        $this->assertNotEquals($actual, $carbonized);
    }

    /** @test */
    public function converts_datetime_objects()
    {
        $this->assertInstanceOf(Carbon::class, new DateTime());
    }

    /** @test */
    public function converts_datetime_immutable_objects()
    {
        $this->assertInstanceOf(Carbon::class, new DateTimeImmutable());
    }

    /** @test */
    public function returns_null_if_cannot_unify()
    {
        $this->assertNull('foobar');
    }
}
