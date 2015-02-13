<?php
namespace perspectivain\geo\validators;

use Yii;

class PolygonValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} must be an array of points".');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        $valid = !$this->strict && ($value == $this->trueValue || $value == $this->falseValue)
            || $this->strict && ($value === $this->trueValue || $value === $this->falseValue);
        if (!$valid) {
            return [$this->message, [
                'true' => $this->trueValue,
                'false' => $this->falseValue,
            ]];
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($object, $attribute, $view)
    {
        $options = [
            'trueValue' => $this->trueValue,
            'falseValue' => $this->falseValue,
            'message' => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $object->getAttributeLabel($attribute),
                'true' => $this->trueValue,
                'false' => $this->falseValue,
            ], Yii::$app->language),
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }
        if ($this->strict) {
            $options['strict'] = 1;
        }

        ValidationAsset::register($view);

        return 'yii.validation.boolean(value, messages, ' . json_encode($options) . ');';
    }
}
