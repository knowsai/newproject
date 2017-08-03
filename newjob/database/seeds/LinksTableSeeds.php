<?php

use Illuminate\Database\Seeder;

class LinksTableSeeds extends Seeder
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
            'link_order' => 6,
        	],

        	[
            'link_name' => str_random(5),
            'link_content' => str_random(15),
            'link_url' => str_random(10),
            'link_order' => 7,
        	]
    	];
        DB::table('links')->insert($data);
    }
}
