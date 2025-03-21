# ExternalImages MediaWiki Extension

A MediaWiki extension that allows for displaying external images with custom sizing and linking options.

## Features

- Display external images within wiki pages
- Resize images by pixels (px) or percentage (%)
- Make images clickable with customizable link destinations
- Option to open links in a new tab

## Installation

1. Download and place the extension files in a directory called `ExternalImages` in your MediaWiki `extensions/` folder.
2. Add the following code to your `LocalSettings.php` file:
   ```php
   wfLoadExtension( 'ExternalImages' );
   ```
3. Done – Navigate to "Special:Version" on your wiki to verify the extension is successfully installed.

## Usage

### Basic syntax

```
<extimg>https://example.com/image.jpg</extimg>
```

### With optional parameters

```
<extimg width="300px" height="200px" link="https://example.com" newtab="true">https://example.com/image.jpg</extimg>
```

### Parameters

- `width`: Width of the image in pixels (px) or percentage (%)
  - Example: `width="300px"` or `width="50%"`
- `height`: Height of the image in pixels (px) or percentage (%)
  - Example: `height="200px"` or `height="30%"`
- `link`: URL to navigate to when the image is clicked
  - Example: `link="https://example.com"`
- `newtab`: Whether to open the link in a new tab (true/false, default: false)
  - Example: `newtab="true"`

## Examples

### Basic image display
```
<extimg>https://example.com/image.jpg</extimg>
```

### Resized image
```
<extimg width="300px">https://example.com/image.jpg</extimg>
```

### Percentage sizing
```
<extimg width="50%">https://example.com/image.jpg</extimg>
```

### With link
```
<extimg link="https://example.com">https://example.com/image.jpg</extimg>
```

### Complete example
```
<extimg width="300px" height="200px" link="https://example.com" newtab="true">https://example.com/image.jpg</extimg>
```

## License

This extension is licensed under [GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html).
