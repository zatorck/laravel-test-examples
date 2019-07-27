<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HttpTest extends TestCase
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

    /**
     * NO 1. Customizing Request Headers
     */
    public function testWithHeader()
    {
        /*
         * Dodaj customowy header
         */
        $response = $this->withHeaders([
                'Authenitaction ' => 'Basic lsdldsl',
        ])->json('POST', '/test-with-header', ['name' => 'Nazwa']);

        /*
         * Sprwadź czy przychodzi status success
         */
        $response
                ->assertStatus(201)
                ->assertJson([
                        'status' => 'success',
                ]);
    }

    /**
     * NO 2. Debugging Responses
     */
    public function testDebuggingResponses()
    {
        $respone = $this->get('/');

        $respone->dumpHeaders();

        $respone->dump();
    }

    /**
     * NO 3. With Session
     */
    public function testWithSession()
    {
        $response = $this->withSession(['foo' => 'bar'])->get('/test-session');

        /*
        * Sprwadź czy przychodzi status success
        */
        $response
                ->assertStatus(200)
                ->assertJson([
                        'foo' => 'bar',
                ]);
    }

    /**
     * NO 3. With Session
     */
    public function testWithSessionAndAuth()
    {
        //this add user to DB
        $user = factory(User::class)->create();

        $response = $this
                ->actingAs($user) // Without this line you get 302 HTTP STATUS
                ->withSession(['foo' => 'bar'])
                ->get('/test-session-with-auth');


        /*
        * Check is response is 200 and contains status => success
        */
        $response
                ->assertStatus(200)
                // this function dont look at whole response, so it accepts elements in presented array
                ->assertJson([
                        'foo' => 'bar',
                ]);
    }

    /**
     * NO 4. Verifying An Exact JSON Match
     */
    public function testVerifyingAnExactJsonMatch()
    {
        $response = $this->json('POST', '/testVerifyingAnExactJsonMatch', ['name' => 'Sally']);

        $response
                ->assertStatus(201)

                ->assertExactJson(
                        ['status' => 'success']
                );
    }
}
