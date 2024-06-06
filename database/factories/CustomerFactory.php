<?php

// database/factories/CustomerFactory.php
namespace Database\Factories;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'contact' => $this->faker->phoneNumber,
            // 'user_id' will be filled when creating a Customer with a User
        ];
    }

    /**
     * Indicate that the customer should have a user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withUser()
    {
        return $this->for(User::factory(), 'user');
    }
    
}