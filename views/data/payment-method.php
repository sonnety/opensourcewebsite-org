<?php

use yii\helpers\Html;

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Payment Method</h3>
        <div class="card-tools">
            <?php echo LinkPager::widget([
                'pagination' => $pages,
                'linkContainerOptions' => [
                    'class' => 'page-item',
                ],
                'linkOptions' => [
                    'class' => 'page-link',
                ],
                'maxButtonCount' => 5,
                'disabledListItemSubTagOptions' => [
                    'tag' => 'a',
                    'class' => 'page-link',
                ],
            ]); ?>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                </tr>
                <?php foreach ($models as $key => $model) : ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $model->name ?? null; ?></td>
                        <td><?php echo $model->type ?? null; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
