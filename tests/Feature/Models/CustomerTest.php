<?php

namespace Tests\Feature\Models;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use WithFaker;

    public function test_customerModel(): void
    {
        $email = $this->faker->email();
        Customer::factory()->create(['email' => $email]);

        $this->assertDatabaseHas('customers', ['email' => $email]);
    }

    public function test_customerEndpoint(): void
    {
        Customer::factory()->count(4)->create();
        $count = Customer::count();

        $this->assertEquals(4, $count);

        $route = route('api.customers.index');
        $response = $this->get($route);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(4, 'customers');
    }

}
