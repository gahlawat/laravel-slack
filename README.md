# laravel-slack

[![Author](https://img.shields.io/badge/author-@jivesh-blue.svg?style=flat-square)](https://twitter.com/jiveshsg)
[![Total Downloads](https://poser.pugx.org/jivesh/laravel-slack/downloads?format=flat-square)](https://packagist.org/packages/jivesh/laravel-slack)
[![Latest Stable Version](https://poser.pugx.org/jivesh/laravel-slack/v/stable?format=flat-square)](https://packagist.org/packages/jivesh/laravel-slack)
[![License](https://poser.pugx.org/jivesh/laravel-slack/license?format=flat-square)](https://packagist.org/packages/jivesh/laravel-slack)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9968ff31-0d2a-4aa2-9a36-5d8a63742311/big.png)](https://insight.sensiolabs.com/projects/9968ff31-0d2a-4aa2-9a36-5d8a63742311)

A very tiny and lightweight integration with the Slack API for posting notifications or any kind of messages to your team's Slack account.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Registering the Package](#registering-the-package)
- [Configuration](#configuration)
- [Usage](#usage)

## Requirements

* Laravel Framework 5.1+

## Installation

Using [Composer](https://getcomposer.org/) package manager, install this package by running following command in your project root:

```sh
$ composer require jivesh/laravel-slack
```

## Registering the Package

- In your ```config/app.php``` file, append the following code into your ```providers``` array for integrating the Service Provider for package.

```php
/**
 * Package Service Provider
 */

'providers' => [
    // ...

    Gahlawat\Slack\SlackServiceProvider::class,
],
```

- Again in your ```config/app.php``` file, copy the following code into your ```aliases``` array for a nice Laravel syntax using Facades.

```php
/**
 * Package Alias
 */

'aliases' => [
    // ...

    'Slack' => Gahlawat\Slack\Facade\Slack::class,
],
```

## Configuration

- [Create an incoming webhook](https://www.slack.com/services/new/incoming-webhook) on your Slack account for the package to use and copy the generated Webhook URL.

- Run the following command in project root directory to generate config file for package.

```sh
$ php artisan vendor:publish
```

- Now edit ```config/slack.php``` and paste value for ```incoming-webhook``` generated in the first step above.
- You may optionally set a default username and emoji icon displayed in your Slack app from here.

## Usage

- Send any message in real time to your Slack account using this anywhere in your php code:

```php
\Slack::send("your-message");
```

- The backslash indicates global namespace scope for this function, you may import Slack namespace on top of your file by ```using``` it:

```php
use Slack;
```

- Then, you can call this Facade without a ```\``` as:

```php
Slack::send("your-message");
```

- To change the default name and/or display icon in your Slack app for any message, use:

```php
Slack::send("your-message" [,"display-name" [,"display-emoji"]]);

// here [] indicates optional parameters
```

See this [cheat sheet](http://www.emoji-cheat-sheet.com) of available emoji icons.
