<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_uuid_is_generated_on_create(): void
    {
        $user = User::factory()->create(['uuid' => null]);

        $this->assertNotNull($user->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $user->uuid
        );
    }

    public function test_user_activity_description_for_known_events(): void
    {
        $user = new User();

        $this->assertSame('User activated', $user->getActivityDescription('activated'));
        $this->assertSame('User login', $user->getActivityDescription('login'));
        $this->assertSame('User custom_event', $user->getActivityDescription('custom_event'));
    }
}
