# CustomCSS extension

A FreshRSS extension which give ability to create user-specific CSS rules to apply in addition of the actual theme.

To use it, upload this directory in your `./extensions` directory and enable it on the extension panel in FreshRSS. You can add CSS rules by clicking on the manage button.

## Changelog

- 0.2 added file permission check, added german translation, removed un-editable file static/style.css
- 0.1 initial version

## Examples

### Enhancing mobile view

The following CSS rules let you have a more comfortable mobile view by hiding some icons (read/unread article, mark as favorite and RSS feed's favicon) and by reducing text size. It also displays the name of the subscribed feed, instead of the favicon:

```css
@media (max-width: 840px)
{
	.flux_header .item.website
	{
		width:20%;
		padding:3px;
	}

	.flux .website .favicon, .flux_header .item.manage
	{
		display:none;
	}


	.flux_header .item.website span
	{
		display:inline;
		font-size:0.7rem;
	}
}
```

The result is shown below:

Desktop screen resolution:

![Desktop](desktop_resolution.png)

Mobile screen resolution:

![Mobile](mobile_resolution.png)

#### Getting rid of Top Menu Items

The Top Menu within the mobile view might look a little bit cluttered, depending on the theme. The following CSS rules allow to hide unneccessary top menu buttons or input boxes.
```css
@media (max-width: 840px)
{
    /* Hides "Actions" Menu in Mobile View */
    #nav_menu_actions {
        display: none;
    }

    /* Hides "Views" Menu in Mobile View */
    #nav_menu_views {
        display: none;
    }

    /* Hides "Search" Input Box in Mobile View */
    .nav_menu .item.search {
        display: none;
    }

    /* Hides the Dropdown Menu Button next to the "Mark all read" Button in Mobile View */
    #mark-read-menu .dropdown {
        display: none;
    }
}
```

### Sidebar: Move the unread count to the right side of a feed

Some people prefer to have the unread count number of a feed on the right side after the feed's name, instead placing it between the favicon and the feeds name, as this is also the common location in other tools (e.g. e-mail inbox folder). Use this CSS code to move the number to the right side.
```css
.feed .item-title:not([data-unread="0"])::before {
    display: none
}
.feed .item-title:not([data-unread="0"])::after {
    content: " (" attr(data-unread) ")";
}
```
