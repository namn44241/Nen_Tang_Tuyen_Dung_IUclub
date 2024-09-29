# WordPress Project Setup - Nam Nguyen

1. Clone repository
2. Run `composer install`
3. Copy `wp-config-sample.php` to `wp-config.php` and update environment variables
4. Run `docker-compose up -d`
5. Import initial database schema: `docker-compose exec wordpress wp db import db-migrations/initial-schema.sql`
6. Visit http://localhost:8000 to set up WordPress

For development:
- Make changes to code
- Commit and push only code changes, not data or config files
- For database structure changes, create new migration files using WP-CLI