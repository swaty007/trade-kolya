<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "informer_category".
 *
 * @property int $id
 * @property int $informer_id
 * @property int $category_id
 *
 * @property Informer $informer
 * @property Categories $category
 */
class InformerCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informer_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['informer_id', 'category_id'], 'required'],
            [['informer_id', 'category_id'], 'integer'],
            [['id'], 'unique'],
            [['informer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Informer::className(), 'targetAttribute' => ['informer_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
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
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
}
