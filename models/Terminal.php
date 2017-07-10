<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "terminal".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 *
 * @property MonederoHistorico[] $monederoHistoricos
 */
class Terminal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'terminal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion'], 'required'],
            [['nombre'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonederoHistoricos()
    {
        return $this->hasMany(MonederoHistorico::className(), ['terminal_id' => 'id']);
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