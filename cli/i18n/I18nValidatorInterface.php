<?php

interface I18nValidatorInterface {

	/**
	 * Display the validation result.
	 * Empty if there are no errors.
	 *
	 * @return array
	 */
	public function displayResult();

	/**
	 * @return bool
	 */
	public function validate();

	/**
	 * Display the validation report.
	 *
	 * @return string
	 */
	public function displayReport();

}
