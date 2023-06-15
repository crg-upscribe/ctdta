<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
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
