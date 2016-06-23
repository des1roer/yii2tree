<?php
namespace app\models;
use Yii;

/**
 * This is the model class for table "tree".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $tree_id
 * @property string $txt
 *
 * @property Tree $tree
 * @property Tree[] $trees
 */
class Tree extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'tree';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['tree_id'], 'integer'],
            [['txt'], 'string'],
            [['name', 'url'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['url'], 'unique'],
            [['url'], 'default', 'value' => null],
            [['tree_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tree::className(), 'targetAttribute' => ['tree_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'имя',
            'url' => 'путь',
            'tree_id' => 'предок',
            'txt' => 'сообщение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree() {
        return $this->hasOne(Tree::className(), ['id' => 'tree_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrees() {
        return $this->hasMany(Tree::className(), ['tree_id' => 'id']);
    }

    public function myname($id) {
        $model = Tree::find()
                        ->where(['id' => $id])
                        ->one()->name;
        return $model;
    }

        public function dataTree() {
        $model = Tree::find()->all();
        return $model;
    }
}
