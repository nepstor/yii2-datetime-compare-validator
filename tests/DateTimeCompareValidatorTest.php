<?php

use yii\base\DynamicModel;
use nepstor\validators\DateTimeCompareValidator;

class DateTimeCompareValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testValidateOperatorNotEqual()
    {
        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '!=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $compareErrorText = Yii::t('app', '{attribute} must not be equal to "{compareValue}".', ['attribute' => 'Date From', 'compareValue' => '2016-01-01']);
        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-02']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '!=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);

        $model = new DynamicModel(['date_from' => '2016-01-02', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '!=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);
    }

    public function testValidateOperatorLess()
    {
        $compareErrorText = Yii::t('app', '{attribute} must be less than "{compareValue}".', ['attribute' => 'Date From', 'compareValue' => '2016-01-01']);

        $model = new DynamicModel(['date_from' => '2016-01-02', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '<']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '<']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-02']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '<']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);
    }

    public function testValidateOperatorLessOrEqual()
    {
        $model = new DynamicModel(['date_from' => '2016-01-30', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '<=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $compareErrorText = Yii::t('app', '{attribute} must be less than or equal to "{compareValue}".', ['attribute' => 'Date From', 'compareValue' => '2016-01-01']);
        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '<=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-02']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '<=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);
    }

    public function testValidateOperatorRepeatedExactly()
    {
        $model = new DynamicModel(['date_from' => '2016-01-02', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $compareErrorText = Yii::t('app', '{attribute} must be repeated exactly.', ['attribute' => 'Date From', 'compareValue' => '2016-01-02']);
        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-02']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $compareErrorText = Yii::t('app', '{attribute} must be repeated exactly.', ['attribute' => 'Date From', 'compareValue' => '2016-01-01']);
        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '=']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);
    }

    public function testValidateOperatorGreater()
    {
        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-02']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '>']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $compareErrorText = Yii::t('app', '{attribute} must be greater than "{compareValue}".', ['attribute' => 'Date From', 'compareValue' => '2016-01-02']);
        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '>']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $compareErrorText = Yii::t('app', '{attribute} must be greater than "{compareValue}".', ['attribute' => 'Date From', 'compareValue' => '2016-01-01']);
        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-02', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '>']);
        $model->validate();

        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);
    }

    public function testValidateOperatorGreaterOrEqual()
    {
        $compareErrorText = Yii::t('app', '{attribute} must be greater than or equal to "{compareValue}".', ['attribute' => 'Date From', 'compareValue' => '2016-01-02']);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-02']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '>=']);

        $model->validate();
        $errorText = $model->getFirstError('date_from');

        $this->assertEquals($errorText, $compareErrorText);

        $model = new DynamicModel(['date_from' => '2016-01-01', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '>=']);

        $model->validate();
        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);

        $model = new DynamicModel(['date_from' => '2016-01-02', 'date_to' => '2016-01-01']);
        $model->addRule(['date_from', 'date_to'], 'required');
        $model->addRule(['date_from'], DateTimeCompareValidator::className(), ['compareAttribute' => 'date_to', 'format' => 'Y-m-d', 'operator' => '>=']);

        $model->validate();
        $errorText = $model->getFirstError('date_from');
        $this->assertNull($errorText);
    }
}