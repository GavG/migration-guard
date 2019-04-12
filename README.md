# migration-guard
Keeping watch of your Laravel Migrations

*Note this is quite an experimental package and may not be the best way to do this.*

The aim of this package is to add a hash column to the laravel migrations table.
This can then be checked before migrations are applied to ensure that previously ran migration files have not been changed or removed.

The hash column will be added the first time migrate is ran after installing this package. Subsequent calls to migrate will then hash existing or future migrations.
