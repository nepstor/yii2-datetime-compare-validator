yii2-datetime-compare-validator
===============================
Validator for yii2 allows you to compare dates.

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run
```sh
php composer.phar require nepstor/yii2-datetime-compare-validator "^2.0"
```
or add
```json
"nepstor/yii2-datetime-compare-validator": "^2.0"
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

Properties
===============================
This validator compares the specified input datetime with another one and make sure if their relationship is as specified by the operator property.

- `compareAttribute`: the name of the attribute whose value should be compared with.
- `compareValue`: a constant value that the input value should be compared with. When both of this property and `compareAttribute` are specified, this property will take precedence.
- `operator`: the comparison operator. Defaults to `=`. The following operators are supported:
     * `=`: check if two values are equal. The comparison is done is non-strict mode.
     * `!=`: check if two values are NOT equal. The comparison is done is non-strict mode.
     * `>`: check if value being validated is greater than the value being compared with.
     * `>=`: check if value being validated is greater than or equal to the value being compared with.
     * `<`: check if value being validated is less than the value being compared with.
     * `<=`: check if value being validated is less than or equal to the value being compared with.
- `format`: Date format to parse values with. Defaults to Y-m-d.
- `jsFormat`: Date format to parse values with client side. Defaults to YYYY-MM-DD.