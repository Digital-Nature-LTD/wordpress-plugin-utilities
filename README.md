# Digital Nature - Utilities
Provides utilities for use with WordPress, plus the Digital Nature menu item and associated roles

This plugin includes the [Digital Nature WordPress Utilities package](https://packagist.org/packages/digital-nature/wordpress-utilities) - see the docs there for more info on the available tools.

There are of course tools that are plugin specific, more info below.

# Data Tables
Data tables draw tables of data (who'd have thought it!).

These tables can be paginated and searchable, and the data in them is automatically cached for 10 minutes (there is a button included to flush this).

One type of data table is included - Model Notes.

## Model Notes Data Table
The utilities package provides the ability to create notes for any model. This plugin provides the means to output that information. 

To output notes for a model you can use the supplied `TemplateHelper` and notes template.

```php
/** @var Model $model */

TemplateHelper::render(
    PluginConfig::get_plugin_name() . '/admin/model/notes.php',
    [
        'model' => $model,
    ],
    trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
);
```

Alternatively there is an admin page that can be used at `/wp-admin/admin.php?page=digital-nature/notes&model=123456`

## User Notes Data Table
The utilities package provides the ability to create notes for any user. This plugin provides the means to output that information.

To output notes for a user you can use the supplied `TemplateHelper` and notes template.

```php
/** @var WP_User $user */

TemplateHelper::render(
    PluginConfig::get_plugin_name() . '/admin/user/notes.php',
    [
        'user' => $user,
    ],
    trailingslashit(PluginConfig::get_plugin_dir() . '/templates')
);
```

Alternatively there is an admin page that can be used at `/wp-admin/admin.php?page=digital-nature/user/notes&user=123456`