# ParsedownExtra 0.8.1 Patched for PHP 8.2.x

## Bare Minimum Patched Version

This directory contains a patched version of ParsedownExtra 0.8.1 stalbe release for PHP 8.4 integration test.

The modifications are bare minimal to remove the deprecation warnings in PHP 8.2.x and above including PHP 8.4.

Use [this](./ParsedownExtra.php), or [patch](./patch.sh) the ParsedownExtra 0.8.1 if you want no extra features made in current [`master` branch](https://github.com/erusev/parsedown-extra/tree/master).

> [!IMPORTANT]
> **This fix will break backward compatibility**.
> For older PHP users (PHP 5.x, 6.x, 7.0), keep usiing the original ParsedownExtra 0.8.1.
> This fix version will not work for you. Since the deprecation warning fix rely on the feature implemented "nullable type declarations with the `?T` syntax" from PHP 7.1.
