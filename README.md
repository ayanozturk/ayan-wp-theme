# WordPress Development Environment

A Docker-based WordPress development environment optimized for custom theme development.

## Quick Start

1. **Start the environment:**
   ```bash
   docker-compose up -d
   ```

2. **Access WordPress:**
   - WordPress Site: http://localhost:8000
   - phpMyAdmin: http://localhost:8081

3. **Complete WordPress setup:**
   - Visit http://localhost:8000
   - Follow the WordPress installation wizard
   - Use these database credentials:
     - Database Name: `wordpress`
     - Username: `wordpress`
     - Password: `wordpress`
     - Database Host: `db:3306`

## Directory Structure

```
ayan-wp-theme/
├── docker-compose.yml
├── themes/           # Custom themes directory
├── plugins/          # Custom plugins directory
├── uploads/          # Media uploads
└── README.md
```

## Development Workflow

### Creating a Custom Theme

1. **Create your theme directory:**
   ```bash
   mkdir themes/my-custom-theme
   ```

2. **Create basic theme files:**
   ```bash
   touch themes/my-custom-theme/style.css
   touch themes/my-custom-theme/index.php
   touch themes/my-custom-theme/functions.php
   ```

3. **Add theme header to style.css:**
   ```css
   /*
   Theme Name: My Custom Theme
   Description: A custom WordPress theme
   Version: 1.0
   Author: Your Name
   */
   ```

### Useful Commands

- **Start services:** `docker-compose up -d`
- **Stop services:** `docker-compose down`
- **View logs:** `docker-compose logs -f`
- **Restart services:** `docker-compose restart`
- **Remove everything:** `docker-compose down -v`

### Database Access

- **phpMyAdmin:** http://localhost:8081
  - Username: `wordpress`
  - Password: `wordpress`

- **Direct MySQL access:**
  ```bash
  docker exec -it wp_db mysql -u wordpress -p wordpress
  ```

## Configuration

### WordPress Debug Settings

The environment is configured with WordPress debug settings enabled:
- `WP_DEBUG_LOG`: true (logs to `/var/www/html/wp-content/debug.log`)
- `WP_DEBUG_DISPLAY`: false (prevents errors from showing on frontend)
- `SCRIPT_DEBUG`: true (enables unminified scripts for development)

### Ports

- **WordPress:** 8000
- **phpMyAdmin:** 8081
- **MySQL:** 3306 (internal)

### Volumes

- `./themes` → `/var/www/html/wp-content/themes`
- `./plugins` → `/var/www/html/wp-content/plugins`
- `./uploads` → `/var/www/html/wp-content/uploads`

## Troubleshooting

### Common Issues

1. **Port already in use:**
   - Change ports in `docker-compose.yml`
   - Or stop conflicting services

2. **Permission issues:**
   ```bash
   sudo chown -R $USER:$USER themes plugins uploads
   ```

3. **Database connection issues:**
   - Ensure MySQL container is running: `docker-compose ps`
   - Check logs: `docker-compose logs db`

### Reset Everything

To completely reset the environment:
```bash
docker-compose down -v
docker system prune -a
docker-compose up -d
```

## Next Steps

1. Complete WordPress installation
2. Create your custom theme in the `themes/` directory
3. Activate your theme in WordPress admin
4. Start developing!

## Resources

- [WordPress Theme Development](https://developer.wordpress.org/themes/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
