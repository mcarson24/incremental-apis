<?php

use App\Tag;
use App\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
	private $tables;

	public function __construct()
	{
		$this->tables = collect([
			'lessons',
			'tags',
			'lesson_tag'
		]);
	}
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->cleanDatabase();

        // $this->call(UsersTableSeeder::class);
		$this->call(LessonsTableSeeder::class);
		$this->call(TagsTableSeeder::class);
		$this->call(LessonTagTableSeeder::class);
    }

	/**
	 *
	 */
	private function cleanDatabase()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0');

		$this->tables->each(function($table) {
			DB::table($table)->truncate();
		});

		DB::statement('SET FOREIGN_KEY_CHECKS=1');
	}
}
