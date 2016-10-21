# php-interview - a sample PHP app

## TL;DR

1. Fork the [php-interview][php-interview] repository on GitHub
2. Run `composer install`
3. Run `composer start`
4. Browse to [http://localhost:8080](http://localhost:8080)

## Introduction

This project is a simple [PHP][php] application for web developer candidates,
built using the [Slim][slim] PHP micro framework.

The project is preconfigured to install the [Slim][slim] framework, along with other development and testing tools
for quickly setting up your development environment.

The app doesn't do much, that part is up to the applicant.

## Getting Started

To get you started you can simply fork the [php-interview][php-interview] repository, clone it locally, and install the dependencies.

### Prerequisites

You need to have Git installed locally so you can clone your fork of the php-interview repository. You can get Git from
[http://git-scm.com/][git].

We use a number of PHP tools to initialize and test php-interview. You must have [PHP][php] installed,
with the PHP executable file available on your PATH. This project was developed using PHP 7.0.x.

We also use the [Composer][composer] dependency manager for managing dependencies on 3rd-party libraries.
You can follow the [instructions on the Composer website](https://getcomposer.org/doc/00-intro.md#introduction)
for installing on either [OSX/Linux](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) or
[Windows](https://getcomposer.org/doc/00-intro.md#installation-windows). We recommend following the instructions
to install Composer globally.

### Fork and Clone php-interview

Fork the [php-interview][php-interview] repository on GitHub.
If you are unfamiliar with forking, [follow these instructions](http://lmgtfy.com/?q=how+to+fork+a+repo+in+github).

Then clone your repository locally using [Git][git]:

```
git clone https://github.com/YOUR-USERNAME/php-interview.git
cd php-interview
```

*Note: Be sure to replace the URL with the correct URL to your forked repository.*

### Install Dependencies

All 3rd-party dependencies are managed with the [Composer][composer] dependency manager.
If you have installed Composer globally, as recommended, you can simply run:

```
composer install
```

You should find that you have a new folder in your project, `vendor`, which contains all the packages installed with Composer.

### Run the Application

The simplest way to run the project is to use [PHP's built-in development web server](http://php.net/manual/en/features.commandline.webserver.php).
To start the web server, run the following command from the project's root directory:

```
composer start
```

You can then browse to [http://localhost:8080](http://localhost:8080) in your web browser.

*Note: If you already have a web server running on port 8080, edit the `"scripts": { "start": ... }` section of the `composer.json` file.*

## Structure and Patterns

### Folder Structure

The application uses the Model-View-Controller, or MVC, pattern.
The directories are structured to keep the project organized following this pattern.
The following is a summary of the files you will need to work with in this project:

```
src/                         --> all the source files for the application
  app/                         --> all the code behind the application
    Config/                      --> all classes that configure the application
      AppServicesProvider.php      --> class for registering dependencies with the DI container
    Controllers/                 --> all controllers for the application
      Web/                         --> all controllers for web views
        StudentsController.php       --> controller for students view
    Models/                      --> all models for the application
      Student.php                  --> student model
    Services/                    --> all app-specific services
      NameResolver/                --> services for resolving names
        NameResolverInterface.php    --> interface defining a name resolver service
        StudentNameResolver.php      --> name resolver service for students (not implemented yet)
    Views/                       --> all web views for the application
      students.html                --> basic template for students view
  public/                      --> root directory for the web server
    main.css                     --> main stylesheet for application
tests/                       --> unit tests for the application and services
  StudentNameResolverTest.php  --> unit tests for StudentNameResolver class
```

For a more comprehensive explanation of the project files, view the [explanation of files](FILES.md) document.

### Models

Models are just plain old PHP objects representing data used in the application.
They are located in the `src/app/Models` directory.

### Views

Template files for views are located in the `src/app/Views` directory.
The application is configured to use the [Twig](http://twig.sensiolabs.org/) template engine.
[Slim][slim] also supports [PHP-View templates](http://www.slimframework.com/docs/features/templates.html#the-slimphp-view-component) if you prefer.

### Controllers

Controllers are located in the `src/app/Controllers` directory. All controllers inherit from the `\Controllers\BaseController` class.
They are divided into two categories: API and Web. API controllers are used for simple REST endpoints that return JSON data.
These can be used for providing data when implementing the front end as a single-page application.
Web controllers inherit from the `\Controllers\Web\WebController` class and are used for generating web views.

Every controller has a reference to [Slim's dependency container](http://www.slimframework.com/docs/concepts/di.html).
It can be accessed within the controller via `$this->container` to access any dependencies needed within the controller.

### Dependency Injection

Slim uses a [dependency container](http://www.slimframework.com/docs/concepts/di.html) to prepare, manage, and inject application dependencies.
To promote loose coupling and greater testability, you should make use of this DI container for all dependencies in your controllers and services.
Dependencies are registered in the `\Config\AppServicesProvider` class, located in the `src/app/Config` directory.

### Routing

Routing is handled with [Slim's router](http://www.slimframework.com/docs/objects/router.html).
Routes are registered in the `\Config\AppRoutesProvider` class, located in the `src/app/Config` directory.

## Testing

The php-interview app comes preconfigured with unit tests. These are written using the [PHPUnit][phpunit] testing framework.
PHPUnit is automatically installed with the other project dependencies through Composer.
Unit tests are located in the `tests` directory, and follow the naming convention `*Test.php`.

### Running Unit Tests

To execute the unit tests, run the command:

```
composer test
```

This command will invoke PHPUnit (from its location in the `vendor` directory), supplying it with a bootstrap script for loading dependencies,
and will run all files ending with `Test.php` in the `tests` directory.

## Contact

For more information about this project or career opportunities at [Imagine Learning](http://www.imaginelearning.com/careers), email careers@imaginelearning.com.

[composer]: https://getcomposer.org
[git]: http://git-scm.com/
[php]: http://php.net
[php-interview]: https://github.com/ImagineLearning/php-interview
[phpunit]: https://phpunit.de/
[slim]: http://www.slimframework.com/