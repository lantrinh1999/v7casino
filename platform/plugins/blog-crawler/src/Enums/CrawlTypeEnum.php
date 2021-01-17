<?php

namespace Botble\BlogCrawler\Enums;

use Botble\Base\Supports\Enum;
use Html;

/**
 * @method static BaseStatusEnum DRAFT()
 * @method static BaseStatusEnum PUBLISHED()
 * @method static BaseStatusEnum PENDING()
 */
class CrawlTypeEnum extends Enum
{
    public const NOW = 'now';
    public const AFTER = 'after';

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
            case self::NOW:
                return Html::tag('span', self::NOW()->label(), ['class' => 'label-success status-label'])
                    ->toHtml();
            case self::AFTER:
                return Html::tag('span', self::AFTER()->label(), ['class' => 'label-secondary status-label'])
                    ->toHtml();
            default:
                return parent::toHtml();
        }
    }
}
