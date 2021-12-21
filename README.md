# webhook-teams - MS Teams Webhook Package

A small library to create messages for Microsoft Teams.

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
composer require lupuscoding/webhook-teams
```

## Usage <a id="usage" href="#usage">#</a>

### Create a message card
```php
// Insert uses
use LupusCoding\Webhooks\Teams\MessageCard;
use LupusCoding\Webhooks\Teams\ThemeColor;
// Create the card
$card = new MessageCard();
$card->setThemeColor(ThemeColor::SUCCESS)
    ->setSummary('My summary');
```

### Create a message card section
```php
use LupusCoding\Webhooks\Teams\MessageSection;
use LupusCoding\Webhooks\Teams\MessageCard;
// Create the section
$section = new MessageSection();
$section->setActivityTitle('My activity')
    ->setActivitySubtitle('This is a subtitle')
    ->setActivityImage('https://some/image.png')
    ->addFact('My fact', 'This is awesome')
    ->setMarkdown(false);
// Add section to card
$card = new MessageCard();
$card->addSection($section);
```

### Create an action card
```php
// Insert uses
use LupusCoding\Webhooks\Teams\ActionCard;
use LupusCoding\Webhooks\Teams\ThemeColor;
// Create the card
$card = new ActionCard();
$card->setName('my-action-name')
    ->setThemeColor(ThemeColor::DEBUG);
```

### Create an action card input
```php
use LupusCoding\Webhooks\Teams\ActionCard;
use LupusCoding\Webhooks\Teams\Input\TextInput;
// Create the input
$input = new TextInput();
$input->setId('input1')
    ->setTitle('Type something in')
    ->setMultiline(true)
    ;
// Add input to card
$card = new ActionCard();
$card->addInput($input);
```

### Create an action card action
```php
use LupusCoding\Webhooks\Teams\ActionCard;
use LupusCoding\Webhooks\Teams\CardAction\HttpPost;
// Create the action
$action = new HttpPost();
$action->setName('Click me')
    ->setTarget('http://lupuscoding.de');
// Add action to card
$card = new ActionCard();
$card->addAction($action);
```

### Send a card
```php
use LupusCoding\Webhooks\Teams\MessageCard;
$card = new MessageCard();
    
// Setup the hook url
$hookUrl = 'https://webhook.site/253013d5-4960-4857-85c4-596998c26e10';
// Init curl request
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($ch, CURLOPT_URL, $hookUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($card));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/x-www-form-urlencoded']);
// Send request
$result = curl_exec($ch);
curl_close($ch);
// Test result
if (curl_errno($ch)) {
    // Failure
} else {
    // Success
}
```

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

First install **phpunit** by executing
```shell
composer install
```
Then start phpunit by executing
```shell
vendor/bin/phpunit
```
### Further Testing (optional)

Every test request is sent to [Pipedream](https://pipedream.com). This site processes the requests and build valid 
responses. Also every request is forwarded to this 
[Request Bin](https://requestbin.com/r/endbm4lp2m3c/22cBM6FMBVLXLFMBCoN8ZbpxOnk), so that you can view the request data.

To inspect the requests, you can login with your GitHub account and copy my published 
[Webhook Workflow](https://pipedream.com/@lupuscoding/lupuscoding-webhook-ms-teams-test-p_NMC1PWj). Please make sure to
change the **publicBinUrl** variable inside the workflow nodejs step, to your own [Request Bin](https://requestbin.com).
<br/>
After creating your Pipedream Webhook Workflow, just modify the ```WEBHOOK_URL``` constant inside the 
```MessageCardTest``` and ```ActionCardTest``` class.*