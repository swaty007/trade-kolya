<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "informer".
 * @property int $id
 * @property string $title
 * @property string $html
 * @property string $link
 * @property string $date
 * @property string $src
 * @property InformerCategory[] $informerCategories
 * @property InformerTag[] $informerTags
 */

class Informer extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'link'], 'string', 'max' => 50],
            [['file'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'html' => 'Html',
            'link' => 'Link',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getTag()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])
            ->viaTable('informer_tag', ['informer_id' => 'id']);

    }

    public function getCategory()
    {
        return $this->hasMany(Categories::className(), ['id' => 'category_id'])
            ->viaTable('informer_category', ['informer_id' => 'id']);

    }
}