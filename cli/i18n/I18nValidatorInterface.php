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
	 * @param array $ignore Keys to ignore for validation
	 * @return bool
	 */
	public function validate($ignore);

	/**
	 * Display the validation report.
	 *
	 * @return array
	 */
	public function displayReport();

}
