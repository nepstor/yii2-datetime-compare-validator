yii2-datetime-compare-validator
===============================
Validator for yii2 allows you to compare dates.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run
```sh
php composer.phar require nepstor/yii2-datetime-compare-validator "1.1.0"
```
or add
```json
"nepstor/yii2-datetime-compare-validator": "1.1.0"
```
to the require section of your `composer.json` file.

Using
===============================
```php
public function rules()
{
    return [
        ['begin', nepstor\validators\DateTimeCompareValidator::className(), 'compareAttribute' => 'end', 'format' => 'Y-m-d', 'operator' => '>=']
    ];
}
```
