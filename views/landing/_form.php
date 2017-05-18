<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use app\models\Landing;
use app\models\Place;
use app\models\User;
use dosamigos\ckeditor\CKEditor;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Landing */
/* @var $form yii\widgets\ActiveForm */
/* @var $numPlaces integer */
/* @var $existingPlaces array of app\models\Place */

// Generating different labels on Update action to show images
    // $object_photos_label = $model->getAttributeLabel('object_photos');
    $bg_photo_label = $model->getAttributeLabel('bg_photo_file');
    $object_photos_label = $model->getAttributeLabel('photos_files');
    $object_arendator_photos_label = $model->getAttributeLabel('arendator_photos_files');
    // on Update we attach existing images to labels
    if (!$model->isNewRecord){
        // $object_photos_label .= '<br><img src="' 
        // .  $model->object_photos
        // . '">';

        if ($model->bg_photo)
            $bg_photo_label .= Html::img($model->bg_photo, ['style' => 'max-width: 400px']).'<br>'.'<br>';

        $photos = json_decode($model->photos);
        if ($photos){
            $answ = '<br>';
            $i = 0;
            foreach ($photos as $photo){
                $answ .= Html::img($photo, ['style' => 'max-width: 100px'])
                .'<a href="'
                    .Url::toRoute([
                        'delete-photo', 
                        'id' => $model->landing_id,
                        'numPlaces' => $numPlaces,
                        'photoCat' => Landing::PHOTOS_CAT,
                        'photoId' => $i,
                    ])
                    . '" class="btn btn-danger ml20"> Удалить </a>';
                    if (($i + 1) % 4 === 0)
                        $answ .= '<br> <br>';
                $i++;
            }
            $object_photos_label .= $answ;
        }

        $photos = json_decode($model->arendator_photos);
        if ($photos){
            $answ = '<br>';
            $i = 0;
            foreach ($photos as $photo){
                $answ .= Html::img($photo, ['style' => 'max-width: 100px'])
                .'<a href="'
                    .Url::toRoute([
                        'delete-photo', 
                        'id' => $model->landing_id,
                        'numPlaces' => $numPlaces,
                        'photoCat' => Landing::ARENDATORS_CAT,
                        'photoId' => $i,
                    ])
                    . '" class="btn btn-danger ml20"> Удалить </a>';
                    if (($i + 1) % 4 === 0)
                        $answ .= '<br> <br>';
                $i++;
            }
            $object_arendator_photos_label .= $answ;
        }
    }

    $tinyOptions = [ 
        'options' => ['rows' => 6],
        'language' => 'ru',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste image"
            ],
            'toolbar' => "image insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
            // 'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            'relative_urls' => false,
    ]];
?>

