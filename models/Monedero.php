<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "monedero".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property string $cantidad
 *
 * @property Usuario $usuario
 * @property MonederoHistorico[] $monederoHistoricos
 */
class Monedero extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monedero';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'cantidad'], 'required'],
            [['usuario_id'], 'integer'],
            //[['cantidad'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'usuario_id' => 'ID de usuario',
            'cantidad' => 'Cantidad de saldo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonederoHistoricos()
    {
        return $this->hasMany(MonederoHistorico::className(), ['monedero_id' => 'id']);
    }

    /**
    * @inheritdoc
    */
    /*public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
                                                                                return true;
        } else {
            return false;
        }
    }*/
}
