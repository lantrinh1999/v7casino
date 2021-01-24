<?php

namespace Botble\BlogCrawler\Enums;

use Botble\Base\Supports\Enum;
use Html;

/**
 * @method static BaseStatusEnum DRAFT()
 * @method static BaseStatusEnum PUBLISHED()
 * @method static BaseStatusEnum PENDING()
 */
class CrawlStatusEnum extends Enum
{
    public const RUNNING = 'running';
    public const NOT_RUNNING = 'not_running';
    public const DONE = 'done';

    // /**
    //  * @var string
    //  */
    // public static $langPath = 'core/base::enums.statuses';

    /**
     * @return string
     */
    public function toHtml()
    {
        switch ($this->value) {
            case self::RUNNING:
                return Html::tag('span', self::RUNNING()->label(), ['class' => 'label-info status-label'])
                    ->toHtml();
            case self::NOT_RUNNING:
                return Html::tag('span', self::NOT_RUNNING()->label(), ['class' => 'label-primary status-label'])
                    ->toHtml();
            case self::DONE:
                return Html::tag('span', self::DONE()->label(), ['class' => 'label-primary status-label'])
                    ->toHtml();
            default:
                return parent::toHtml();
        }
    }
}
