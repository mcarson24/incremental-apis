<?php

namespace App\Http\Controllers;

use App\Acme\Transformers\LessonTransformer;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LessonsController extends Controller
{

	/**
	 * @var LessonTransformer
	 */
	protected $lessonTransformer;

	/**
	 * LessonsController constructor.
	 * @param LessonTransformer $lessonTransformer
	 */
	public function __construct(LessonTransformer $lessonTransformer)
	{
		$this->lessonTransformer = $lessonTransformer;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = Lesson::all(); // really bad practice!!
		// Because:
		// Returning everything is bad; we want paginated results.
		// There is no way to attach meta-data.
		// Linking db structure to API output.
		// No way to signal headers/response codes.

		return Response::json([
			'data' => $this->lessonTransformer->transformCollection($lessons)
		], 200);
    }

    /**
     * Show thR form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$lesson = Lesson::find($id);

		if (!$lesson)
		{
			return Response::json([
				'errors' => [
					'message' => 'Lesson does not exist.'
				]
			], 404);
		}

		return Response::json([
			'data' => $this->lessonTransformer->transform($lesson)
		], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
	{
		//
	}
}
