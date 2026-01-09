# Installing Dependencies Manually

This project uses PHP dependencies managed by Composer. In environments where network access to Packagist is restricted, you can obtain dependencies manually and install them locally.

## Prerequisites

- PHP 8.4+
- Composer 2.x

### Download Composer

If Composer is not already available:

- https://getcomposer.org/download/

Follow the official instructions for your platform, then verify:

```bash
composer --version
```

## Obtain Dependencies Manually

### Option A: Download a zip from Packagist (individual packages)

1. Visit Packagist and locate the required package/version:
   - https://packagist.org/
2. Download the source/archive for the package version you need.
3. Extract the archive to a temporary folder.
4. Repeat for all required packages in `composer.json` and their dependencies.

### Option B: Use Composer on a machine with access, then transfer vendor/

1. On a machine with access to Packagist, run:

```bash
composer install
```

2. Copy the generated `vendor/` directory and `composer.lock` back to this project.

### Option C: Use a Packagist mirror or internal artifact repository

If your organization provides a mirror or an internal Composer repository, configure it in `composer.json` or via environment variables. See Composer repository docs:

- https://getcomposer.org/doc/05-repositories.md

## Install from Local Files

Once you have the packages locally:

```bash
composer install --no-interaction --prefer-dist
```

If you copied `vendor/` and `composer.lock` from another machine, you can skip installation and proceed directly to running the app.

## Useful References

- Composer documentation: https://getcomposer.org/doc/
- Packagist package index: https://packagist.org/
