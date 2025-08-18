# Custom Themes Directory

Place your custom WordPress themes in this directory. Each theme should be in its own subdirectory.

## Example Theme Structure

```
themes/
├── my-custom-theme/
│   ├── style.css          # Main stylesheet with theme header
│   ├── index.php          # Main template file
│   ├── functions.php      # Theme functions and features
│   ├── header.php         # Header template
│   ├── footer.php         # Footer template
│   ├── sidebar.php        # Sidebar template
│   ├── single.php         # Single post template
│   ├── page.php           # Page template
│   ├── archive.php        # Archive template
│   ├── search.php         # Search results template
│   ├── 404.php            # 404 error template
│   ├── screenshot.png     # Theme preview image (880x660px)
│   └── assets/            # CSS, JS, images, etc.
│       ├── css/
│       ├── js/
│       └── images/
```

## Required Files

### style.css
Must contain the theme header comment:
```css
/*
Theme Name: My Custom Theme
Description: A custom WordPress theme
Version: 1.0
Author: Your Name
*/
```

### index.php
The main template file that WordPress will use as a fallback.

### functions.php
Where you add theme features, enqueue scripts/styles, and register menus/widgets.

## Development Tips

1. **Use WordPress Coding Standards**
2. **Enable WP_DEBUG** (already configured in this environment)
3. **Use WordPress Template Hierarchy**
4. **Test with different content types**
5. **Make themes responsive**

## Resources

- [WordPress Theme Development Handbook](https://developer.wordpress.org/themes/)
- [WordPress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
