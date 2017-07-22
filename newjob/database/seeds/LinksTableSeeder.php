<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data = [
    		[
            'link_name' => str_random(5),
            'link_content' => str_random(15),
            'link_url' => str_random(10),
            'link_order' => 1,
        	],

        	[
            'link_name' => str_random(5),
            'link_content' => str_random(15),
            'link_url' => str_random(10),
            'link_order' => 2,
        	]
    	];
        DB::table('links')->insert($data);
    }
}
