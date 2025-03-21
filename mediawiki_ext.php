<?php
/**
 * External Images Extension for MediaWiki
 *
 * This extension allows for displaying external images with custom sizing 
 * and linking options
 *
 * @file
 * @ingroup Extensions
 * @author Claude
 * @license GPL-2.0-or-later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'This file is a MediaWiki extension and not meant to be executed standalone' );
}

// Extension credits
$wgExtensionCredits['parserhook'][] = [
    'path' => __FILE__,
    'name' => 'ExternalImages',
    'version' => '1.0.0',
    'author' => '[Your Name]',
    'url' => 'https://www.mediawiki.org/wiki/Extension:ExternalImages',
    'descriptionmsg' => 'externalimages-desc',
    'license-name' => 'GPL-2.0-or-later',
];

// Register hooks
$wgHooks['ParserFirstCallInit'][] = 'ExternalImagesSetup';

// Register i18n
$wgMessagesDirs['ExternalImages'] = __DIR__ . '/i18n';

/**
 * Setup function for the External Images extension
 *
 * @param Parser $parser Parser object
 * @return bool
 */
function ExternalImagesSetup( Parser $parser ) {
    // Register the tag
    $parser->setHook( 'extimg', 'renderExternalImage' );
    return true;
}

/**
 * Render an external image with options for size and linking
 *
 * @param string $input The content of the tag
 * @param array $args Tag arguments
 * @param Parser $parser Parser object
 * @param PPFrame $frame Frame object
 * @return string HTML
 */
function renderExternalImage( $input, array $args, Parser $parser, PPFrame $frame ) {
    // Get the image URL (required)
    $imageUrl = $input ?: '';
    if ( empty( $imageUrl ) ) {
        return '<div class="error">Error: Image URL is required</div>';
    }

    // Sanitize the URL
    $imageUrl = filter_var( $imageUrl, FILTER_SANITIZE_URL );
    if ( !filter_var( $imageUrl, FILTER_VALIDATE_URL ) ) {
        return '<div class="error">Error: Invalid image URL</div>';
    }

    // Get width parameter (optional)
    $width = isset( $args['width'] ) ? $args['width'] : '';
    
    // Get height parameter (optional)
    $height = isset( $args['height'] ) ? $args['height'] : '';
    
    // Get link URL (optional)
    $linkUrl = isset( $args['link'] ) ? $args['link'] : '';
    
    // Check if link should open in new tab (optional, default: false)
    $newTab = isset( $args['newtab'] ) && strtolower( $args['newtab'] ) === 'true';
    
    // Build style attribute for image
    $style = '';
    if ( !empty( $width ) ) {
        // Validate width format (px or %)
        if ( preg_match( '/^(\d+)(px|%)$/', $width ) || is_numeric( $width ) ) {
            // If only a number is provided, assume pixels
            $width = is_numeric( $width ) ? $width . 'px' : $width;
            $style .= "width: $width; ";
        }
    }
    
    if ( !empty( $height ) ) {
        // Validate height format (px or %)
        if ( preg_match( '/^(\d+)(px|%)$/', $height ) || is_numeric( $height ) ) {
            // If only a number is provided, assume pixels
            $height = is_numeric( $height ) ? $height . 'px' : $height;
            $style .= "height: $height; ";
        }
    }
    
    // Create image tag
    $imgTag = '<img src="' . htmlspecialchars( $imageUrl ) . '" alt="External image"';
    if ( !empty( $style ) ) {
        $imgTag .= ' style="' . htmlspecialchars( $style ) . '"';
    }
    $imgTag .= '>';
    
    // Wrap in link if URL provided
    if ( !empty( $linkUrl ) ) {
        // Sanitize the link URL
        $linkUrl = filter_var( $linkUrl, FILTER_SANITIZE_URL );
        if ( filter_var( $linkUrl, FILTER_VALIDATE_URL ) ) {
            $target = $newTab ? ' target="_blank" rel="noopener noreferrer"' : '';
            $imgTag = '<a href="' . htmlspecialchars( $linkUrl ) . '"' . $target . '>' . $imgTag . '</a>';
        }
    }
    
    // Parse and return HTML
    return $parser->recursiveTagParse( $imgTag, $frame );
}
