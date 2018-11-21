<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property int $id
 * @property string $tag_name
 *
 * @property InformerTag[] $informerTags
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformerTags()
    {
        return $this->hasMany(InformerTag::className(), ['tag_id' => 'id']);
    }

    public function getInformers()
    {
        return $this->hasMany(Informer::className(), ['id' => 'informer_id'])
            ->viaTable('informer_tag', ['tag_id' => 'id']);

    }
}
