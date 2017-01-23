<?php


namespace App\Acme\Transformers;


use Illuminate\Database\Eloquent\Collection;

abstract class Transformer {

	/**
	 * Transform a collection of lessons.
	 *
	 * @param $items
	 * @return mixed
	 */
	public function transformCollection($items)
	{
		return $items->map(function($item) {
			return $this->transform($item);
		});
	}

	public abstract function transform($item);

}