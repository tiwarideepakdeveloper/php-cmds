# Step-by-Step Guide to Install php-cmds

This is a simple PHP command utility for generating files based on the MVC architecture, akin to Laravel's Artisan command. It allows you to effortlessly create models, controllers, and views tailored to your requirements.

## 1. PHP Installation
Ensure that PHP (version 7.x or higher) is installed on your system.

## 2. Composer Installation
Composer is required as the PHP package manager. If it's not already installed, [follow these instructions](https://getcomposer.org/download/).

## 3. Installing the Package
Run the following command in your project directory:

```bash
composer require deepaktiwari/php-cmds
```

## 4. Post-Installation Command
After installation, execute the following command in your directory:

```bash
php vendor/deepaktiwari/php-cmds/src/framework Your-Command-Name
```

## 5. Executing PHP Commands
You're now ready to use your PHP commands. Here's an example:

```bash
php Your-Command-Name -d=app -c=ControllerName -m=ModelName -v=ControllerName/ActionName
```

# Note: For the view file, you can specify the folder and file name according to your needs. If you use capital letters in the view's name, they will be converted to lowercase with dashes.
