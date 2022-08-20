<?php

namespace Tests\Api\V1\Board;

use Tests\ApiTestCase;

// todo fix tests after authentication

class CreateBoardTest extends ApiTestCase
{
    public function testCreateSuccess()
    {
        $response = $this->post(
            "$this->baseUri/board",
            ['name' => 'board_name']
        );

        $response->assertStatus(201)
            ->assertJsonStructure(['id']);
    }

    public function testCreateEmptyName()
    {
        $response = $this->post(
            "$this->baseUri/board",
            []
        );

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'The name field is required.']);
    }

    public function testCreateLongName()
    {
        $response = $this->post(
            "$this->baseUri/board",
            ['name' => str_repeat('*', 101)]
        );

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'The name must not be greater than 100 characters.']);
    }

    public function testGuest()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $response = $this->post(
            "$this->baseUri/board",
            ['name' => 'board_name']
        );

        $response->assertStatus(401);
    }
}
