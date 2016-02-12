<?php

namespace TorMorten\Eventy;

class Action extends Event {

	/**
	 * Filters a value
	 * @param  string $action Name of action
	 * @param  array  $args   Arguments passed to the filter
	 * @return string         Always returns the value
	 */
	public function fire($action, $args) {
		if($this->getListeners()) {
			foreach($this->getListeners() as $priority => $listeners) {
				foreach($listeners as $hook => $arguments) {
					if($hook === $action) {
						$parameters = array();
						for ($i=0; $i < $arguments['arguments']; $i++) {
							if(isset($args[$i])) {
								$parameters[] = $args[$i];
							}
						}
						call_user_func_array($this->getFunction($arguments['callback']), $parameters);
					}
				}
			}
		}
	}

}
