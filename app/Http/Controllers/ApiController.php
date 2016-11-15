<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;
/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller {

	/**
	 * @var int
	 */
	protected $statusCode = HttpResponse::HTTP_OK;

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
		return $this->setStatusCode(HttpResponse::HTTP_NOT_FOUND)->respondWithError($message);
	}

	/**
	 * @param string $message
	 * @return mixed
	 */
	public function respondInternalError($message = 'Internal Error!')
	{
		return $this->setStatusCode(HttpResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
	}

	/**
	 * @param $message
	 * @return mixed
	 */
	protected function respondCreated($message)
	{
		return $this->setStatusCode(HttpResponse::HTTP_CREATED)->respond([
			'message' => $message
		]);
	}

	/**
	 * @param $message
	 * @return mixed
	 */
	protected function returnFailedValidation($message)
	{
		return $this->setStatusCode(HttpResponse::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
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