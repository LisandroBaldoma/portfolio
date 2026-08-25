<?php

namespace Tests\Feature;

use App\Jobs\SendContactEmail;
use App\Models\Contact;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContactSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_a_contact_and_its_selected_services(): void
    {
        Queue::fake();

        $service = Service::create([
            'name' => 'Desarrollo web',
            'slug' => 'desarrollo-web',
            'is_active' => true,
        ]);

        $response = $this->from('/')->post('/contact/send', [
            'name' => 'María Pérez',
            'email' => 'maria@example.com',
            'phone' => '+54 9 341 123 4567',
            'company' => 'Empresa Ejemplo',
            'inquiry_type' => 'propuesta_laboral',
            'message' => 'Quisiera conversar sobre una propuesta laboral.',
            'services' => [$service->id],
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('contacts', [
            'name' => 'María Pérez',
            'email' => 'maria@example.com',
            'inquiry_type' => 'propuesta_laboral',
            'status' => 'nuevo',
        ]);

        $contact = Contact::where('email', 'maria@example.com')->firstOrFail();
        $this->assertTrue($contact->services->contains($service));
        Queue::assertPushed(SendContactEmail::class);
    }
}
