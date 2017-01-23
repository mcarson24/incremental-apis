<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Lesson;
use Illuminate\Http\Request;
use App\Acme\Transformers\TagTransformer;

class TagsController extends ApiController
{
	protected $tagTransformer;

	public function __construct(TagTransformer $tagTransformer)
	{
		$this->tagTransformer = $tagTransformer;
	}

	public function index($id = null)
	{
		$tags = $this->getLessonTags($id);

		return $this->respond([
			'data' => $this->tagTransformer->transformCollection($tags)
		]);
	}

	/**
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Collection
	 * @internal param Lesson $lesson
	 */
	private function getLessonTags($id)
	{
		return $id ? Lesson::findOrFail($id)->tags : Tag::all();
	}
}
