<?php

namespace WeAreFar\Ecommerce\Models;

use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model implements HasLocalePreference
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'email',
        'name',
        'locale',
    ];

    public function preferredLocale()
    {
        return $this->locale;
    }

    public function orders()
    {
        return $this->morphOne(Order::class, 'customer');
    }
}
