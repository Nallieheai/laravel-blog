<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');
        $response->assertSeeText("Welcome to Laravel");
        $response->assertSeeText("This is the content of the web page");
    }

    public function testContactPageIsWorkingCorrectly()
    {
        $response = $this->get('/contact');
        $response->assertSeeText("Contact!");
    }
}
