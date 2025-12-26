<?php

namespace Tests\Feature;

use App\Models\Patient;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class PatientRegistrationTest extends TestCase
{
    use DatabaseTransactions; // Use DatabaseTransactions to rollback changes after test

    /** @test */
    public function it_can_register_a_patient_without_providing_patient_type_directly()
    {
        $mrNumber = 'MR-' . rand(1000, 9999);
        
        $data = [
            'mr_number' => $mrNumber,
            'registration_date' => Carbon::now()->toDateString(),
            'name' => 'John Doe',
            'marital_status' => 'Single',
            'date_of_birth' => '1990-01-01',
            'is_welfare' => 0, // Should result in 'Normal'
            'relation_type' => 'Self',
            'guardian_name' => 'Jane Doe',
            'guardian_cnic' => '12345-1234567-1',
            'weight' => 75.5,
            'gender' => 'Male',
            'mobile_number' => '03001234567',
            'email' => 'john@example.com',
            'cnic' => '12345-1234567-1',
            'address' => '123 Main St',
        ];

        // Ensure patient_type is NOT in the request data
        $this->assertArrayNotHasKey('patient_type', $data);

        $response = $this->post(route('patients.store'), $data);

        $response->assertRedirect(route('patients.all'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('patients', [
            'mr_number' => $mrNumber,
            'name' => 'John Doe',
            'patient_type' => 'Normal', // Verified derived value
        ]);
    }

    /** @test */
    public function it_registers_welfare_patient_correctly()
    {
        $mrNumber = 'MR-' . rand(1000, 9999);
        
        $data = [
            'mr_number' => $mrNumber,
            'registration_date' => Carbon::now()->toDateString(),
            'name' => 'Jane Smith',
            'marital_status' => 'Married',
            'date_of_birth' => '1985-05-15',
            'is_welfare' => 1, // Should result in 'Welfare'
            'relation_type' => 'Self',
            'guardian_name' => 'John Smith',
            'guardian_cnic' => '54321-7654321-1',
            'weight' => 60.0,
            'gender' => 'Female',
            'mobile_number' => '03007654321',
            'email' => 'jane@example.com',
            'cnic' => '54321-7654321-1',
            'address' => '456 Another St',
        ];

        $response = $this->post(route('patients.store'), $data);

        $response->assertRedirect(route('patients.all'));
        
        $this->assertDatabaseHas('patients', [
            'mr_number' => $mrNumber,
            'name' => 'Jane Smith',
            'patient_type' => 'Welfare', // Verified derived value
        ]);
    }
}
