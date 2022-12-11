<?php

namespace common\components\pdfjs;

/**
 * pdfjs module definition class
 * @author Sathit Seethaphon <dixonsatit@gmail.com>
 */
class Module extends \yii\base\Module {
    public $buttons = [];

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\components\pdfjs\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();


        $this->buttons = array_merge([
            'presentationMode' => true,
            'openFile' => true,
            'print' => true,
            'download' => true,
            'viewBookmark' => true,
            'secondaryToolbarToggle' => true
        ], $this->buttons);

        // custom initialization code goes here
    }
}
