<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "place".
 *
 * @property string $id
 * @property string $place_id
 * @property string $lat
 * @property string $lng
 * @property string $country_code
 * @property integer $is_country
 *
 * @property PlaceLang[] $placeLangs
 * @property Trip[] $fromTrips
 * @property Trip[] $toTrips
 */
class Place extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'place';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['place_id', 'lat', 'lng', 'country_code', 'is_country'], 'required'],
            [['is_country'], 'integer'],
            [['place_id', 'lat', 'lng'], 'string', 'max' => 45],
            [['country_code'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'place_id' => Yii::t('app', 'Place ID'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'country_code' => Yii::t('app', 'Country Code'),
            'is_country' => Yii::t('app', 'Is Country'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaceLangs()
    {
        return $this->hasMany(PlaceLang::className(), ['place_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromTrips()
    {
        return $this->hasMany(Trip::className(), ['from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToTrips()
    {
        return $this->hasMany(Trip::className(), ['to' => 'id']);
    }
}
