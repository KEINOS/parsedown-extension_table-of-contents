# ParsedownExtra 0.8.1 Patched for PHP 7.1+ up to 8.4

The stable release of `ParsedownExtra` version 0.8.1 throws deprecation warings in PHP 7.1 and above, including PHP 8.4.

## Bare Minimum Patched Version

This directory contains a patched version of ParsedownExtra 0.8.1 for integration tests.

The modifications are bare minimal to remove the deprecation warnings from PHP 7.1 and above.

Use [this](./ParsedownExtra.php), or [patch](./patch.sh) the ParsedownExtra 0.8.1 if you want no extra features made in current [`master` branch](https://github.com/erusev/parsedown-extra/tree/master).

> [!IMPORTANT]
> **This fix will break backward compatibility**.
>
> For older PHP users (PHP 5.x, 6.x, 7.0), keep using the original ParsedownExtra 0.8.1.
>
> This fixed version will not work for older than PHP 7.1. Since the deprecation warning fix rely on the feature implemented "**nullable type declarations with the `?T` syntax**" from PHP 7.1.
