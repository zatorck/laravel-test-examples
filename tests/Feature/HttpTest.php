<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

/**
 * Class HttpTest
 *
 * @url https://laravel.com/docs/5.8/http-tests
 *
 * @package Tests\Feature
 */
class HttpTest extends TestCase
{
    use RefreshDatabase;

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
         * Add custom header
         */
        $response = $this->withHeaders([
            'Authenitaction ' => 'Basic lsdldsl',
        ])->json('POST', '/test-with-header', ['name' => 'Nazwa']);

        /*
         * Check success status
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

        $this->assertTrue(true);
    }

    /**
     * NO 3. With Session
     */
    public function testWithSession()
    {
        $response = $this->withSession(['foo' => 'bar'])->get('/test-session');

        /*
        * Check if json contains bar
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
            ->actingAs($user)// Without this line you get 302 HTTP STATUS
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
            // this has to be exact json response as presented
            ->assertExactJson(
                ['status' => 'success']
            );
    }

    /**
     * NO 5. Testing File Uploads
     */
    public function testFileUpload()
    {
        /*
         * If storage is identical to this use in testing method image [storage() <- second argument]
         * will be stored in storage/testing/disks/...
         * Otherwise it will be stored normally
         */
        Storage::fake('avatars');

        /*
         * Create fake image
         */
        $file = UploadedFile::fake()->image('avatar.jpg');

        /*
         * Sending Request
         */
        $response = $this->json('POST', '/test-file', [
            'avatar' => $file,
        ]);
        $response->assertStatus(200);

        // Assert the file was stored...
        Storage::disk('avatars')->assertExists($file->hashName());

        // Assert a file does not exist...
        Storage::disk('avatars')->assertMissing('missing.jpg');
    }


}
