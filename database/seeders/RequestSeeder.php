<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Fetching a user to associate the request with
          $user = User::first(); // You can use any user or loop through users to assign requests

          DB::table('requests')->insert([
              [
                  'user_id' => $user->id, // Set the user_id reference
                  'requested_amount' => 1000.00,
                  'reason' => 'Emergency medical expense',
                  'title' => 'Medical Assistance',
                  'status' => 'Pending',
              ],
              [
                  'user_id' => $user->id, // Same user for this request
                  'requested_amount' => 500.00,
                  'reason' => 'School fees for children',
                  'title' => 'Education Fees',
                  'status' => 'Approved',
              ],
              [
                  'user_id' => $user->id, // Same user for this request
                  'requested_amount' => 2000.00,
                  'reason' => 'Business investment',
                  'title' => null,
                  'status' => 'Disapproved',
              ]
          ]);
    }
}
