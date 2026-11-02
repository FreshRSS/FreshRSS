<?php
declare(strict_types=1);

/**
 * An exception raised when user input is invalid.
 * The front controller turns it into a HTTP 400 Bad Request error page.
 */
class Minz_BadRequestException extends Minz_Exception {

}
