<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username'    => 'hydrogen11',
            'email'       => 'david4good@hotmail.com',
            'password'    => Hash::make('12345678'),
            'verified'    => 1,
            'admin'       => 1,
        ]);

        DB::table('users')->insert([
            'username'    => 'test',
            'email'       => 'test@hotmail.com',
            'password'    => Hash::make('test'),
            'verified'    => 1,
            'admin'       => 1,
        ]);

        DB::table('users')->insert([
            'username'    => 'John',
            'email'       => 'john@hotmail.com',
            'password'    => Hash::make('d1erere66'),
            'verified'    => 1,
            'admin'       => 0,
        ]);

        DB::table('users')->insert([
            'username'    => 'samula4544',
            'email'       => 'sam@hotmail.com',
            'password'    => Hash::make('d16331ere3'),
            'verified'    => 1,
            'admin'       => 0,
        ]);

        DB::table('users')->insert([
            'username'    => 'jenny123',
            'email'       => 'jenney@hotmail.com',
            'password'    => Hash::make('tty31633'),
            'verified'    => 1,
            'admin'       => 0,
        ]);

        DB::table('users')->insert([
            'username'    => 'alexander_theGreat',
            'email'       => 'alexk@hotmail.com',
            'password'    => Hash::make('tyty33133'),
            'verified'    => 1,
            'admin'       => 0,
        ]);
    }
}
