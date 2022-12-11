<?php

namespace common\components\pdfjs;

use Yii;

/**
 * PdfJs Widget
 * @author Sathit Seethaphon <dixonsatit@gmail.com>
 */
class PdfJs extends \yii\base\Widget {
    public $url = null;

    public $width = '100%';

    public $height = '500px';

    public $options = [];

    public $buttons = [];

    public function init() {
        parent::init();
        $buttons = Yii::$app->getModule('pdfjs')->buttons;
        $this->buttons = array_merge($buttons, $this->buttons);
        //$this->getView()->registerJsFile(Yii::$app->assetManager->getPublishedUrl('@app/components/pdfjs/assets').'/yii2-pdfjs.js');
    }

    public function run() {
        if (!array_key_exists('style', $this->options)) {
            $this->options['style'] = 'border:solid 2px #404040; width:' . $this->width . '; height:' . $this->height . ';';
        }
        //$this->id = str_replace('-', '_', \Yii::$app->security->generateRandomString());
        return $this->render('viewer', [
            'options' => $this->options,
            'url' => $this->url,
            'buttons' => $this->buttons,
            'id' => $this->id
        ]);
    }
}
