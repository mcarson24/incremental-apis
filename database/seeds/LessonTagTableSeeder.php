<?php

use App\Lesson;
use App\Tag;
use Illuminate\Database\Seeder;

class LessonTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$lessonIds = Lesson::count('id');
		$tagIds = Tag::count('id');

		foreach(range(1, 30) as $i)
		{
			DB::table('lesson_tag')->insert([
				'lesson_id' => rand(1, $lessonIds),
				'tag_id' => rand(1, $tagIds)
			]);
		}
    }
}
