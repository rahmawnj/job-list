<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->insert([
            'name' => 'Rahma',
            'email' => 'rahma@gmail.com',
            'image' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png',
            'password' => Hash::make('rahma'),
        ]);
     
        DB::table('jobcategories')->insert([
            'name' => 'Arsitek',
            'slug' => 'architek',
        ]);
        DB::table('jobcategories')->insert([
            'name' => 'Software Engineer',
            'slug' => 'software-engineer',
        ]);
        DB::table('locations')->insert([
            'name' => 'Bandung',
        ]);
        DB::table('locations')->insert([
            'name' => 'Jakarta',
        ]);
        DB::table('locations')->insert([
            'name' => 'Bekasi',
        ]);
        DB::table('locations')->insert([
            'name' => 'Cikarang',
        ]);
        DB::table('locations')->insert([
            'name' => 'Kerawang',
        ]);
        DB::table('locations')->insert([
            'name' => 'Tangerang',
        ]);
        DB::table('locations')->insert([
            'name' => 'Depok',
        ]);
        DB::table('locations')->insert([
            'name' => 'Bogor',
        ]);
        
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('companies')->insert([
            'name' => 'PT Indah',
            'website' => 'software-engineer',
            'show' => 'active',
            'logo' => 'uploads/image/companies/VpPNn5LAcVydtmAOfSoiqkvKT68fDOks2m9dWF6R.png'
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 2,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'freelancer',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'full_time',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'full_time',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'full_time',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'full_time',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => 'sa',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => '5',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => '4',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => '3',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => '2',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('jobs')->insert([
            'company_id' => '1',
            'jobcategory_id' => '1',
            'experience' => 'sa',
            'salary' => 'sa',
            'type' => 'sa',
            'title' => '1',
            'skills' => 'sa',
            'total_position' => 'sa',
            'location_id' => 1,
            'status' => 'sa',
            'description' => 'sa',
            'requirement' => 'sa',
        ]);
        DB::table('contents')->insert([
            'name' => 'name',
            'description' => 'Top Talents Consulting'
        ]);
        DB::table('contents')->insert([
            'name' => 'hero_image',
            'description' => 'uploads/image/contents/XRqYynp3vhuIVbPnRev9UnQ6peeO5h42AzNdwYpI.png'
        ]);
        DB::table('contents')->insert([
            'name' => 'hero_description',
            'description' => 'Top Talents Consulting'
        ]);
        DB::table('contents')->insert([
            'name' => 'logo_header',
            'description' => 'uploads/image/contents/XP0oz4BBgHWP2ngUWRsGHvTiJn325K5qPo8ahW7k.png'
        ]);
        DB::table('contents')->insert([
            'name' => 'logo_footer',
            'description' => 'uploads/image/contents/0JV06yKQxt0v4n5Si62lEdiIAbyyXG3IRR33vfSI.png'
        ]);
        DB::table('contents')->insert([
            'name' => 'phone',
            'description' => '+62 857-3506-0719'
        ]);
        DB::table('contents')->insert([
            'name' => 'email',
            'description' => 'official@toptalentsconsulting.co.id'
        ]);
        DB::table('contents')->insert([
            'name' => 'address',
            'description' => 'MULA by Galeria Jakarta Jl. T.B. Simatupang Kav. 17, Cilandak Barat, RT.2/RW.1, Cilandak, RT.6/RW.9, Cilandak Bar., Kec. Cilandak, Daerah Khusus Ibukota Jakarta 12430'
        ]);
        DB::table('contents')->insert([
            'name' => 'about',
            'description' => '<p>1. Search a job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea. 2. Apply for job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea. 3. Get your job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>

            <p>&nbsp;</p>
            
            <p>1. Search a job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea. 2. Apply for job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea. 3. Get your job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>
            
            <p>1. Search a job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea. 2. Apply for job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea. 3. Get your job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>
            
            <p>&nbsp;</p>
            
            <p>&nbsp;</p>
            
            <p>1. Search a job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea. 2. Apply for job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea. 3. Get your job Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.</p>'
        ]);
        DB::table('contents')->insert([
            'name' => 'since',
            'description' => '2022'
        ]);
        DB::table('contents')->insert([
            'name' => 'hero_caption_description',
            'description' => 'Human Resource Solution'
        ]);
        DB::table('contents')->insert([
            'name' => 'slider_background',
            'description' => 'uploads/image/contents/jkZvpF8Obc7s0cOkxQdMQkM9Un30X9XhBm26wu1x.png'
        ]);
        DB::table('contents')->insert([
            'name' => 'about_image',
            'description' => 'uploads/image/contents/eSvYJ7AdiCbDC52TPwjHq5jrkVeEMQ2nORPgP2p8.png'
        ]);
        DB::table('contents')->insert([
            'name' => 'map_location',
            'description' => 'MULA by Galeria Jakarta Jl. T.B. Simatupang Kav. 17, Cilandak Barat, RT.2/RW.1, Cilandak, RT.6/RW.9, Cilandak Bar., Kec. Cilandak, Daerah Khusus Ibukota Jakarta 12430'
        ]);

        DB::table('contents')->insert([
            'name' => 'email_apply',
            'description' => 'liim@toptalentsconsulting.co.id'
        ]);

        DB::table('contents')->insert([
            'name' => 'title_jobs_hero',
            'description' => 'Get Your Job'
        ]);
        DB::table('contents')->insert([
            'name' => 'title_about_hero',
            'description' => 'About Us'
        ]);
        DB::table('contents')->insert([
            'name' => 'title_contact_hero',
            'description' => 'Contact Us'
        ]);

        DB::table('applyprocesses')->insert([
            'title' => '1. Find a Job',
            'logo' => 'uploads/image/applyprocesses/uPWNX1zQOYxwSRsXoJkVwiLzzpcrsyOqSWglEVy9.png',
            'description' => 'Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.'
        ]);
        DB::table('applyprocesses')->insert([
            'title' => '2. Find a Job',
            'logo' => 'uploads/image/applyprocesses/NIsaZOn2Fctvb9Spzt4Uhno4tA1q8yTuR9DOqzV2.png',
            'description' => 'Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.'
        ]);
        DB::table('applyprocesses')->insert([
            'title' => '3. Find a Job',
            'logo' => 'uploads/image/applyprocesses/uSwsa9A8MywkrJUNIaEY00nt0fW7sn1HlaJkoL8K.png',
            'description' => 'Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.'
        ]);
        DB::table('applyprocesses')->insert([
            'title' => '4. Find a Job',
            'logo' => 'uploads/image/applyprocesses/gvvUzun4MssZxuZQvoRF8iKyjmQjqLjqQ1UwymG1.png',
            'description' => 'Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.'
        ]);
        DB::table('topcategories')->insert([
            'title' => '1. Find a Job',
            'logo' => 'uploads/image/topcategories/uPWNX1zQOYxwSRsXoJkVwiLzzpcrsyOqSWglEVy9.png',
            'description' => 'Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.'
        ]);
        DB::table('topcategories')->insert([
            'title' => '2. Find a Job',
            'logo' => 'uploads/image/topcategories/NIsaZOn2Fctvb9Spzt4Uhno4tA1q8yTuR9DOqzV2.png',
            'description' => 'Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.'
        ]);
        DB::table('topcategories')->insert([
            'title' => '3. Find a Job',
            'logo' => 'uploads/image/topcategories/uSwsa9A8MywkrJUNIaEY00nt0fW7sn1HlaJkoL8K.png',
            'description' => 'Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.'
        ]);
        DB::table('topcategories')->insert([
            'title' => '4. Find a Job',
            'logo' => 'uploads/image/topcategories/gvvUzun4MssZxuZQvoRF8iKyjmQjqLjqQ1UwymG1.png',
            'description' => 'Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.'
        ]);
       
    }
}
