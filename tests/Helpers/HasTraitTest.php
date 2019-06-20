<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Malbrandt\Lori\Tests\TestCase;

class HasTraitTest extends TestCase
{
    use HasTraitTestTrait;

    /** @test */
    public function examines_properly_when_object_instance_passed()
    {
        $withTestTrait = new class()
        {
            use HasTraitTestTrait;
        };
        $this->assertTrue(has_trait(HasTraitTestTrait::class, $withTestTrait));

        $withoutTestTrait = new class()
        {
            use HasTraitOtherTrait;
        };
        $this->assertFalse(has_trait(HasTraitTestTrait::class,
            $withoutTestTrait));
        $this->assertTrue(has_trait(HasTraitOtherTrait::class,
            $withoutTestTrait));
    }

    /** @test */
    public function examines_properly_when_class_name_passed()
    {
        $this->assertTrue(has_trait(HasTraitTestTrait::class, self::class));
        $this->assertFalse(has_trait(HasTraitOtherTrait::class, self::class));
    }

}

trait HasTraitTestTrait
{
}

trait HasTraitOtherTrait
{
}