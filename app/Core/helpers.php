<?php

/**
 * Retrieves an environment variable or returns a default value.
 *
 * @param string $key The environment variable key to retrieve.
 * @param mixed $default The default value to return if the variable is not found.
 * @return mixed The value of the environment variable or the default value.
 */
function env(string $key, mixed $default = null): mixed
{
    return getenv($key) !== false ? getenv($key) : $default;
}
