# Finolog-php

> Official PHP bindings to the Finolog API

## Installation

```bash
$ composer require finolog/finolog-php
```

## Documentation

[Documentation by Finolog](https://api.finolog.ru/docs "Finolog API")


## Usage

```php
use Finolog\Client as Finolog;

$finolog = new Finolog('your api token');

// or

use Finolog\Contractor;

$contractor = new Contractor('your api token');

// or

use Finolog\Client as Finolog;

$finolog = new Finolog('your api token', biz_id);
```

### User
```php
// receives information about an authorized user
$finolog->user->get();

// updates the information to an authorized user
$finolog->user->update(['first_name' => 'first name', 'last_name' => 'last name']);
```

### Currency
```php
// get currency
$finolog->currency->all();
```

### Biz
```php
// get information about business
$finolog->biz->get(['biz_id' => 14323]);

// get information about all business
$finolog->biz->all();

// add new business
$finolog->biz->add(['name' => 'business name', 'base_currency_id' => 1]);

// update business information
$finolog->biz->update(['biz_id' => 14323, 'name' => 'new business name'])

// delete business
$finolog->biz->delete(['biz_id' => 14323]);
```

### Company 
```php
// get information about company
$finolog->company->get(['biz_id' => 2524, 'id' => 423]);

// get information about all company from business
$finolog->company->all(['biz_id' => 3323]);

// add new company
$finolog->company->add(['biz_id', 'name' => 'company name']);

// update company information
$finolog->company->update(['biz_id' => 3545, 'id' => 344, 'name' => 'new company name']);

// delete company
$finolog->company->delete(['biz_id' => 32434, id: 4234]);
```

### Account
```php
// get information about account
$finolog->account->get(['biz_id' => 3424, 'id' => 4354]);

// get information about all account
$finolog->account->all(['biz_id' => 34534]);

// add new account
$finolog->account->add([
    'biz_id' => 4234, 
    'company_id' => 455, 
    'currency_id' => 434, 
    'name' => 'account name', 
    'initial_balance' => 1000
]);

// update account information
$finolog->account->update(['biz_id' => 5345, 'id' => 4453, 'name' => 'new name']);

// delete account
$finolog->account->delete(['biz_id' => 5345, 'id' => 22]);
```

### Transaction
```php
// get information about transaction
$finolog->transaction->get(['biz_id' => 4324, 'id' => 1234]);

// get information about all transactions
$finolog->transaction->all(['biz_id' => 234]);

// add new transaction
$finolog->transaction->add(['biz_id' => 333, 'from_id', 'date' => '2018-01-01', 'value' => 1000]);

// update transaction information
$finolog->transaction->update(['biz_id' => 342, 'id' => 424, 'value' => 2000]);

// delete transaction
$finolog->transaction->delete(['biz_id' => 435, 'id' => 4234]);

// split transaction
$finolog->transaction->split([
    'biz_id' => 423,
    'id' => 42354,
    'items' => [
        ['value' => 100],
        ['value' => 200]
    ]
]);

//cancel split transaction
$finolog->transaction->cancel(['biz_id' => 423, 'id' => 4345]);
```

### Category
```php
// get information about category
$finolog->category->get(['biz_id' => 4435, 'id' => 5435]);

// get information about all categories
$finolog->category->all(['biz_id' => 435]);

// add new category
$finolog->category->add(['biz_id' => 435, 'name' => 'category name', 'type' => 'in']);

// update category information
$finolog->category->update(['biz_id' => 5345, 'id' => 435, 'name' => 'new category name']);

// delete category
$finolog->category->delete(['biz_id' => 2343, 'id' => 44]);
```

### Project
```php
// get information about project
$finolog->project->get(['biz_id' => 2343, 'id' => 44]);

// get information about all projects
$finolog->project->all(['biz_id' => 435]);

// add new project
$finolog->project->add(['biz_id' => 435, 'currency_id' => 3 'name' => 'project name']);

// update project information
$finolog->project->update(['biz_id' => 345, 'id' => 534, 'name' => 'new project name']);

// delete project
$finolog->project->delete(['biz_id' => 2343, 'id' => 44]);
```

### Contractor
```php
// get information about contractor
$finolog->contractor->get(['biz_id' => 345, 'id' => 5435]);

// get information about all contractors
$finolog->contractor->all(['biz_id' => 5345]);

// add new contractor
$finolog->contractor->add(['biz_id' => 1, 'name' => 'contractor name']);

// update information contractor
$finolog->contractor->update(['biz_id' => 4534, 'id' => 453, 'name' => 'new contractor name']);

// delete contractor
$finolog->contractor->delete(['biz_id' => 345, 'id' => 5435]);
```

### Requisite
```php
// get information about requisite
$finolog->requisite->get(['biz_id' => 345, 'id' => 5435]);

// get information about all requisites
$finolog->requisite->all(['biz_id' => 5345]);

// add new requisite
$finolog->requisite->add(['biz_id' => 1, 'contractor_id' => 3443 'name' => 'requisite name']);

// update requisite information
$finolog->requisite->update(['biz_id' => 1, 'id' => 3443 'name' => 'new requisite name']);

// delete requisite
$finolog->requisite->delete(['biz_id' => 345, 'id' => 5435]);
```

## Examples

### Example 1
```php

use Finolog\Client as Finolog;

$finolog = new Finolog('your api token');

$biz = $finolog->biz->all();
$finolog->contractor->add(['biz_id' => $biz[0]->id, name => 'test contractor']);
```

### Example 2
```php

use Finolog\Client as Finolog;

$finolog = new Finolog('your api token', 5434); // 5434 - biz_id

$finolog->transaction->all(); // without biz_id, becouse biz_id use in a costructor Finolog
$finolog->transaction->all(['biz_id' => 331]); // return transaction which are in business 331, not 5434 !
```
