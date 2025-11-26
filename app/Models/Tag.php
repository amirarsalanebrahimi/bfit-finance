<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    const string TYPE_INCOME = 'INCOME';
    const string TYPE_EXPENSE = 'EXPENSE';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'color',
        'description'
    ];

    /**
     * Get category transactions
     * @return HasMany
     */
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'tag_transaction');
    }

    /**
     * Add query scope to get incomes
     * @param $query
     * @return mixed
     */
    public function scopeIncome($query) : mixed
    {
        return $query->where('type', self::TYPE_INCOME);
    }

    /**
     * Add query scope to get expenses
     * @param $query
     * @return mixed
     */
    public function scopeExpense($query) : mixed
    {
        return $query->where('type', self::TYPE_EXPENSE);
    }
}
