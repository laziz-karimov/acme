<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trip".
 *
 * @property string $id
 * @property string $user_id
 * @property string $from
 * @property string $to
 * @property string $date
 * @property integer $number_seats
 * @property string $duration
 * @property string $price
 * @property string $currency_id
 * @property integer $status
 * @property string $created
 * @property string $updated
 *
 * @property Message[] $messages
 * @property Currency $currency
 * @property Place $fromPlace
 * @property Place $toPlace
 * @property User $user
 */
class Trip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'from', 'to', 'date', 'number_seats', 'duration', 'price', 'currency_id'], 'required'],
            [['user_id', 'from', 'to', 'number_seats', 'currency_id', 'status'], 'integer'],
            [['date', 'created', 'updated'], 'safe'],
            [['duration', 'price'], 'number'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['from'], 'exist', 'skipOnError' => true, 'targetClass' => Place::className(), 'targetAttribute' => ['from' => 'id']],
            [['to'], 'exist', 'skipOnError' => true, 'targetClass' => Place::className(), 'targetAttribute' => ['to' => 'id']],
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
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'date' => Yii::t('app', 'Date'),
            'number_seats' => Yii::t('app', 'Number Seats'),
            'duration' => Yii::t('app', 'Duration'),
            'price' => Yii::t('app', 'Price'),
            'currency_id' => Yii::t('app', 'Currency ID'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['trip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToPlace()
    {
        return $this->hasOne(Place::className(), ['id' => 'to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
