<?php
declare(strict_types=1);

final class CliOption {
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

	/** Sets this option to be treated as a flag. */
	public function withValueNone(): self {
		$this->valueTaken = static::VALUE_NONE;
		return $this;
	}

	/** Sets this option to always require a value when used. */
	public function withValueRequired(): self {
		$this->valueTaken = static::VALUE_REQUIRED;
		return $this;
	}

	/**
	 * Sets this option to accept both values and flag behavior.
	 * @param string $optionalValueDefault When this option is used as a flag it receives this value as input.
	 */
	public function withValueOptional(string $optionalValueDefault = ''): self {
		$this->valueTaken = static::VALUE_OPTIONAL;
		$this->optionalValueDefault = $optionalValueDefault;
		return $this;
	}

	public function typeOfString(): self {
		$this->types = ['type' => 'string', 'isArray' => false];
		return $this;
	}

	public function typeOfInt(): self {
		$this->types = ['type' => 'int', 'isArray' => false];
		return $this;
	}

	public function typeOfBool(): self {
		$this->types = ['type' => 'bool', 'isArray' => false];
		return $this;
	}

	public function typeOfArrayOfString(): self {
		$this->types = ['type' => 'string', 'isArray' => true];
		return $this;
	}

	public function deprecatedAs(string $deprecated): self {
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
