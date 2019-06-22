<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Malbrandt\Lori\Tests\TestCase;

class ModelTableTest extends TestCase
{
    /** @test */
    public function returns_model_table_name_when_passed_model_class_name()
    {
        $this->assertEquals('fake_models', model_table(FakeModel::class));
    }

    /** @test */
    public function returns_model_table_name_when_passed_model_instance()
    {
        $instance = new FakeModel();
        $this->assertEquals('fake_models', model_table($instance));
    }

    /** @test */
    public function throws_an_exception_when_cannot_examine_model_table()
    {
        $this->expectException(InvalidArgumentException::class);
        model_table('Foobar');
    }
}

class FakeModel extends Model
{
    protected $table = 'fake_models';
}
