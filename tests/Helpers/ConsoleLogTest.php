<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Malbrandt\Lori\Tests\TestCase;

class ConsoleLogTest extends TestCase
{
    /** @test */
    public function renders_html_with_encoded_data()
    {
        $data = [1, 2, 3];
        $this->assertEquals(
            '<script type="text/javascript">console.log([1,2,3]);</script>',
            console_log($data)
        );
    }
}
