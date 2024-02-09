<?php
declare(strict_types=1);

class Option {
	public const VALUE_NONE = 'none';
	public const VALUE_REQUIRED = 'required';
	public const VALUE_OPTIONAL = 'optional';

	private string $valueTaken = self::VALUE_REQUIRED;
	/** @var array{type:string,isArray:bool} $types */
	private array $types = ['type' => 'string', 'isArray' => false];
	private string $optionalValueDefault = '';
	private ?string $deprecatedAlias = null;

	public function __construct(private readonly string $longAlias, private readonly ?string $shortAlias = null) {
	}

	public function withValueNone(): static {
		$this->valueTaken = static::VALUE_NONE;
		return $this;
	}

	public function withValueRequired(): static {
		$this->valueTaken = static::VALUE_REQUIRED;
		return $this;
	}

	public function withValueOptional(string $optionalValueDefault = ''): static {
		$this->valueTaken = static::VALUE_OPTIONAL;
		$this->optionalValueDefault = $optionalValueDefault;
		return $this;
	}

	public function typeOfString(): static {
		$this->types = ['type' => 'string', 'isArray' => false];
		return $this;
	}

	public function typeOfInt(): static {
		$this->types = ['type' => 'int', 'isArray' => false];
		return $this;
	}

	public function typeOfBool(): static {
		$this->types = ['type' => 'bool', 'isArray' => false];
		return $this;
	}

	public function typeOfArrayOfString(): static {
		$this->types = ['type' => 'string', 'isArray' => true];
		return $this;
	}

	public function deprecatedAs(string $deprecated): static {
		$this->deprecatedAlias = $deprecated;
		return $this;
	}

	public function getValueTaken(): string {
		return $this->valueTaken;
	}

	public function getOptionalValueDefault(): string {
		return $this->optionalValueDefault;
	}

	public function getDeprecatedAlias(): ?string {
		return $this->deprecatedAlias;
	}

	public function getLongAlias(): string {
		return $this->longAlias;
	}

	public function getShortAlias(): ?string {
		return $this->shortAlias;
	}

	/** @return array{type:string,isArray:bool} */
	public function getTypes(): array {
		return $this->types;
	}

	/** @return string[] */
	public function getAliases(): array {
		$aliases = [
			$this->longAlias,
			$this->shortAlias,
			$this->deprecatedAlias,
		];

		return array_filter($aliases);
	}
}
