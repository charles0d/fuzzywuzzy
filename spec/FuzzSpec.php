<?php

declare(strict_types=1);

namespace spec\FuzzyWuzzy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FuzzSpec extends ObjectBehavior
{
    static string $s1 = "new york mets";
    static string $s1a = "new york mets";
    static string $s2 = "new YORK mets";
    static string $s3 = "the wonderful new york mets";
    static string $s4 = "new york mets vs atlanta braves";
    static string $s5 = "atlanta braves vs new york mets";
    static string $s6 = "new york mets - atlanta braves";
    static string $s7 = 'new york city mets - atlanta braves';

    static array $cirque_strings = [
        "cirque du soleil - zarkana - las vegas",
        "cirque du soleil ",
        "cirque du soleil las vegas",
        "zarkana las vegas",
        "las vegas cirque du soleil at the bellagio",
        "zarakana - cirque du soleil - bellagio"
    ];

    static array $baseball_strings = [
        "new york mets vs chicago cubs",
        "chicago cubs vs chicago white sox",
        "philladelphia phillies vs atlanta braves",
        "braves vs mets",
    ];

    function it_is_initializable(): void
    {
        $this->shouldHaveType('FuzzyWuzzy\Fuzz');
    }

    function it_returns_a_perfect_match_for_ratio(): void
    {
        $this->ratio(self::$s1, self::$s1a)->shouldBe(100);
    }

    function it_is_case_sensitive_for_ratio(): void
    {
        $this->ratio(self::$s1, self::$s2)->shouldNotBe(100);
    }

    function it_returns_a_perfect_match_for_partial_ratio(): void
    {
        $this->partialRatio(self::$s1, self::$s3)->shouldBe(100);
    }
}
