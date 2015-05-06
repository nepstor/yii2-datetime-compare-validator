<?php
/**
* @link https://github.com/nepstor/yii2-datetime-compare-validator
* @copyright Copyright (c) 2014 Nikita Krytskiy
* @license http://opensource.org/licenses/BSD-3-Clause
*/

namespace nepstor\validators;

use Yii;
use yii\base\Exception;
use yii\validators\Validator;
use DateTime;

/**
 * Class DateTimeCompareValidator
 * @author Nepstor <nepstor_j@mail.ru>
 */
class DateTimeCompareValidator extends Validator
{

    /**
     * @var string the date format that the value being validated should follow.
     * Please refer to <http://www.php.net/manual/en/datetime.createfromformat.php> on
     * supported formats.
     */
    public $format = 'Y-m-d';

    /**
     * @var string the name of the attribute to be compared with
     */
    public $compareAttribute;

    /**
     * @var string|\DateTime the constant value to be compared with
     */
    public $compareValue;

    /**
     * @var boolean whether the attribute value can be null or empty. Defaults to false.
     * If this is true, it means the attribute is considered valid when it is empty.
     */
    public $allowEmpty = false;

    /**
     * @var string the operator for comparison. Defaults to '='.
     * The followings are valid operators:
     * <ul>
     * <li>'=' or '==': validates to see if the two values are equal;</li>
     * <li>'!=': validates to see if the two values are NOT equal;</li>
     * <li>'>': validates to see if the value being validated is greater than the value being compared with;</li>
     * <li>'>=': validates to see if the value being validated is greater than or equal to the value being compared with;</li>
     * <li>'<': validates to see if the value being validated is less than the value being compared with;</li>
     * <li>'<=': validates to see if the value being validated is less than or equal to the value being compared with.</li>
     * </ul>
     */
    public $operator = '=';

    public function init()
    {
        parent::init();

        if ($this->isEmpty($this->compareAttribute) && $this->isEmpty($this->compareValue)) {
            throw new Exception(Yii::t('app', 'You must specify compareAttribute or compareValue'));
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if ($this->allowEmpty && $this->isEmpty($value)) {
            return null;
        }

        if ($this->compareValue === null) {
            $compareAttribute = $this->compareAttribute;
            $compareValue = $model->$compareAttribute;
            $compareTo = $model->getAttributeLabel($compareAttribute);
            $compareValueDT = DateTime::createFromFormat($this->format, $compareValue);
        } elseif ($this->compareValue instanceof DateTime) {
            $compareTo = $this->compareValue->format($this->format);
            $compareValue = $compareTo;
            $compareValueDT = $this->compareValue;
        } else {
            $compareTo = $this->compareValue;
            $compareValue = $this->compareValue;
            $compareValueDT = DateTime::createFromFormat($this->format, $this->compareValue);
        }

        if (!$compareValueDT instanceof DateTime) {
            $this->addError($model, null !== $this->compareAttribute ? $compareAttribute : $attribute, Yii::t('yii', 'Invalid compare value date format: {value}'), ['{value}' => $compareValue]);
            return null;
        }

        $valueDT = DateTime::createFromFormat($this->format, $value);

        if (!$valueDT instanceof DateTime) {
            $this->addError($model, $attribute, Yii::t('yii', 'Invalid value date format: {value}'), [
                '{value}' => $value
            ]);
            return null;
        }

        switch ($this->operator) {
            case '=':
                if ($valueDT != $compareValueDT) {
                    $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be repeated exactly.');
                }
                break;
            case '!=':
                if ($valueDT == $compareValueDT) {
                    $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must not be equal to "{compareValue}".');
                }
                break;
            case '>':
                if ($valueDT <= $compareValueDT) {
                    $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be greater than "{compareValue}".');
                }
                break;
            case '>=':
                if ($valueDT < $compareValueDT) {
                    $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be greater than or equal to "{compareValue}".');
                }
                break;
            case '<':
                if ($valueDT >= $compareValueDT) {
                    $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be less than "{compareValue}".');
                }
                break;
            case '<=':
                if ($valueDT > $compareValueDT) {
                    $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} must be less than or equal to "{compareValue}".');
                }
                break;
            default:
                throw new Exception(Yii::t('yii', 'Invalid operator "{operator}".', [
                    '{operator}' => $this->operator
                ]));
        }

        if (!empty($message)) {
            $this->addError($model, $attribute, $message, [
                'compareAttribute' => $compareTo,
                'compareValue' => $compareValue
            ]);
        }
    }

}
