<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class TranslationHelper
{
    /**
     * Get result of hide field from form or not.
     *
     * @param int|string|null $locale_id The locale id.
     * @param int|string|null $item_id The item id.
     * @param string|null $item_field The item table field.
     * @param Model $model The model.
     * @return bool
     */
    public static function isHide(
        int|string|null $locale_id,
        int|string|null $item_id,
        ?string         $item_field,
        Model           $model
    ): bool {
        if (
            $locale_id
            && $item_id
        ) {
            return $model::where('locale_id', $locale_id)
                    ->where($item_field, $item_id)
                    ->count() > 0;
        }

        return false;
    }
}
