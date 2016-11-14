<?php


namespace App\Acme\Transformers;


class LessonTransformer extends Transformer {

	public function transform($lesson)
	{
		return [
			'title'  => $lesson->title,
			'body'   => $lesson->description,
			'active' => (boolean) $lesson->some_bool
		];
	}
}