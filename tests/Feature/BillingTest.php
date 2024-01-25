<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;

it('can run a basic test', function () {
    $this->assertTrue(true);
});

it('can create an invoice', function () {
    // Arrange
    $invoice_creator = User::factory()->create(['role' => 'employee']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $response = $this->actingAs($invoice_creator)->post('/api/invoices', [
        'business_id' => $invoice_creator->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    // Assert
    $response->assertStatus(201); // Expecting a successful creation response

    // Ensure the invoice is stored in the database
    expect(Invoice::where('invoice_number', 'INV-001')->exists())->toBeTrue();
});

it('can not create an invoice', function () {
    // Arrange
    $invoice_creator = User::factory()->create(['role' => 'client']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $response = $this->actingAs($invoice_creator)->post('/api/invoices', [
        'business_id' => $invoice_creator->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-002',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    // Assert
    $response->assertStatus(403); // Expecting a not successful creation response

    // Ensure the invoice is stored in the database
    expect(Invoice::where('invoice_number', 'INV-002')->exists())->toBeFalse();
});

it('can edit the invoice', function () {
    // Arrange
    $invoice_creator = User::factory()->create(['role' => 'employee']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $invoice = $this->actingAs($invoice_creator)->post('/api/invoices', [
        'business_id' => $invoice_creator->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    $invoice->assertStatus(201); // Expecting a successful creation response

    $invoice_id = Invoice::where('invoice_number', 'INV-001')->first()->id;

    $updated_invoice = $this->actingAs($invoice_creator)->put('/api/invoices/'.$invoice_id, [
        'business_id' => $invoice_creator->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'paid',
    ]);

    // Assert
    $updated_invoice->assertStatus(200); // Expecting a successful update response

    // Ensure the status is paid in the invoice
    expect(Invoice::where('invoice_number', 'INV-001')->where('status', 'paid')->exists())->toBeTrue();
});

it('can not edit the invoice', function () {
    // Arrange
    $invoice_creator_1 = User::factory()->create(['role' => 'employee']);

    $invoice_creator_2 = User::factory()->create(['role' => 'employee']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $invoice = $this->actingAs($invoice_creator_1)->post('/api/invoices', [
        'business_id' => $invoice_creator_1->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    $invoice->assertStatus(201); // Expecting a successful creation response

    $invoice_id = Invoice::where('invoice_number', 'INV-001')->first()->id;

    $updated_invoice = $this->actingAs($invoice_creator_2)->put('/api/invoices/'.$invoice_id, [
        'business_id' => $invoice_creator_2->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'paid',
    ]);

    // Assert
    $updated_invoice->assertStatus(403); // Expecting a not successful update response

    // Ensure the status is paid in the invoice
    expect(Invoice::where('invoice_number', 'INV-001')->where('status', 'paid')->exists())->toBeFalse();
});

it('can delete the invoice', function () {
    // Arrange
    $invoice_creator = User::factory()->create(['role' => 'employee']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $invoice = $this->actingAs($invoice_creator)->post('/api/invoices', [
        'business_id' => $invoice_creator->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    $invoice->assertStatus(201); // Expecting a successful creation response

    $invoice_id = Invoice::where('invoice_number', 'INV-001')->first()->id;

    $deleted_invoice = $this->actingAs($invoice_creator)->delete('/api/invoices/'.$invoice_id);

    // Assert
    $deleted_invoice->assertStatus(200); // Expecting a successful update response

    // Ensure the status is paid in the invoice
    expect(Invoice::where('id', $invoice_id)->exists())->toBeFalse();
});

it('can not delete the invoice', function () {
    // Arrange
    $invoice_creator_1 = User::factory()->create(['role' => 'employee']);

    $invoice_creator_2 = User::factory()->create(['role' => 'employee']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $invoice = $this->actingAs($invoice_creator_1)->post('/api/invoices', [
        'business_id' => $invoice_creator_1->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    $invoice->assertStatus(201); // Expecting a successful creation response

    $invoice_id = Invoice::where('invoice_number', 'INV-001')->first()->id;

    $deleted_invoice = $this->actingAs($invoice_creator_2)->delete('/api/invoices/'.$invoice_id);

    // Assert
    $deleted_invoice->assertStatus(403); // Expecting a not successful update response

    // Ensure the status is paid in the invoice
    expect(Invoice::where('id', $invoice_id)->exists())->toBeTrue();
});

it('can only accessed by the InvoiceOwner', function () {
    // Arrange
    $invoice_creator = User::factory()->create(['role' => 'employee']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $invoice = $this->actingAs($invoice_creator)->post('/api/invoices', [
        'business_id' => $invoice_creator->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    $invoice->assertStatus(201); // Expecting a successful creation response

    $invoice_id = Invoice::where('invoice_number', 'INV-001')->first()->id;

    $fetched_invoice = $this->actingAs($invoice_creator)->get('/api/invoices/'.$invoice_id);

    // Assert
    $fetched_invoice->assertStatus(200); // Expecting a successful update response

    $this->assertEquals('INV-001', $fetched_invoice['invoice_number']);

});

it('can not be accessed except the InvoiceOwner', function () {
    // Arrange
    $invoice_creator_1 = User::factory()->create(['role' => 'employee']);

    $invoice_creator_2 = User::factory()->create(['role' => 'employee']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $invoice = $this->actingAs($invoice_creator_1)->post('/api/invoices', [
        'business_id' => $invoice_creator_1->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    $invoice->assertStatus(201); // Expecting a successful creation response

    $invoice = Invoice::where('invoice_number', 'INV-001')->first();

    $invoice_id = $invoice->id;

    $fetched_invoice = $this->actingAs($invoice_creator_2)->get('/api/invoices/'.$invoice_id);

    // Assert
    $fetched_invoice->assertStatus(403); // Expecting a not successful update response

    // Ensure the status is paid in the invoice
    $this->assertNotEquals($invoice_creator_2->id, $invoice->user_id);
});

it('can access all the invoices', function () {
    // Arrange
    $user = User::factory()->create(['role' => 'owner']);

    $invoice_creator_1 = User::factory()->create(['role' => 'employee']);

    $invoice_creator_2 = User::factory()->create(['role' => 'employee']);

    $user_client = User::factory()->create(['role' => 'client']);

    $client = Client::factory()->create(['user_id' => $user_client->id]);

    // Act
    $invoice_1 = $this->actingAs($invoice_creator_1)->post('/api/invoices', [
        'business_id' => $invoice_creator_1->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-001',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    $invoice_2 = $this->actingAs($invoice_creator_2)->post('/api/invoices', [
        'business_id' => $invoice_creator_1->business_id,
        'client_id' => $client->id,
        'invoice_number' => 'INV-002',
        'total_amount' => 100.00,
        'due_date' => now()->addDays(30)->toDateString(),
        'status' => 'draft',
    ]);

    $invoice_1->assertStatus(201); // Expecting a successful creation response

    $invoice_2->assertStatus(201); // Expecting a successful creation response

    $all_invoices = $this->actingAs($user)->get('/api/invoices/');

    // Assert
    $all_invoices->assertStatus(200); // Expecting a not successful update response

});
