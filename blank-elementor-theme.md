# Soap Theme — Zero-Style Elementor WordPress Theme

A truly bare-bones WordPress theme built for Elementor. No resets, no button styles, no typography defaults, no font declarations. Pure blank canvas.

---

## File Structure

```
soap-theme/
├── style.css
├── functions.php
├── index.php
├── front-page.php
├── page.php
├── single.php
├── header.php
├── footer.php
└── screenshot.png  (optional - 1200x900px)
```

---

## 1. `style.css`
> Theme header only. Zero actual CSS rules. Not even a body reset.

```css
/*
Theme Name:  Soap Theme
Theme URI:   https://rytdesigns.com
Author:      Sunday Akpu
Author URI:  https://rytdesigns.com
Description: A zero-style WordPress theme built as a blank canvas for Elementor.
Version:     1.0.0
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
License:     GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: soap-theme
*/
```

**That's it. No CSS below the header comment. Ever.**

---

## 2. `functions.php`
> Only what Elementor needs. Nothing extra.

```php
<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme Setup
 */
function soaptheme_setup() {

    // Allow WordPress to manage the document title tag
    add_theme_support( 'title-tag' );

    // Enable post thumbnails (featured images)
    add_theme_support( 'post-thumbnails' );

    // Tell WordPress this theme supports HTML5 markup
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // Elementor: enable full-width page template support
    add_theme_support( 'elementor' );

    // Register a primary navigation menu (optional)
    register_nav_menus( [
        'primary' => __( 'Primary Menu', 'soap-theme' ),
    ] );
}
add_action( 'after_setup_theme', 'soaptheme_setup' );


/**
 * Enqueue theme stylesheet
 * The style.css is required by WordPress to recognise the theme.
 * It carries no actual styles so it costs nothing.
 */
function soaptheme_scripts() {
    wp_enqueue_style(
        'soap-theme-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'soaptheme_scripts' );


/**
 * Remove WordPress default block styles (Gutenberg)
 * Prevents WP's built-in block CSS from leaking into Elementor pages
 */
function soaptheme_remove_block_styles() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'classic-theme-styles' ); // WP 6.1+
    wp_dequeue_style( 'global-styles' );         // WP 6.1+
}
add_action( 'wp_enqueue_scripts', 'soaptheme_remove_block_styles', 100 );


/**
 * Remove the default WordPress emoji scripts & styles
 * Lightweight choice — emoji will fall back to OS-native rendering
 */
function soaptheme_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'soaptheme_disable_emojis' );
```

---

## 3. `index.php`
> Fallback template. WordPress requires this file to exist.

```php
<?php
// Fallback — Elementor handles actual rendering.
// This file is required by WordPress but rarely used when Elementor is active.
get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
endif;

get_footer();
```

---

## 4. `front-page.php`
> Used when a static front page is set in WordPress Settings → Reading.

```php
<?php
get_header();
the_content();
get_footer();
```

---

## 5. `page.php`
> Default page template — used by Elementor for all pages.

```php
<?php
get_header();

while ( have_posts() ) : the_post();
    the_content();
endwhile;

get_footer();
```

---

## 6. `single.php`
> Single post template.

```php
<?php
get_header();

while ( have_posts() ) : the_post();
    the_content();
endwhile;

get_footer();
```

---

## 7. `header.php`
> Minimal valid HTML head. No inline styles, no body classes with theme styling.

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
```

> **Note:** There is intentionally no `<header>` HTML element here.  
> Elementor builds your header via its Theme Builder. This file only opens `<html>` and `<body>`.

---

## 8. `footer.php`
> Closes the body and calls wp_footer for WordPress and Elementor scripts.

```php
<?php wp_footer(); ?>
</body>
</html>
```

> Again — no `<footer>` HTML element. Elementor's Theme Builder handles that.

---

## Elementor Setup After Activation

Once this theme is active, do the following inside Elementor:

### Step 1 — Set Canvas Template
For any page you want Elementor to control 100%:
- Edit page → Page Settings (bottom left cog icon)
- Set **Page Layout** → `Elementor Canvas`
- This removes all theme wrappers entirely

### Step 2 — Build Header & Footer via Theme Builder
- Elementor → **Theme Builder** → Add New → **Header**
- Elementor → **Theme Builder** → Add New → **Footer**
- Set display conditions to **Entire Site**

### Step 3 — Disable Additional Default Styles in Elementor
Inside **Elementor → Settings → Style** tab:
- Set **Default Generic Fonts** → leave blank or set to your font
- Disable **Elementor's own button defaults** if you have Pro

---

## Why This Beats Hello Elementor for Your Use Case

| Feature | Hello Elementor | Soap Theme |
|---|---|---|
| Base CSS reset | ✅ Yes (causes conflicts) | ❌ None |
| Button default styles | ✅ Yes | ❌ None |
| Typography defaults | ✅ Yes | ❌ None |
| Font-size resets | ✅ Yes | ❌ None |
| Elementor compatible | ✅ Yes | ✅ Yes |
| Theme Builder support | ✅ Yes | ✅ Yes |
| Total CSS rules | ~80+ lines | **0 lines** |

---

## Keeping Up With WordPress Updates

Because this theme uses only core WordPress hooks and no deprecated functions, maintenance is minimal:

1. **On each WP release** → Update `Tested up to` in `style.css` header
2. **Run a quick staging test** → Check pages still render via Elementor
3. **Watch for deprecated hooks** → Use the [Query Monitor](https://wordpress.org/plugins/query-monitor/) plugin during dev to catch any warnings early

Realistically this theme will need **zero code changes** across most WordPress updates. There is nothing to break.

---

## Optional: Add a `screenshot.png`

Drop a `1200×900px` PNG named `screenshot.png` into the theme root. WordPress displays this in **Appearance → Themes**. You can just use a solid colour image if you don't want to design one.

---

## Quick Start Summary

```bash
# 1. Create your theme folder
wp-content/themes/soap-theme/

# 2. Create all 8 files listed above

# 3. Activate via Appearance → Themes

# 4. Go to Elementor → Theme Builder and build your Header + Footer

# 5. On each page: set Page Layout → Elementor Canvas

# Done.
```

---

*Theme built for Elementor Free & Pro. Tested on WordPress 6.4+*
