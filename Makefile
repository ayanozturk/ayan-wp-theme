.PHONY: help start stop restart logs clean reset theme-install status shell db-shell \
	bump-major bump-minor bump-patch show-version package

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
	@echo ""
	@echo "Theme release helpers:"
	@echo "  show-version  - Print current theme version"
	@echo "  bump-major    - Increase major version (X+1.0.0), commit and zip"
	@echo "  bump-minor    - Increase minor version (X.Y+1.0), commit and zip"
	@echo "  bump-patch    - Increase patch version (X.Y.Z+1), commit and zip"
	@echo "  package       - Zip current theme version"

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

# ------------------------------
# Theme release helpers
# ------------------------------
THEME_DIR := themes/ayan-modern
STYLE_FILE := $(THEME_DIR)/style.css

show-version:
	@awk -F': ' '/^Version:/ {print "Current version:", $$2}' $(STYLE_FILE)

define bump_version
	@set -e; \
	current=$$(awk -F': ' '/^Version:/ {print $$2}' $(STYLE_FILE)); \
	IFS=.; set -- $$current; major=$$1; minor=$$2; patch=$${3:-0}; \
	new="$(1)"; \
	sed -i '' "s/^Version: .*/Version: $$new/" $(STYLE_FILE); \
	git add $(STYLE_FILE); git commit -m "chore: bump theme version to $$new"; \
	zip -r $(THEME_DIR)-$$new.zip $(THEME_DIR) -x '**/.DS_Store' '**/.git/*' '**/.idea/*' '**/.vscode/*' | cat; \
	echo "Bumped to $$new and packaged $(THEME_DIR)-$$new.zip"
endef

bump-major:
	@set -e; \
	current=$$(awk -F': ' '/^Version:/ {print $$2}' $(STYLE_FILE)); \
	IFS=.; set -- $$current; major=$$1; new_major=$$((major + 1)); \
	$(call bump_version,$$new_major.0.0)

bump-minor:
	@set -e; \
	current=$$(awk -F': ' '/^Version:/ {print $$2}' $(STYLE_FILE)); \
	IFS=.; set -- $$current; major=$$1; minor=$$2; new_minor=$$((minor + 1)); \
	$(call bump_version,$$major.$$new_minor.0)

bump-patch:
	@set -e; \
	current=$$(awk -F': ' '/^Version:/ {print $$2}' $(STYLE_FILE)); \
	IFS=.; set -- $$current; major=$$1; minor=$$2; patch=$${3:-0}; new_patch=$$((patch + 1)); \
	$(call bump_version,$$major.$$minor.$$new_patch)

package:
	@version=$$(awk -F': ' '/^Version:/ {print $$2}' $(STYLE_FILE)); \
	rm -f $(THEME_DIR)-$$version.zip; \
	zip -r $(THEME_DIR)-$$version.zip $(THEME_DIR) -x '**/.DS_Store' '**/.git/*' '**/.idea/*' '**/.vscode/*' | cat; \
	echo "Built package $(THEME_DIR)-$$version.zip"
