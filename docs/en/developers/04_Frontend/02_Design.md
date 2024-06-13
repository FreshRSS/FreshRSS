# Writing a new theme

**Note: Currently personal themes are not officially supported and may be overwritten when updating. Be sure to keep backups!**

**As of writing (02-02-2021), support for themes as extensions is under development.**

The easiest way to create a theme is by copying and modifying the base theme (or another of the pre-installed themes). The base theme can be found in [/p/themes/base-theme](https://github.com/FreshRSS/FreshRSS/tree/edge/p/themes/base-theme). Each Theme requires:

- a `metadata.json` file to describe the theme
- a `loader.gif` file to use as a loading icon
- an (optional) `icons` folder containing .svg (for icons), .ico (for favicons), and .png (for special cases) files to override existing icons
- a `thumbs` folder containing a file, `original.png` that will be used as the preview for the theme

`_frss.css` is normally added to the `metadata.json` file as a fallback for missing aspects or as basement. The file is taken from the base theme.

## RTL Support

RTL (right-to-left) support for languages such as Hebrew and Arabic is handled through CSSJanus. To generate an RTL CSS file from your standard file, use `make rtl`. Be sure to commit the resulting file (filename.rtl.css).

## Overriding icons

To replace the default icons, add an `icons` folder to your theme’s folder. Use files with the same name as the default icon to override them.

## Template file

`metadata.json`

```json
{
	"name": "Theme name",
	"author": "Theme author",
	"description": "Theme description",
	"version": 0.1,
	"files": ["_frss.css", "file1.css", "file2.css"]
}
```

An example of a CSS theme file can be found at [/p/themes/base-theme/base.css](https://github.com/FreshRSS/FreshRSS/blob/edge/p/themes/base-theme/base.css)

## Installation

see [](../../admins/11_Themes.md)
