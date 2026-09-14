# Ayan Modern WordPress Theme

A modern, clean, and professional WordPress theme designed for personal websites and blogs. Built with best practices, accessibility in mind, and optimized for performance.

## Features

### 🎨 Design & Layout
- **Modern Design**: Clean, professional appearance with excellent typography
- **Responsive Layout**: Fully responsive design that works on all devices
- **Dark Mode Support**: Automatic dark mode detection and styling
- **CSS Grid & Flexbox**: Modern layout techniques for optimal performance
- **Custom CSS Variables**: Easy theming and customization

### 📱 User Experience
- **Mobile-First Design**: Optimized for mobile devices
- **Smooth Animations**: Subtle hover effects and transitions
- **Reading Progress Bar**: Visual indicator of reading progress
- **Back to Top Button**: Easy navigation for long content
- **Mobile Menu**: Hamburger menu for mobile devices

### 🚀 Performance & SEO
- **Optimized Code**: Clean, semantic HTML and efficient CSS
- **Schema Markup**: Structured data for better SEO
- **Lazy Loading**: Images load as needed for better performance
- **Minimal Dependencies**: Lightweight theme with few external dependencies
- **Fast Loading**: Optimized for speed and Core Web Vitals

### 🛠️ WordPress Features
- **Custom Templates & Block Patterns**: Dedicated 404, archive, and home templates; hero and callout block patterns
- **Custom Meta Boxes**: Featured post and reading time options
- **Widget Areas**: Sidebar with multiple widget sections
- **Customizer Integration**: Social media links and theme options
- **Translation Ready**: Internationalization support

### 📝 Content Features
- **Featured Posts**: Highlight important content on homepage
- **Reading Time**: Automatic calculation of reading time
- **Author Bio**: Enhanced author information display
- **Related Posts**: Automatic related content suggestions
- **Social Sharing**: Easy sharing buttons for posts
- **Tag Cloud**: Visual tag display in sidebar

## Installation

1. **Upload the theme** to your WordPress themes directory (`/wp-content/themes/`)
2. **Activate the theme** in WordPress Admin → Appearance → Themes
3. **Configure settings** in WordPress Admin → Appearance → Customize

## Setup Instructions

### 1. Basic Configuration
- Go to **Appearance → Customize**
- Set your **Site Title** and **Tagline**
- Upload a **Custom Logo** (recommended size: 200x60px)
- Configure **Social Media Links** (Twitter, GitHub, LinkedIn)

### 2. Create Menus
- Go to **Appearance → Menus**
- Create a **Primary Menu** with links like:
  - Home
  - Blog
  - About
  - Contact
- Create a **Footer Menu** for additional links

### 3. Add Widgets
- Go to **Appearance → Widgets**
- Add widgets to the **Sidebar** area:
  - Search
  - Recent Posts
  - Categories
  - Tag Cloud
  - Social Links

### 4. Create Content
- **Posts**: Write blog posts with featured images
- **Pages**: Create About, Contact, and other static pages

## Customization

### Colors
The theme uses CSS custom properties for easy color customization. Main colors:
- Primary: `#2563eb` (Blue)
- Secondary: `#64748b` (Gray)
- Accent: `#f59e0b` (Orange)

### Typography
- **Primary Font**: Inter (Google Fonts)
- **Monospace Font**: System monospace fonts
- **Font Sizes**: Responsive typography scale

### Layout Options
- **Sidebar**: Right sidebar with widgets
- **Content Width**: Maximum 1200px with responsive breakpoints
- **Grid System**: CSS Grid for flexible layouts

## File Structure

```
ayan-modern/
├── style.css              # Main stylesheet with theme header
├── functions.php          # Theme functions and features
├── index.php             # Main template file
├── home.php              # Blog/posts homepage template
├── header.php            # Header template
├── footer.php            # Footer template
├── sidebar.php           # Sidebar template
├── single.php            # Single post template
├── page.php              # Page template
├── archive.php           # Archive template
├── 404.php               # Not found template
├── search.php            # Search results template
├── screenshot.png        # Theme preview image
├── assets/
│   ├── css/
│   │   └── editor-style.css  # Block editor styles
│   └── js/
│       └── main.js       # Main JavaScript file
└── README.md             # This file
```

## Custom Meta Boxes

### Post Options
- **Featured Post**: Mark posts as featured for homepage display
- **Reading Time**: Set custom reading time (auto-calculated if not set)

## Hooks and Filters

### Available Actions
- `ayan_modern_after_header`: After header content
- `ayan_modern_before_footer`: Before footer content
- `ayan_modern_after_post_content`: After post content

### Available Filters
- `ayan_modern_excerpt_length`: Modify excerpt length (default: 25)
- `ayan_modern_excerpt_more`: Modify excerpt more text (default: '...')

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+

## Performance Tips

1. **Optimize Images**: Use WebP format and appropriate sizes
2. **Enable Caching**: Use a caching plugin
3. **Minimize Plugins**: Only use necessary plugins
4. **CDN**: Use a content delivery network for assets

## Accessibility Features

- **Semantic HTML**: Proper heading structure and landmarks
- **Keyboard Navigation**: Full keyboard accessibility
- **Screen Reader Support**: ARIA labels and descriptions
- **Color Contrast**: WCAG AA compliant color ratios
- **Focus Indicators**: Clear focus states for interactive elements

## Security Features

- **Sanitization**: All user inputs are properly sanitized
- **Nonces**: Form security with WordPress nonces
- **Escape Functions**: Proper escaping of output
- **Version Removal**: WordPress version information removed

## Support

For support and customization requests:
- Check the WordPress Codex for general WordPress questions
- Review the theme code for customization examples
- Consider hiring a WordPress developer for complex modifications

## Changelog

### Version 1.4.8
- Dedicated 404 and archive templates
- Login screen uses Customizer custom logo

### Version 1.4.0
- Block patterns and block style variants
- Editor stylesheet for block editor parity
- Custom header and background support

### Version 1.0.0
- Initial release
- Modern responsive design
- Custom meta boxes
- Social media integration
- Performance optimizations

## License

This theme is licensed under the GPL v2 or later.

## Credits

- **Author**: Ayan Ozturk
- **Design**: Modern, clean design principles
- **Icons**: SVG icons for social media and UI elements
- **Fonts**: Inter font family from Google Fonts

---

Built with ❤️ for the WordPress community.
