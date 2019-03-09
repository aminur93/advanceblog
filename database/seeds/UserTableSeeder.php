<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //reset the user tables
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('users')->truncate();

        //generate 3 user author
        $faker = Factory::create();
        DB::table('users')->insert([
          [
            'name' => 'aminur',
            'slug' => 'aminur-rashid',
            'email' => 'aminur126@gmail.com',
            'password' => bcrypt('aminur93'),
              'bio'=> $faker->text(rand(250, 350)),
              'image' => 'man.png'
          ],

          [
            'name' => 'rashid',
            'slug' => 'rashid-khan',
            'email' => 'rashid126@gmail.com',
            'password' => bcrypt('aminur93'),
              'bio'=> $faker->text(rand(250, 350)),
              'image' => 'handsome.png'
          ],

          [
            'name' => 'khan',
            'slug' => 'khan-ahmed',
            'email' => 'khan126@gmail.com',
            'password' => bcrypt('aminur93'),
              'bio'=> $faker->text(rand(250, 350)),
              'image' => 'boy.png'
          ],
        ]);
    }
}
