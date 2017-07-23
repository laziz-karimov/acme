<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $uid
 * @property string $username
 * @property string $email
 * @property string $password
 * @property integer $status
 * @property integer $contact_email
 * @property integer $contact_phone
 * @property string $auth_key
 * @property string $created
 * @property string $updated
 * 
 * @property Auth[] $auths
 * @property Message[] $fromMessages
 * @property Message[] $toMessages
 * @property PhoneNumber[] $phoneNumbers
 * @property Trip[] $trips
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {
    
    const STATUS_INSERTED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;
    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['uid', 'username', 'email', 'password', 'auth_key'], 'required'],
                [['status', 'contact_email', 'contact_phone'], 'integer'],
                [['email'], 'email'],
                [['created', 'updated'], 'safe'],
                [['uid', 'password', 'auth_key'], 'string', 'max' => 60],
                [['username'], 'string', 'max' => 45],
                [['email'], 'string', 'max' => 255],
                [['uid'], 'unique'],
                [['email'], 'unique'],
                [['auth_key'], 'unique']
        ];
    }
    
    public function beforeValidate() {
        if ($this->isNewRecord) {
            $this->setUid();
            $this->setAuthKey();
        }
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        }
        $this->updated = new Expression('NOW()');
        return parent::beforeSave($insert);
    }
    
    private function setUid() {
        $this->uid = Yii::$app->security->generateRandomString(60);
    }

    private function setAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString(60);
    }  
    
    public function activate() {
        $this->status = self::STATUS_ACTIVE;
        $this->setUid();
        return $this->save();
    }    

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', 'Uid'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'status' => Yii::t('app', 'Status'),
            'contact_email' => Yii::t('app', 'Contact Email'),
            'contact_phone' => Yii::t('app', 'Contact Phone'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths() {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromMessages() {
        return $this->hasMany(Message::className(), ['from_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToMessages() {
        return $this->hasMany(Message::className(), ['to_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhoneNumbers() {
        return $this->hasMany(PhoneNumber::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips() {
        return $this->hasMany(Trip::className(), ['user_id' => 'id']);
    }
    
    public static function findByEmail($email) {
        return self::findOne(['email' => $email]);
    }    
    
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password);
    }   
    
    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->auth_key === $authKey;
    }

    public static function findIdentity($id) {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return null;
    }    

}
