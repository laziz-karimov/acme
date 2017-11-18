<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phone_number".
 *
 * @property string $id
 * @property string $user_id
 * @property string $country_id
 * @property string $number
 * @property string $verification_code
 * @property integer $verified
 * @property integer $active
 * @property string $created
 *
 * @property Country $country
 * @property User $user
 */
class PhoneNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'phone_number';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'country_id', 'number'], 'required'],
            [['user_id', 'country_id', 'verified', 'active'], 'integer'],
            [['created'], 'safe'],
            [['verified'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['number', 'verification_code'], 'string', 'max' => 45],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'number' => Yii::t('app', 'Number'),
            'verification_code' => Yii::t('app', 'Verification Code'),
            'verified' => Yii::t('app', 'Verified'),
            'active' => Yii::t('app', 'Active'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
