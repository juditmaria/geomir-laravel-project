<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name'      => 'Catalan',
            'flag'      => '',
            'abbr'      => 'ca',
            'script'    => 'Latn',
            'native'    => 'català',
            'active'    => '0',
            'default'   => '0',
        ]);
    }
}
