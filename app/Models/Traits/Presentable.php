<?php 

namespace App\Models\Traits;

use App\Exceptions\PresenterException;

trait Presentable {

	/**
	 * View presenter instance
	 *
	 * @var mixed
	 */
	protected $presenterInstance;

	/**
	 * Prepare a new or cached presenter instance
	 *
	 * @return mixed
	 * @throws PresenterException
	 */
	public function present()
	{
		if ( ! $this->presenter or ! class_exists($this->presenter))
		{
			throw new PresenterException('Please set the $presenter property to your presenter path.');
		}

		if ( ! $this->presenterInstance)
		{
			$this->presenterInstance = new $this->presenter($this);
		}

		return $this->presenterInstance;
	}

} 