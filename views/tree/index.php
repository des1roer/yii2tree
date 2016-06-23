<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TreeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use execut\widget\TreeView;
use app\models\Tree;

$items = [
    [
        'text' => 'Parent 1',
        'nodes' => [
            [
                'text' => 'Child 1',
                'nodes' => [
                    [
                        'text' => 'Grandchild 1',
                        'href' => 'google'
                    ],
                    [
                        'text' => 'Grandchild 2'
                    ]
                ]
            ],
            [
                'text' => 'Child 2',
            ]
        ],
    ],
    [
        'text' => 'Parent 2',
    ]
];
//echo '<pre>';
//var_dump($items);
//echo '=================================';
                function Recurs(&$rs, $parent)
                {
                    $out = array();
                    if (!isset($rs[$parent]))
                    {
                        return $out;
                    }
                    foreach($rs[$parent] as $row)
                    {
                        $chidls = Recurs($rs, $row['id']);
                        if ($chidls)
                        {
                                $row['nodes'] = $chidls;                           
                        }
                        $out[] = $row;
                    };
                    return $out;
                }


$items = [];
$tree = Tree::dataTree();
foreach ($tree as $key => $value) {
    if (empty($value->tree_id)) $value->tree_id = 0;
    $items[$value->tree_id][] =['id_parent' => $value->tree_id,
        'id' => $value->id,
        'text' => $value->name];
}



//var_dump(Recurs($items, 0));
//echo $value->tree_id;
$onSelect = new \yii\web\JsExpression(<<<JS
        
function (undefined, item) {
       // alert (item.text);
    /*$.pjax({
        container: '#pjax-container',
        url: item.href,
        timeout: null
    });*/
             $.ajax({
                        url: "/tree/renderme?id=" + item.id,
                        type: "POST",
                        data: {'id' : item.id},
                        contentType: false,
                        cache: false,
                        success: function (data) {                       
                            $("#pjax-container").html(data);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                        }
                    });
}
JS
);
echo $groupsContent = TreeView::widget([
    'data' => Recurs($items, 0),
    'size' => TreeView::SIZE_SMALL,
    'clientOptions' => [
        'onNodeSelected' => $onSelect,
        'selectedBackColor' => 'rgb(40, 153, 57)',
        'borderColor' => '#fff',
    ],
]);

$this->title = 'Trees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="pjax-container"></div>
<div class="tree-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
<?= Html::a('Create Tree', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        <?php Pjax::begin(); ?>    <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                'url:url',
                'tree_id',
                'txt:ntext',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
    <?php Pjax::end(); ?></div>
