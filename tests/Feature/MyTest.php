<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetImages(){
        $response = $this->get('/get-images');
        $response->assertStatus(200);
        $response->assertJson([]);
    }

    public function testGetFiles(){
        $response = $this->get('/get-files');

        $response->assertStatus(200);
        $response->assertJson([]);
    }

    public function testValidationForm(){
        $data = ['email'=>"mr.aashiz@gmail.com",
    "_token" => csrf_token()];

        $response = $this->post('/submit-details',$data);

        $response->assertStatus(302);
    
        
        
    }
}
