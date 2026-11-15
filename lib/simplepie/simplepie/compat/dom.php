<?php

// SPDX-FileCopyrightText: 2026 Alexandre Alapetite
// SPDX-License-Identifier: BSD-3-Clause

/**
 * Loader for the `Dom\` classes polyfill.
 */

if (\PHP_VERSION_ID < 80400 && !class_exists(\Dom\HTMLDocument::class, false)) {
    require_once __DIR__ . '/dom-polyfill.php';
}
