yii2-datetime-compare-validator
===============================
Validator for yii2 allows you to compare dates.

using
===============================
```php
public function rules()
{
    return [
        [['begin', nepstor\validators\DateTimeCompareValidator::className(), 'compareAttribute' => 'end', 'format' => 'Y-m-d', 'operator' => '>='
    ];
}
```
    