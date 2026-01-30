![](../img/banner.webp)

# Testing DiscoToolbar Laravel Package

A few quick steps for you to quckly try this package live.

## Prerequisites

- PHP 8.2+ with required extensions
- Composer

## Step 1: Create Fresh Laravel Project

```bash
$ composer create-project laravel/laravel disco-test
$ cd disco-test
```

## Step 2: Start the skeleton application

```bash
$ ./artisan serve
```

Open browser: http://localhost:8000

**Expected:** Laravel welcome page displays, NO toolbar visible.

## Step 3: Install DiscoToolbar Package

In another terminal (keep server running in previous one):

# Install the package
```bash
$ cd disco-test
$ composer require --dev marcin-orlowski/disco-toolbar-laravel
```

## Step 4: Create configuration file

```bash
$ cd disco
$ cat > .disco.yaml << 'EOF'
font_awesome:
  enabled: true

widgets:
  left:
    - type: close
    - icon: "fa-solid fa-home"
      url: "/"
      title: "Go to homepage"
    - text: "Hello Disco!"
  right:
    - icon: "fa-brands fa-laravel"
      text: "Laravel"
      url: "https://laravel.com/"
      target: "_blank"
EOF
```

## Step 5: Verify Debug Mode is Enabled

```bash
grep APP_DEBUG .env
# Should show: APP_DEBUG=true
```

## Step 6: Test the Toolbar

Refresh browser: http://localhost:8000

**Expected:**
- Red animated toolbar appears at top of page
- Close button (✕) on left
- Home link with icon on left
- Laravel link on right
- Clicking close removes the toolbar

## Step 7: Test Production Mode (Optional)

```bash
# Disable debug mode
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
artisan config:clear
```

Refresh browser.

**Expected:** NO toolbar visible.

```bash
# Re-enable debug mode
sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' .env
artisan config:clear
```

## Step 8: Test Missing Config (Optional)

```bash
mv .disco.yaml .disco.yaml.bak
```

Refresh browser.

**Expected:** Error toolbar with "Config file not found: .disco.yaml"

```bash
mv .disco.yaml.bak .disco.yaml
```

## Cleanup

```bash
# Stop server (Ctrl+C)
cd ..
rm -rf test-app
```