<div class="landing-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photos_files[]')->fileInput(['multiple' => true])->label($object_photos_label) ?>

    <?= $form->field($model, 'arendator_photos_files[]')->fileInput(['multiple' => true])->label($object_arendator_photos_label) ?>

    <table class="table">
        <thead class="thead-inverse">
            <tr>
                <th>Метраж</th>
                <th>Этаж</th>
                <th>Состояние</th>
                <th>Планировка</th>
                <th>Ставка</th>
                <th></th>
                <th>Фото</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $startIndex = 0; ?>
            <?php  if (!$model->isNewRecord): 
                $startIndex = count($existingPlaces);
                // outputting existing places
            ?>
                 <?php for ($i = 0; $i < count($existingPlaces); $i++): ?>
                <tr>
                    <td style="width: 100px"><?= $form->field($model, 'meters[' . $i . ']')->textInput(['size' => 2, 'value' => $existingPlaces[$i]['meters']])->label(false) ?></td>
                    <td style="width: 100px"><?= $form->field($model, 'floor[' . $i . ']')->textInput(['maxlength' => true, 'size' => 1, 'value' => $existingPlaces[$i]['floor']])->label(false) ?></td>
                    <td style="width: 150px">
                        <?= $form->field($model, 'state[' . $i . ']')->dropDownList([
                            Place::STATE_READY => 'готово к въезду',
                            Place::STATE_OTDELKA => 'под отделку',
                            Place::STATE_CLEAR_OTDELKA => 'под чистовую отделку',
                            Place::STATE_SELLING => 'продажа',
                        ], ['value' => $existingPlaces[$i]['state']])->label(false) ?>
                    </td>
                    <td style="width: 150px">
                        <?= $form->field($model, 'planning[' . $i . ']')->dropDownList([
                            Place::PLANNING_OPEN => 'открытая',
                            Place::PLANNING_MIXED => 'смешанная',
                            Place::PLANNING_CABINET => 'кабинетная',
                        ], ['value' => $existingPlaces[$i]['planning']])->label(false) ?>
                    </td>
                    <td style="width: 100px">
                        <?= $form->field($model, 'price[' . $i . ']')->textInput(['value' => $existingPlaces[$i]['price']])->label(false) ?>
                    </td>
                    <td>
                         <?= $form->field($model, 'price_sign[' . $i . ']')->dropDownList([
                            Place::PRICE_SIGN_RUB => 'Руб',
                            Place::PRICE_SIGN_DOL => '$',
                            Place::PRICE_SIGN_EUR => '€',
                        ], ['value' => $existingPlaces[$i]['price_sign']])->label(false) ?>
                    </td>
                    <td style="width: 150px">
                        <div>
                            <?php 
                                // outputting existing photos for objects
                                $photos = json_decode($existingPlaces[$i]['object_photos']);
                                if ($photos){
                                    $answ = '<br>';
                                    $j = 0;
                                    foreach ($photos as $photo){
                                        $answ .= Html::img($photo, ['style' => 'max-width: 80px'])
                                        .'<a href="'
                                            .Url::toRoute([
                                                'delete-photo', 
                                                'id' => $model->landing_id,
                                                'numPlaces' => $numPlaces,
                                                'photoCat' => Landing::PLACES_CAT,
                                                'photoId' => $j,
                                                'placeId' => $existingPlaces[$i]['place_id'],
                                            ])
                                            . '" class="btn btn-danger ml20"> Удалить </a>'
                                        .'<br>'.'<br>';
                                        $j++;
                                    }
                                }
                             ?>
                             <?= $answ ?>
                        </div>
                        <?= $form->field($model, 'object_photos_files[' . $i . '][]')->fileInput(['multiple' => true])->label(false) ?>
                            
                    </td>
                    <td>
                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', 'index.php?r=place/delete&id='
                                . $existingPlaces[$i]['place_id']
                                . "&land_id=" . $model['landing_id']
                                . "&numPlaces=" . (count($existingPlaces) - 1), 
                            [
                                'title' => 'Удалить помещение',
                    ]); ?>
                    </td>
                </tr>      
                <?php endfor; ?> 

            <?php endif; ?>
            
            <?php for ($i = $startIndex; $i < $numPlaces; $i++): ?>
            <tr>
                <td style="width: 100px"><?= $form->field($model, 'meters[' . $i . ']')->textInput(['size' => 2])->label(false) ?></td>
                <td style="width: 100px"><?= $form->field($model, 'floor[' . $i . ']')->textInput(['maxlength' => true, 'size' => 1])->label(false) ?></td>
                <td style="width: 150px">
                    <?= $form->field($model, 'state[' . $i . ']')->dropDownList([
                        Place::STATE_READY => 'готово к въезду',
                        Place::STATE_OTDELKA => 'под отделку',
                        Place::STATE_CLEAR_OTDELKA => 'под чистовую отделку',
                        Place::STATE_SELLING => 'продажа',
                    ])->label(false) ?>
                </td>
                <td style="width: 150px">
                    <?= $form->field($model, 'planning[' . $i . ']')->dropDownList([
                        Place::PLANNING_OPEN => 'открытая',
                        Place::PLANNING_MIXED => 'смешанная',
                        Place::PLANNING_CABINET => 'кабинетная',
                    ])->label(false) ?>
                </td>
                <td style="width: 100px">
                    <?= $form->field($model, 'price[' . $i . ']')->textInput()->label(false) ?>
                </td>
                <td>
                     <?= $form->field($model, 'price_sign[' . $i . ']')->dropDownList([
                        Place::PRICE_SIGN_RUB => 'Руб',
                        Place::PRICE_SIGN_DOL => '$',
                        Place::PRICE_SIGN_EUR => '€',
                    ])->label(false) ?>
                </td>
                <td style="width: 150px"><?= $form->field($model, 'object_photos_files[' . $i . '][]')->fileInput(['multiple' => true])->label(false) ?></td>
            </tr>        
            <?php endfor; ?>   
        </tbody>
    </table>

    <?= $form->field($model, 'building_type')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'bg_photo_file')->fileInput()->label($bg_photo_label) ?>
    
    <?= $form->field($model, 'about_text')->widget(TinyMce::className(), $tinyOptions) ?> 

    <?= $form->field($model, 'characteristics_text')->widget(TinyMce::className(), $tinyOptions) ?>

    <?= $form->field($model, 'news_text')->widget(TinyMce::className(), $tinyOptions) ?>

    <?= $form->field($model, 'infostructure_text')->widget(TinyMce::className(), $tinyOptions) ?>    

    <?= $form->field($model, 'location_text')->widget(TinyMce::className(), $tinyOptions) ?>

    <?= $form->field($model, 'contacts_text')->widget(TinyMce::className(), $tinyOptions) ?>

    <?= $form->field($model, 'latitude')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'longitude')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var trHtml = ''; // tr with 0-index
    var initialNum = 0; // Landing[meters][0]
    var curCount = 0; // Landing[meters][curCount]

    /**
     * Generates new tr html from the initial
     * by replacing 0 index to the current index.
     * 
     * @param  {string} initialTr - tr code with 0 indexes  
     * @param  {integer} num   - number to be pasted instead of 0
     * @return {string}  new tr code
     */
    function createTrHtml(initialTr, num){
        var buff = initialTr;

        buff = buff.replace(/-0/g, '-' + num); // /value/g performs global replacement
        buff = buff.replace('[0]', '[' + num + ']');

        return buff;
    }

    /**
     * Function which fires when "Add place" btn is clicked
     */
    function addNewPlace(){
        curCount++;
        var newTrHtml = createTrHtml(trHtml, curCount);
        $('tbody').append(newTrHtml);        
    }

    // $(document).ready(function(){
    //     trHtml = "<tr>" + $('tbody tr.first').html() + "</tr>";

    //     $('#addPlaceBtn').bind('click', function(event){
    //         event.preventDefault();
    //         addNewPlace();
    //     });
    // });
    
</script>