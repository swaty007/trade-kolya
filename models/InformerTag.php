<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "informer_tag".
 *
 * @property int $id
 * @property int $informer_id
 * @property int $tag_id
 *
 * @property Informer $informer
 * @property Tags $tag
 */
class InformerTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informer_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['informer_id', 'tag_id'], 'required'],
            [['informer_id', 'tag_id'], 'integer'],
            [['id'], 'unique'],
            [['informer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Informer::className(), 'targetAttribute' => ['informer_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'informer_id' => 'Informer ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformer()
    {
        return $this->hasOne(Informer::className(), ['id' => 'informer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    }
}
