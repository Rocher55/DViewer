<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CID_ID
 * @property int $CID_Number
 * @property string $CID_Name
 * @property string $Definition
 * @property Patient[] $patients
 */
class Cid extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'CID_ID';

    /**
     * @var array
     */
    protected $fillable = ['CID_Number', 'CID_Name', 'Definition'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function patients()
    {
        return $this->belongsToMany('App\Patient', null, 'CID_ID', 'Patient_ID');
    }
}
