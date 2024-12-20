<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'id' => 'A01',
            'name' => 'admin',
            'mobile' => '9999999999',
            'email' => 'admin@gmail.com',
            'password' => '$2y$12$XRs1JWhO1e.RsFQ9z6UJyO2unrAvsbInAVh9/bzaRdPTQWOpepzsi',
            'role' => 'AD',
            'status' => '1',
            'username' => 'admin',
        ]);

        DB::table('secuence')->insert([

            [
                'type' => 'client',
                'head' => 'CL',
                'remarks' => 'client',
                'status' => 1,
                'sno' => '0'
            ],
            [
                'type' => 'supplier',
                'head' => 'S',
                'remarks' => 'supplier',
                'status' => 1,
                'sno' => '0'
            ],
            [
                'type' => 'asso_ext',
                'head' => 'AE',
                'remarks' => 'external assosite',
                'status' => 1,
                'sno' => '0'
            ],
            [
                'type' => 'asso_int',
                'head' => 'AI',
                'remarks' => 'internal assosite',
                'status' => 1,
                'sno' => '0'
            ],
            [
                'type' => 'rp',
                'head' => 'R',
                'remarks' => 'Raw Product',
                'status' => 1,
                'sno' => '0'
            ],
            [
                'type' => 'fp',
                'head' => 'F',
                'remarks' => 'Raw Product',
                'status' => 1,
                'sno' => '0'
            ],
            [
                'type' => 'paysup',
                'head' => 'SP',
                'remarks' => 'Supp Payment',
                'status' => 1,
                'sno' => '0'
            ],
            [
                'type' => 'stkent',
                'head' => 'Stk',
                'remarks' => 'Stock Entry',
                'status' => 1,
                'sno' => '0'
            ],

        ]);


        // DB::table('secuence')->insert([
        //     [
        //         'id' => 1,
        //         'type' => 'job',
        //         'head' => 'FLCN/23-24/JB',
        //         'remarks' => 'sc',
        //         'status' => 1,
        //         'sno' => '0'


        //     ],
        //     [
        //         'id' => 2,
        //         'type' => 'paysup',
        //         'head' => 'FLCN/23-24/PAY',
        //         'remarks' => 'sc',
        //         'status' => 1,
        //         'sno' => '0'
        //     ],
        //     [
        //         'id' => 3,
        //         'type' => 'dc',
        //         'head' => 'FLCN/23-24/DC',
        //         'remarks' => 'sc',
        //         'status' => 1,
        //         'sno' => '0'
        //     ],
        //     [
        //         'id' => 4,
        //         'type' => 'client',
        //         'head' => 'CL',
        //         'remarks' => 'sc',
        //         'status' => 1,
        //         'sno' => '0'
        //     ],
        //     [
        //         'id' => 5,
        //         'type' => 'user',
        //         'head' => 'U',
        //         'remarks' => 'sc',
        //         'status' => 1,
        //         'sno' => '0'
        //     ],
        // ]);


    }
}
