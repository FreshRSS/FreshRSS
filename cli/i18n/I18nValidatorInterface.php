<?php
declare(strict_types=1);

interface I18nValidatorInterface {

	/**
	 * Display the validation result.
	 * Empty if there are no errors.
	 */
	public function displayResult(): string;

	public function validate(): bool;

	/**
	 * Display the validation report.
	 */
	public function displayReport(): string;

}
