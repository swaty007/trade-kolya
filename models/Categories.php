<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $cat_name
 * @property int $parent_id
 *
 * @property InformerCategory[] $informerCategories
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['parent_id'], 'integer'],
            [['cat_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformerCategories()
    {
        return $this->hasMany(InformerCategory::className(), ['category_id' => 'id']);
    }
    public function getInformers()
    {
        return $this->hasMany(Informer::className(), ['id' => 'informer_id'])
            ->viaTable('informer_category', ['category_id' => 'id']);
    }
}
