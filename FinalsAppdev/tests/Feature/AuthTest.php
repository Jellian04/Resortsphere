<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ResortOwner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class CustomRegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@gmail.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);
    
        $response->assertRedirect(route('register.form'));
            $response->assertSessionHas('success', 'Account created successfully!');
            $this->assertDatabaseHas('registers', ['email' => 'john.doe@gmail.com']);
    }

    public function test_user_cannot_register_with_duplicate_email()
    {
        User::create([
            'username' => 'janeDoe',
            'email' => 'jane.doe@gmail.com',
            'password' => bcrypt('Password123!'),
            'firstname' => 'Jane',
            'lastname' => 'Doe',
        ]);

        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'jane.doe@gmail.com',  // Duplicate email
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_cannot_register_with_non_gmail_email()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@yahoo.com',  // Invalid email domain
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_cannot_register_with_empty_password()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@gmail.com',
            'password' => '',
            'password_confirmation' => '',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_cannot_register_with_password_less_than_8_characters()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@gmail.com',
            'password' => 'Short1!',
            'password_confirmation' => 'Short1!',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_cannot_register_with_password_without_uppercase()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@gmail.com',
            'password' => 'password123!',
            'password_confirmation' => 'password123!',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_cannot_register_with_password_without_digit()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@gmail.com',
            'password' => 'Password!',
            'password_confirmation' => 'Password!',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_cannot_register_with_password_without_special_character()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@gmail.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_cannot_register_with_empty_firstname()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@gmail.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'firstname' => '',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('firstname');
    }

    public function test_user_cannot_register_with_empty_lastname()
    {
        $response = $this->post('/register', [
            'username' => 'johnDoe',
            'email' => 'john.doe@gmail.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'firstname' => 'John',
            'lastname' => '',
        ]);

        $response->assertSessionHasErrors('lastname');
    }

    public function test_user_cannot_register_with_missing_username()
    {
        $response = $this->post('/register', [
            'username' => '',  // Missing username
            'email' => 'john.doe@gmail.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response->assertSessionHasErrors('username');
    }

    // public function test_resort_owner_can_login_with_valid_credentials()
    // {
    //     // Create a ResortOwner with all required fields
    //     $owner = \App\Models\ResortOwner::create([
    //         'username'  => 'johnDoe' . uniqid(),  // Ensure a unique username
    //         'firstname' => 'John',
    //         'lastname'  => 'Doe',
    //         'email'     => 'john.doe' . uniqid() . '@example.com', // Ensure a unique email
    //         'password'  => bcrypt('Password123!'),
    //     ]);
        
       
    //     // Attempt to log in using the ResortOwner credentials (username and password)
    //     $response = $this->post('/login', [
    //         'username' => 'johnDoe',
    //         'password' => 'Password123!',
    //     ]);
       
    //     // Assert that the login was successful and user is redirected
    //     $response->assertRedirect(route('resort.owner')); // Adjust route if necessary
       
    //     // Assert that the ResortOwner is authenticated
    //     $this->assertAuthenticatedAs($owner);
    // }
    
    public function test_resort_owner_cannot_login_with_invalid_password()
    {
        // Create a ResortOwner instance
        \App\Models\User::create([
            'username'  => 'johnDoe',
            'email'     => 'john.doe@example.com',
            'password'  => bcrypt('Password123!'), // Store the correct password
            'firstname' => 'John',
            'lastname'  => 'Doe',
        ]);
        
        // Attempt to log in with an incorrect password
        $response = $this->from('/login')->post('/login', [
            'username' => 'johnDoe',
            'password' => 'WrongPassword!', // Incorrect password
        ]);
        
        // Assert that it redirects back to the login page
        $response->assertRedirect('/login');
        
        // Assert that session has errors for the password field
        $response->assertSessionHasErrors('password');
        
        // Assert that the user is not authenticated
        $this->assertGuest();
    }
    
    public function test_resort_owner_cannot_login_with_non_existent_username()
    {
        // Attempt login with a non-existent username
        $response = $this->post('/login', [
            'username' => 'nonExistentUser',
            'password' => 'Password123!',
        ]);

        // Assert that an error message is shown for the username
        $response->assertSessionHasErrors('username');
    }

    public function test_admin_can_login_with_valid_credentials()
    {
        // Attempt to login with admin credentials
        $response = $this->post('/login', [
            'username' => 'Admin',
            'password' => 'Admin246_>@',
        ]);

        // Assert login redirects to admin dashboard
        $response->assertRedirect(route('admin.dashboard'));
    }
    
}

