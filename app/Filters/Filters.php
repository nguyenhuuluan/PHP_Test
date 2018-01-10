<?php

namespace App\Filters;
use Illuminate\Http\Request;


abstract class Filters
{
	protected $request, $builder;

	protected $filters = [];
	public function __construct(Request $request)
	{
		$this->request = $request;
	}
	public function apply($builder)
	{	
		$this->builder = $builder;

		// dd($this->request->all());
		// dd($this->request->only($this->filters));
		//dd($this->getFilters());

/*		$this->getFilters()
			->filter(function($filter){
				return method_exists($this, $filter);
			})
			->each(function($filter, $value){
				$this->$filter($value);
			});*/


		foreach ($this->getFilters() as $filter =>$value) {
			if(method_exists($this, $filter))
			{
				$this->$filter($value);
			}
			// if(! $this->hasFilter($filter)) return;
			// 	$this->$filter($this->request->$filter);
		}
			return $this->builder;
	}

	public function getFilters()
	{
		//return collect($this->request->only($this->filters))->flip();
		return $this->request->only($this->filters);
	}

	// 	protected function hasFilter($filter):bool
	// {
	// 	return $this->request->has($filter);
	// }
}