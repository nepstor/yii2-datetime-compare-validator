<?php
/**
* @link https://github.com/nepstor/yii2-datetime-compare-validator
* @copyright Copyright (c) 2014 Nikita Krytskiy
* @license http://opensource.org/licenses/BSD-3-Clause
*/

namespace nepstor\validators;

use yii\web\AssetBundle;

/**
 * Asset bundle provides the javascript files for momentjs.
 * @see https://github.com/moment/moment/
 * @author Nepstor <nepstor_j@mail.ru>
 */
class MomentJsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/moment/min';
    
    /**
     * @inheritdoc
     */
    public $js = [
        'moment.min.js',
    ];
}
