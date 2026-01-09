# Springer Nature Employee Manager

A production-ready employee and contractor management system built with Laravel 11, Filament v3, and PostgreSQL/MariaDB support.

## Features

- Okta OIDC login (Authorization Code + PKCE) with JIT provisioning
- Optional local login for non-SSO deployments
- App-owned roles and permissions using `spatie/laravel-permission`
- Directory sync with Active Directory (LDAP) or Local Directory mode
- Filament admin UI with branded Springer Nature design tokens
- Management dashboards, KPIs, and exception monitoring
- Audit logging and change history
- Queue-backed directory sync jobs and scheduler
- CSV import and API ingestion for local mode

## Setup

1. Install dependencies:

```bash
composer install
```

2. Copy `.env.example` to `.env` and update environment variables.

3. Generate an application key:

```bash
php artisan key:generate
```

4. Run migrations and seed demo data:

```bash
php artisan migrate --seed
```

5. Start the local server:

```bash
php artisan serve
```

## Environment Variables

- `DB_CONNECTION`: `pgsql` (preferred) or `mysql` (MariaDB supported)
- `DIRECTORY_PROVIDER`: `ad` or `local`
- `DIRECTORY_SYNC_INTERVAL`: sync schedule in minutes
- `LOCAL_AUTH_ENABLED`: `true` to enable local login
- `OKTA_ISSUER`, `OKTA_CLIENT_ID`, `OKTA_CLIENT_SECRET`, `OKTA_REDIRECT_URI`
- `AD_HOSTS`, `AD_BASE_DN`, `AD_BIND_DN`, `AD_BIND_PASSWORD`, `AD_USE_SSL`, `AD_USE_TLS`
- `APP_SUBDIRECTORY`: set to `/empmgr` if hosted in a subfolder

## Okta OIDC Configuration

1. Create an Okta OIDC application using Authorization Code + PKCE.
2. Set the redirect URI to `https://your-domain/auth/okta/callback`.
3. Populate the Okta environment variables in `.env`.

## Active Directory Sync

- Set `DIRECTORY_PROVIDER=ad` and provide LDAP credentials.
- Run sync manually:

```bash
php artisan directory:sync
```

- Scheduler runs automatically every `DIRECTORY_SYNC_INTERVAL` minutes.

## Local Directory Mode

- Set `DIRECTORY_PROVIDER=local`.
- Use Filament People screens for CRUD.
- Import via API:

```bash
POST /api/people/import
```

Requires an authenticated admin session.

## Switching PostgreSQL / MariaDB

Update `DB_CONNECTION` and related database credentials in `.env`.

## Running in a Subdirectory (/empmgr)

Set `APP_URL` and `APP_SUBDIRECTORY=/empmgr`. Ensure your web server maps the subdirectory to `public/`.

## Tests

```bash
./vendor/bin/pest
```

## License

Proprietary.
