<?php

use app\models\DocumentType;
use yii\helpers\ArrayHelper;
use yii\web\View;

$searchJs = <<< JS
    $('#search-btn').click(() => {
        $('#search-form').toggle(500);
    });
JS;

$this->registerJs($searchJs, View::POS_LOAD);
$documentsTypeList = ArrayHelper::map(DocumentType::find()->forPersonalAndPostulationFiles()->all(), 'code', 'name');
?>
<button id="search-btn" class="btn btn-warning mb-3">Busqueda de archivos</button>
<div id="search-form" class="mb-2" style="display: none;">
    <form action="" method="get">
        <h3>Busqueda</h3>
        <label for="">Description</label>
        <input type="text" name="PersonalFileSearch[description]" class="form-control">
        <label for="">Docuement Type</label>
        <select id="" name="PersonalFileSearch[document_type_code]" class="form-control">
        <?php foreach ($documentsTypeList as $code => $name) : ?>
            <option value="<?= $code ?>"><?= $name ?></option>
        <?php endforeach; ?>
        </select>
        <button class="btn btn-success mt-2">search</button>
    </form>
</div>

