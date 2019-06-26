<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Center_ID
 * @property int $Protocol_ID
 * @property Center $center
 * @property Patient[] $patients
 * @property Protocol $protocol
 */
class Center_protocol extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'center_protocol';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function center()
    {
        return $this->hasOne('App\Center', 'Center_ID', 'Center_ID');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function protocol()
    {
        return $this->hasOne('App\Protocol', 'Protocol_ID', 'Protocol_ID');
    }
}
