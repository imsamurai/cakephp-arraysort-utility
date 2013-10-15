# ArraySort Utility for CakePHP 2.1+ [![Build Status](https://travis-ci.org/imsamurai/cakephp-arraysort-utility.png?branch=master)](https://travis-ci.org/imsamurai/cakephp-arraysort-utility)


## Installation
```
cd my_cake_app/app
git clone git://github.com/imsamurai/cakephp-arraysort-utility.git Plugin/ArraySort
```
or if you use git add as submodule:
```
cd my_cake_app
git submodule add "git://github.com/imsamurai/cakephp-arraysort-utility.git" "app/Plugin/ArraySort"
```
then add plugin loading in Config/bootstrap.php
```php
CakePlugin::load('ArraySort');
```
## Usage

In any place of your code:
```php
App::uses('ArraySort', 'ArraySort.Utility');

$sorted_array = ArraySort::multisort($array, $params);
```
where `$array` is array to sort,
`$params` can be string ('asc' or 'desc') or array like this:
```php
$params = array(
        <field1> => <direction>,
        <field2> => <direction2>,
        ...
);
```
For example:
```php
$params = array(
        'rank' => 'desc',
        'created' => 'asc'
);
```
With this $params method will sort $array by comparing each elements firstly by rank field, if they have
equal rank then sort by created field.
