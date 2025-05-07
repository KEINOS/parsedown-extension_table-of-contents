# Parsedown 1.7.4 Patched for PHP 8.4.x

## Bare Minimum Patched Version

This directory contains a patched version of Parsedown 1.7.4 stalbe release for PHP 8.4 integration test.

The modifications are bare minimal to remove the deprecation warnings in PHP 8.4.x. It is equivalent to the [PR #915](https://github.com/erusev/parsedown/pull/915) and no refactoring or extra features were added.

Use [this](./Parsedown.php), or [patch](./patch.sh) the Parsedown 1.7.4 if you want no extra features made in current [`master` branch](https://github.com/erusev/parsedown/tree/master).

> [!IMPORTANT]
> **For older PHP users (PHP 5.x, 6.x, 7.0):**
> This fix version will not work for you. Since the deprecation warning fix rely on the feature implemented "nullable type declarations with the `?T` syntax" from PHP 7.1.
>
> You should **keep usiing the original Parsedown 1.7.4**.
>
> ---
>
> [!NOTE]
> As soon as the PR #915 is merged and released, hopefully, we will remove this patched version.
