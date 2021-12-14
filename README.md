# webhook-teams - MS Teams Webhook Package

A small library to send messages to MicroSoft Teams.

## Contents
 - [Requirements](#requirements)
 - [Install](#install)
 - [Development](#development)
 - [Usage](#usage)
 - [Testing](#testing)

## Requirements <a id="requirements" href="#requirements">#</a>

 - PHP >= 7.4
 
## Install <a id="install" href="#install">#</a>

```shell
composer require lupuscoding/ms-teams
```

## Usage <a id="usage" href="#usage">#</a>

@TODO ...

## Development <a id="development" href="#development">#</a>

* Every contribution should respect PSR-2 and PSR-12.
* Methods must provide argument types and return types.
* Class properties must be typed.
* doc blocks must only contain descriptive information.
* doc blocks may additionally contain a type declaration for arguments or 
  return values, if the type declaration is not precise.
  
For example: ```func(): array``` may not be precise if the method returns 
an array of arrays or objects. Consider a doc block entry like 
```@return array[]``` or ```@return MyObject[]``` for clarification.

## Testing <a id="testing" href="#testing">#</a>

Webhook test site: https://webhook.site/#!/253013d5-4960-4857-85c4-596998c26e10/b0e46b22-c680-4e62-b28c-74c4d9e737b7/1

First install **phpunit** by executing
```shell
composer install
```
Then start phpunit by executing
```shell
vendor/bin/phpunit
```