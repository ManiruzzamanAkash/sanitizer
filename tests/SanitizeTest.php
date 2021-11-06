<?php

namespace Maniruzzaman\SanitizerTest\Unit;

use Maniruzzaman\Sanitizer\Sanitize;
use PHPUnit\Framework\TestCase;

class SanitizeTest extends TestCase
{
    /**
     * Constructor test
     *
     * @return Sanitize
     */
    private $sanitize;

    public function __construct()
    {
        parent::__construct();
        $this->sanitize = new Sanitize();
    }

    /**
     * @test
     */
    public function it_can_check_if_testing_working_or_not()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_can_check_if_text_sanitization_works_with_html_text_to_normal_string()
    {
        $this->assertEquals("Test", "Test");
        $this->assertEquals('Hello World', $this->sanitize->text('<p>Hello World</p>'));
    }

    /**
     * @test
     */
    public function it_can_check_if_text_sanitization_works_with_script_html_text_to_normal_string()
    {
        $this->assertEquals('Hello World alert(&quot;You are hacked&quot;)', $this->sanitize->text('<p>Hello World <script>alert("You are hacked")</script></p>'));
    }
}
