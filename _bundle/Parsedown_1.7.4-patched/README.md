# Parsedown 1.7.4 Patched for PHP 8.4.x

The stable release of `Parsedown` version 1.7.4 throws deprecation warings in PHP 8.4.x and above.

## Bare Minimum Patched Version

This directory contains a patched version of Parsedown 1.7.4 for integration tests.

The modifications are bare minimal to remove the deprecation warnings in PHP 8.4.x.

Use [this](./Parsedown.php), or [patch](./patch.sh) the Parsedown 1.7.4 if you want no extra features made in current [`master` branch](https://github.com/erusev/parsedown/tree/master).

> [!IMPORTANT]
> **This fix will break backward compatibility**.
>
> For older PHP users (PHP 5.x, 6.x, 7.x, 8.x-8.3), keep using the original Parsedown 1.7.4.
>
> This fixed version will not work for older than PHP 8.3. Since the warning fix rely on the "**deprecation of the implicitly marking parameter as nullable**" from PHP 8.4.x.
