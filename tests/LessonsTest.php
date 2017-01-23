<?php

use App\Lesson;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LessonsTest extends ApiTester
{
	use DatabaseMigrations;

   /** @test */
   public function it_fetches_lessons()
   {
	   $this->makeLesson();
	   $this->getJson('api/v1/lessons');
	   $this->assertResponseOk();
   }

   /** @test */
   public function it_fetches_a_single_lesson()
   {
	   $this->makeLesson();
	   $lesson = $this->getJson('api/v1/lessons/1');
	   $lesson = json_decode($lesson->response->content())->data;

	   $this->assertObjectHasAttributes($lesson, 'title', 'body', 'active');
   }

   /** @test */
   public function it_404s_if_a_lesson_is_not_found()
   {
	   $this->getJson('api/v1/lessons/x');

	   $this->assertResponseStatus(404);
   }

   /** @test */
   public function it_creates_a_new_lesson_given_valid_parameters()
   {
       $user = factory(App\User::class)->create();

       $this->json('POST', "api/v1/lessons/?api_token={$user->api_token}", factory(App\Lesson::class)->create()->toArray());

       $this->assertResponseStatus(201);
   }

   /** @test */
   public function it_throws_a_422_if_a_new_lesson_request_fails_validation()
    {
        $user = factory(App\User::class)->create();

        $this->json('POST', "api/v1/lessons/?api_token={$user->api_token}");

        $this->assertResponseStatus(422);
    }

	private function makeLesson($lessonFields = [])
	{
		if ($this->times == 1)
		{
			return factory(Lesson::class)->create($lessonFields);
		}

		while ($this->times--) factory(Lesson::class)->create($lessonFields);
	}
}
