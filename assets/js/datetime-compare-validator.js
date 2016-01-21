/**
* @link https://github.com/nepstor/yii2-datetime-compare-validator
* @copyright Copyright (c) 2014 Nikita Krytskiy
* @license http://opensource.org/licenses/BSD-3-Clause
*/
yii.validation.datetimecompare = function (value, messages, options) {
    if (options.skipOnEmpty && yii.validation.isEmpty(value)) {
        return null;
    }
    
    var compareValue, valid = true;
    var dateValue = moment(value).unix();
    var dateCompareValue =  moment(options.compareValue).unix();

    compareValue = options.compareAttribute === undefined ? options.compareValue : $('#' + options.compareAttribute).val();

    switch (options.operator) {
        case '==':
            valid = dateValue == dateCompareValue;
            break;
        case '===':
            valid = value === compareValue;
            break;
        case '!=':
            valid = dateValue != dateCompareValue;
            break;
        case '!==':
            valid = value !== compareValue;
            break;
        case '>':
            valid = dateValue > dateCompareValue;
            break;
        case '>=':
            valid = dateValue >= dateCompareValue;
            break;
        case '<':
            valid = dateValue < dateCompareValue;
            break;
        case '<=':
            valid = dateValue <= dateCompareValue;
            break;
        default:
            valid = false;
            break;
    }

    if (!valid) {
        yii.validation.addMessage(messages, options.message, value);
    }
};