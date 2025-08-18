.PHONY: help start stop restart logs clean reset theme-install

# Default target
help:
	@echo "WordPress Development Environment Commands:"
	@echo ""
	@echo "  start         - Start WordPress environment"
	@echo "  stop          - Stop WordPress environment"
	@echo "  restart       - Restart WordPress environment"
	@echo "  logs          - View container logs"
	@echo "  clean         - Stop and remove containers"
	@echo "  reset         - Complete reset (removes volumes)"
	@echo "  theme-install - Create a new theme directory"
	@echo "  status        - Show container status"
	@echo "  shell         - Access WordPress container shell"
	@echo "  db-shell      - Access MySQL shell"

# Start the environment
start:
	docker compose up -d
	@echo "WordPress environment started!"
	@echo "WordPress: http://localhost:8000"
	@echo "phpMyAdmin: http://localhost:8081"

# Stop the environment
stop:
	docker compose down
	@echo "WordPress environment stopped."

# Restart the environment
restart:
	docker compose restart
	@echo "WordPress environment restarted."

# View logs
logs:
	docker compose logs -f

# Clean up containers
clean:
	docker compose down
	@echo "Containers stopped and removed."

# Complete reset (removes volumes)
reset:
	docker compose down -v
	docker system prune -f
	@echo "Complete reset completed. Run 'make start' to start fresh."

# Show container status
status:
	docker compose ps

# Access WordPress container shell
shell:
	docker exec -it wp_wordpress /bin/bash

# Access MySQL shell
db-shell:
	docker exec -it wp_db mysql -u wordpress -p wordpress

# Create a new theme directory
theme-install:
	@read -p "Enter theme name: " theme_name; \
	mkdir -p themes/$$theme_name; \
	touch themes/$$theme_name/style.css; \
	touch themes/$$theme_name/index.php; \
	touch themes/$$theme_name/functions.php; \
	echo "/*" > themes/$$theme_name/style.css; \
	echo "Theme Name: $$theme_name" >> themes/$$theme_name/style.css; \
	echo "Description: A custom WordPress theme" >> themes/$$theme_name/style.css; \
	echo "Version: 1.0" >> themes/$$theme_name/style.css; \
	echo "Author: Your Name" >> themes/$$theme_name/style.css; \
	echo "*/" >> themes/$$theme_name/style.css; \
	echo "Theme directory '$$theme_name' created successfully!"
