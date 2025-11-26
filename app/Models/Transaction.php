<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    const string TYPE_INCOME = 'INCOME';
    const string TYPE_EXPENSE = 'EXPENSE';
    const string METHOD_POSE = 'POSE';
    const string METHOD_CARD = 'CARD';
    const string METHOD_ONLINE = 'ONLINE';
    const string METHOD_CASH = 'CASH';
    const string METHOD_BANK = 'BANK';
    const string METHOD_CHECK = 'CHECK';
    const string METHOD_OTHERS = 'OTHERS';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'amount',
        'date',
        'reference_number',
        'payee_payer',
        'description',
        'payment_method',
        'status'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'amount' => 'decimal:2'
        ];
    }

    /**
     * Get related user
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get related category
     */
    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_transaction');
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

    /**
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function scopeDateRange($query, $startDate, $endDate) : mixed
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}
