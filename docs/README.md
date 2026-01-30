![](../img/banner.webp)

## Installation

Install via Composer:

```bash
composer require --dev marcin-orlowski/disco-toolbar-laravel
```

That's it! The package uses Laravel's auto-discovery - no manual registration needed.

Don't have any Laravel project runing yet? See [guide](DEMO.md) how to quickly setup running demo!

## Configuration

Create a configuration file in your project root with widget configuration. The package will automatically
detect and load the first file found (in order of preference):

- `.disco.yaml` (recommended)
- `.disco.yml`

Example configuration that produces toolbar shown in the screenshot above:

```yaml
widgets:
  left:
    - type: close
    - icon: "fa-bug"
      text: "1.47"
      url: "https://github.com/<FOO>/issues?q=is%3Aissue%20state%3Aopen%20milestone%3A1.47"
      target: "_blank"
      title: "Open Milestone 1.47 Issues"
    - icon: "fa-code-pull-request"
      url: "https://github.com/<FOO>/pulls"
      target: "_blank"
      title: "Open Repository Pull Requests"
    - text: "#1240: [ADM] Fix PageSection CRUD priority field configuration"
      url: "https://github.com/<FOO>>/issues/1240"
      target: "_blank"
      expand: true
  right:
    - icon: "fa-globe"
      url: "/"
      title: "Go to Main Page"
    - icon: "fa-crown"
      url: "/admin/"
      title: "Open Admin Panel"
    - icon: "fa-database"
      url: "http://localhost:21440"
      target: "_blank"
      title: "Open Database Manager"
    - icon: "fa-envelope"
      url: "http://localhost:21540"
      target: "_blank"
      title: "Open Mailpit"
```

### Widget Properties

| Property    |   Type   | Required | Description                                                                     |
|-------------|:--------:|:--------:|---------------------------------------------------------------------------------|
| `type`      | `string` |          | Widget type: `link` (default) or `close` (dismisses toolbar).                   |
| `icon`*     | `string` |          | Font Awesome class (e.g., `fa-solid fa-home`, `fa-brands fa-github`) or emoji.  |
| `icon_type` | `string` |          | Icon type: `fa` (Font Awesome, default) or `text` (emoji/plain text).           |
| `text`*     | `string` |          | Optional widget label to display alongside icon.                                |
| `url`       | `string` |    *     | Link URL to redirect to once widget is clicked.                                 |
| `target`    | `string` |          | Link target (e.g., `_blank`). Default: no target                                |
| `title`     | `string` |          | Tooltip text. If not given, `url` is shown.                                     |
| `expand`    |  `bool`  |          | Set to `true` to make widget expand and fill available space. Default `false`.  |

*) Either `icon` or `text` must be provided.

### Font Awesome Icons

DiscoToolbar supports Font Awesome icons for widgets. You have two options for including Font Awesome:

#### Option 1: Automatic Inclusion (Recommended for Quick Setup)

Enable automatic Font Awesome inclusion from CDN in your `.disco.yaml` configuration file:

```yaml
font_awesome:
    enabled: true           # Enable auto-include from CDN (default: false)
    version: '6.5.1'        # Font Awesome version to use (optional, default: 6.5.1)

widgets:
    left:
        - icon: "fa-solid fa-flag-checkered"
          text: "1.0"
          url: "https://github.com/user/repo"
```

**Benefits:**

- Works out of the box - no additional setup needed
- Icons display immediately
- Configuration kept in one place with your widgets

**Note:** Only enable this if your application doesn't already include Font Awesome. If you have Font Awesome in
your project, use Option 2 instead to avoid version conflicts.

#### Option 2: Manual Setup (Recommended if Font Awesome Already Installed)

If your application already includes Font Awesome (via NPM, CDN, or other means), simply use Font Awesome icon
classes in your widget configuration. DiscoToolbar will use your existing Font Awesome installation.

**Example:**

```yaml
widgets:
  left:
    - icon: "fa-solid fa-database"
      icon_type: "fa"  # Use Font Awesome (default)
      url: "http://localhost:8080"
```

If you don't have Font Awesome installed, you can include it manually in your base template:

```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
```

#### Using Text/Emoji Instead

If you prefer not to use Font Awesome, you can use emoji or plain text:

```yaml
widgets:
  left:
    - icon: "🚀"
      icon_type: "text"  # Use plain text/emoji
      url: "/admin"
```

## Usage

DiscoToolbar automatically injects itself into all HTML responses when `APP_DEBUG=true`. No template
modifications required!

The toolbar will appear at the top of every page in your application during development.

## Customization

### Background Colors

Customize the breathing stripes background colors in your `.disco.yaml`:

```yaml
bg_color_light: '#b71c1c'
bg_color_dark: '#8e0000'
```

### Disabling the Toolbar

The toolbar only appears when `APP_DEBUG=true` in your `.env` file. In production (`APP_DEBUG=false`),
the package does nothing - no middleware is registered, no CSS is injected, zero overhead.
