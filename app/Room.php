<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Room
 *
 * @property int $id
 * @property string $number
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Appointment[] $appointments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Room whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Room extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'room_id', 'id');
    }

    /**
     * Given a date grab all appointments in this room
     *
     * @param Carbon|null $at
     * @param string|null $type
     *
     * @return Collection|Availability[]
     */
    public function apointments_on(Carbon $at = null, $type = null)
    {
        return $this->appointments()->between($at, $type)->get();
    }

    /**
     * Given a date checks room is available for use
     *
     * @param Carbon|null $at
     * @param string|null $type
     *
     * @return bool
     */
    public function available_on(Carbon $at = null, $type = null): bool
    {
        return $this->apointments_on($at, $type)->isEmpty();
    }
}
