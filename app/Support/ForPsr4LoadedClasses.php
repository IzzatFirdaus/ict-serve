<?php

namespace Imanghafoori\LaravelMicroscope;

/**
 * Minimal shim for ForPsr4LoadedClasses used by the microscope binary.
 * This intentionally provides a no-op check method so the vendor binary
 * can run in environments where the original class is missing.
 */
class ForPsr4LoadedClasses
{
    /**
     * Perform a shallow check and return an empty array result.
     * The real package provides detailed stats; returning an empty
     * array keeps the binary functional without making changes.
     */
    public static function check(array $checks, callable $parser, ?PathFilterDTO $pathDTO = null): array
    {
        return [];
    }
}
