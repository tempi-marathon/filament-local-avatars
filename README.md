# Filament Local Avatars

Local initials avatars for [Filament](https://filamentphp.com) panels, generated as inline SVG data URIs. No third-party services, no HTTP routes, GDPR-friendly.

## Requirements

- PHP 8.5+
- Filament 5.x

## Installation

```bash
composer require tempi-marathon/filament-local-avatars
```

Register the plugin on your panel:

```php
use TempiMarathon\FilamentLocalAvatars\FilamentLocalAvatarsPlugin;

return $panel
    // ...
    ->plugin(FilamentLocalAvatarsPlugin::make());
```

The plugin sets the panel's default avatar provider automatically.

## Configuration

Publish the config file (optional):

```bash
php artisan vendor:publish --tag=filament-local-avatars-config
```

Available options in `config/filament-local-avatars.php`:

| Key | Default | Description |
|-----|---------|-------------|
| `size` | `120` | SVG width and height in pixels |
| `font_size` | `48` | Initials font size |
| `text_color` | `#FFFFFF` | Initials color |
| `background_color` | `null` | Fixed background color; `null` uses the panel primary color |

## Local development

When developing the package alongside a consumer app, add a Composer path repository:

```json
"repositories": [
    {
        "type": "path",
        "url": "../filament-local-avatars",
        "options": { "symlink": true }
    }
]
```

```bash
composer require tempi-marathon/filament-local-avatars:@dev
```

## Testing

```bash
composer test
```

Runs Pint, PHPStan (max level), and Pest with a minimum 90% code coverage requirement.

## License

MIT. See [LICENSE](LICENSE).
