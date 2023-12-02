<?php

namespace App\Models;

use App\Enum\CurrencyTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasImpactor;

class SystemCurrency extends BaseModel
{
    use Activatable;
    use HasImpactor;

    public const CACHE_TAG = 'system-currency';

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'key',
        'type',
        'name',
        'code',
        'symbol',
        'decimals',
        'status',
        'is_default',
        'is_base',
        'order',
        'usable',
    ];

    public function getTypeNameAttribute()
    {
        return CurrencyTypeEnum::findConstantLabel($this->type);
    }

    public function isFiat()
    {
        return $this->type == CurrencyTypeEnum::FIAT;
    }

    public function __toString()
    {
        return $this->getKey();
    }

    /**
     * Always use key column as currency code when reference to another table
     */
    public function getCurrencyCode()
    {
        return $this->getKey();
    }

    public function scopeOrdered($q)
    {
        return $q->orderByRaw('ISNULL(`order`), `order` ASC');
    }
}
