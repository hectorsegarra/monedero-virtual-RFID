<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "monedero_historico".
 *
 * @property integer $id
 * @property integer $monedero_id
 * @property integer $terminal_id
 * @property string $fecha_hora
 * @property string $tipo_operacion
 * @property string $importe
 * @property string $concepto
 *
 * @property Terminal $terminal
 * @property Monedero $monedero
 */
class MonederoHistorico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monedero_historico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['monedero_id', 'terminal_id', 'tipo_operacion', 'importe', 'concepto'], 'required'],
            [['monedero_id', 'terminal_id'], 'integer'],
            [['fecha_hora'], 'safe'],
            //[['importe'], 'number'],
            [['tipo_operacion'], 'string', 'max' => 50],
            [['concepto'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'monedero_id' => 'Monedero ID',
            'terminal_id' => 'Terminal ID',
            'fecha_hora' => 'Fecha Hora',
            'tipo_operacion' => 'Tipo Operacion',
            'importe' => 'Importe',
            'concepto' => 'Concepto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerminal()
    {
        return $this->hasOne(Terminal::className(), ['id' => 'terminal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMonedero()
    {
        return $this->hasOne(Monedero::className(), ['id' => 'monedero_id']);
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
