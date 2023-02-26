<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Requests;

class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Requests::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        for ($i = 0; $i < 10; $i++) {
            DB::table('requests')->insert([
                'send_to_id' => $i+1,
                'send_by_id' => $i+2,
            ]);
        }
    }
}
