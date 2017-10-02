<?php
namespace Warchiefs\StockExchangeIntegration;

use Warchiefs\StockExchangeIntegration\Contracts\StockExchange;


class StockExchangeRegistry
{

	protected $exchanges = [];

	/**
	 * Register container instance.
	 * Used in provider.
	 *
	 * @param               $name
	 * @param StockExchange $instance
	 *
	 * @return $this
	 */
	function register ($name, StockExchange $instance) {
		$this->exchanges[$name] = $instance;

		return $this;
	}

	/**
	 * Get needed instance or default from config.
	 * Used in controllers, jobs, models etc.
	 *
	 * @param null $name
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	function get($name = null) {

		if(!$name) {
			return $this->exchanges[config('exchange.default')];
		}

		if (isset($this->exchanges[$name])) {
			return $this->exchanges[$name];
		} else {
			throw new \Exception("Invalid data exchange instance");
		}
	}

}