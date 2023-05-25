## Wordpress Docker
Docker template for Wordpress development.

### Getting Started

1. Copy `wp-config-sample.php` to `wp-config.php`.
2. Create the `plugins` folder under `wp-content`.
> **Note** Plugins are excluded from git so that it can be installed and updated from wp-admin.
3. There are 4 services included in `docker-compose.yaml` file:
- `wordpress`: Wordpress container. Starting this service will run both the `wordpress` and `mysql` services.
- `mysql`: MySQL container.
- `composer`: Composer container. Run this service to install or update Composer dependencies.
- `npm`: npm container. Run this service to run npm commands.

### Directory Structure

- `acf-json`: contains json files generated by Advanced Custom Field (ACF) plugin. This folder can be deleted if ACF is not used.
- `components`: contains partials for HTML elements. Instantiate the class before any HTML is sent. Use the `__construct()` method to register hooks for CSS and Javascript dependencies. Use the `render()` method to render the HTML.
> **Tips** Instantiate the class once even if the same component is rendered multiple times. This way the dependencies will only be called once since the `__construct()` method is only triggered once.

- `config`: contains global config and constants.
- `images`: contains image assets.
- `inc`: contains additional functions and utilities.
- `models`: contains data models. For documentation on how to use, please check [https://github.com/vincentts/wp-models](https://github.com/vincentts/wp-models).
- `src`: contains the JS and SASS modules. `@wordpress/scripts` package is used with some modification to compile the assets.
- `template-parts`: contains WP template parts.
- `views`: contains the HTML view.
- Use [Wordpress Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/) to act as the controller and require the view to output the HTML.