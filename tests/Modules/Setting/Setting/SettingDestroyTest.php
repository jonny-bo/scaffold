<?php namespace Tests\Modules\Setting\Setting;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Modules\User\Models\User;

class SettingDestroyTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

//      Prepare testing database environment.
        /**
         * $this->createTestUser();
         **/
    }

    public function testSettingDestroySuccessfully()
    {
        // Reference: https://laravel.com/docs/5.5/http-tests
        $user = factory(User::class)->create();
        $request = $this->actingAs($user, 'api');

        $response = $request->delete('api/setting/{id}');
        $response->assertStatus(200);
    }

    public function testSettingDestroyWithError()
    {
        // Reference: https://laravel.com/docs/5.5/http-tests
        $response = $this->delete('api/setting/{id}');
        $response->assertStatus(500);
    }
}
