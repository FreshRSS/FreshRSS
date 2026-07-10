<?php
declare(strict_types=1);

namespace FreshRss\Minz;

class Hook {
	public const DEFAULT_PRIORITY = 0;

	public function __construct(
		private readonly \Closure $function,
		private readonly int $priority,
	) {
	}

	public function getFunction(): \Closure {
		return $this->function;
	}

	public function getPriority(): int {
		return $this->priority;
	}
}
