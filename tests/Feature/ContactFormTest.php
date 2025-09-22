<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_validation_works()
    {
        $response = $this->post('/contact', [
            'firstName' => '',
            'lastName' => '',
            'email' => 'invalid-email',
            'message' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'firstName',
            'lastName', 
            'email',
            'message'
        ]);
    }

    public function test_contact_form_submission_works()
    {
        $response = $this->post('/contact', [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '+94 77 123 4567',
            'subject' => 'general',
            'message' => 'This is a test message',
            'contactMethod' => 'email',
            'urgency' => 'normal',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('contact_messages', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'subject' => 'general',
        ]);
    }

    public function test_honeypot_spam_protection()
    {
        $response = $this->post('/contact', [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john@example.com',
            'message' => 'Test message',
            'website' => 'spam-content', // Honeypot field
            'subject' => 'general',
            'contactMethod' => 'email',
            'urgency' => 'normal',
        ]);

        // Should reject spam submissions
        $response->assertStatus(422);
    }

    public function test_contact_form_sanitizes_input()
    {
        $response = $this->post('/contact', [
            'firstName' => '<script>alert("xss")</script>John',
            'lastName' => 'Doe',
            'email' => 'john@example.com',
            'message' => '<script>alert("xss")</script>Clean message',
            'subject' => 'general',
            'contactMethod' => 'email',
            'urgency' => 'normal',
        ]);

        $response->assertStatus(200);

        // Check that script tags are removed/escaped
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'john@example.com',
        ]);

        $message = \App\Models\ContactMessage::where('email', 'john@example.com')->first();
        $this->assertStringNotContainsString('<script>', $message->first_name);
        $this->assertStringNotContainsString('<script>', $message->message);
    }
}