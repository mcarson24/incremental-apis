<?php

namespace App\Http\Controllers;

use App\Acme\Transformers\LessonTransformer;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LessonsController extends ApiController
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

		$this->middleware('auth:api', ['only' => 'store']);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ?: 3;

        $limit = ($limit > 25) ? 25 : $limit;

        $lessons = Lesson::paginate($limit); // really bad practice!!

//        dd(get_class_methods($lessons));
		// Because:
		// Returning everything is bad; we want paginated results.
		// There is no way to attach meta-data.
		// Linking db structure to API output.
		// No way to signal headers/response codes.

        return $this->respondWithPagination($lessons, [
            'data' => $this->lessonTransformer->transformCollection($lessons)
        ]);
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
		if (!$request->input('title') || !$request->input('description'))
		{
			return $this->returnFailedValidation('Lesson parameters failed validation.');
		}

		Lesson::create($request->all());

		return $this->respondCreated('Lesson successfully created.');
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
			return $this->respondNotFound('That lesson does not exist.');
		}

		return $this->respond([
			'data' => $this->lessonTransformer->transform($lesson)
		]);
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
