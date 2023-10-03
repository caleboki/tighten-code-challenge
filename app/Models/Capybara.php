<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Capybara",
 *     required={"name", "color", "size"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier of the capybara"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the capybara"
 *     ),
 *     @OA\Property(
 *         property="color",
 *         type="string",
 *         description="The color of the capybara"
 *     ),
 *     @OA\Property(
 *         property="size",
 *         type="string",
 *         description="The size of the capybara"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the capybara was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the capybara was last updated"
 *     )
 * )
 */
class Capybara extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function observations(): HasMany
    {
        return $this->hasMany(Observation::class);
    }
}
