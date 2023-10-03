<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Observation",
 *     required={"capybara_id", "date", "city"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the observation"
 *     ),
 *     @OA\Property(
 *         property="capybara_id",
 *         type="integer",
 *         description="The ID of the observed capybara"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="The date of the observation"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="The city where the capybara was observed"
 *     ),
 *     @OA\Property(
 *         property="hat",
 *         type="boolean",
 *         description="Indicates if the capybara was wearing a hat"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the observation was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the observation was last updated"
 *     )
 * )
 */
class Observation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['date'];

    public function capybara(): BelongsTo
    {
        return $this->belongsTo(Capybara::class);
    }
}
