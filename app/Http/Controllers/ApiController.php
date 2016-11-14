<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;

class ApiController extends Controller {

	/**
	 * @var int
	 */
	protected $statusCode = 200;

	/**
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @param mixed $statusCode
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function respondNotFound($message = 'Not Found!')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function respondInternalError($message = 'Internal Error!')
	{
		return $this->setStatusCode(500)->respondWithError($message);
	}

	/**
	 * @param $message
	 * @return mixed
	 */
	public function respondWithError($message)
	{
		return $this->respond([
			'errors' => [
				'message' => $message,
				'status_code'   => $this->getStatusCode()
			]
		]);
	}

	/**
	 * @param $data
	 * @param array $headers
	 * @return mixed
	 */
	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(), $headers);
	}

}