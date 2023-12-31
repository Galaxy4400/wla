<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(AdminPermissionsSeeder::class);
		$this->call(AdminRolesSeeder::class);
		$this->call(AdminSeeder::class);
		$this->call(PageSeeder::class);
		$this->call(MenuSeeder::class);
	}
}
