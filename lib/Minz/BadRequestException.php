<?php
declare(strict_types=1);

namespace FreshRss\Minz;

/**
 * An exception raised when user input is invalid.
 * The front controller turns it into a HTTP 400 Bad Request error page.
 */
class BadRequestException extends Exception {

}
