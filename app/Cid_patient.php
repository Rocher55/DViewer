<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $CID_ID
 * @property int $Patient_ID
 * @property Cid $cid
 * @property Patient $patient
 * @property Biochemistry[] $biochemistries
 * @property Biochemistry[] $biochemistries
 * @property PhysicalActivity[] $physicalActivities
 * @property PhysicalActivity[] $physicalActivities
 */
class Cid_patient extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cid_patient';

    /**
     * @var array
     */
    protected $fillable = ['CID_ID', 'Patient_ID'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cid()
    {
        return $this->belongsTo('App\Cid', 'CID_ID', 'CID_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient', 'Patient_ID', 'Patient_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function biochemistries_cid()
    {
        return $this->hasMany('App\Biochemistry', 'CID_ID', 'CID_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function biochemistries_patient()
    {
        return $this->hasMany('App\Biochemistry', 'Patient_ID', 'Patient_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function physicalActivities_patient()
    {
        return $this->hasMany('App\PhysicalActivity', 'Patient_ID', 'Patient_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function physicalActivities_cid()
    {
        return $this->hasMany('App\PhysicalActivity', 'Cid_ID', 'CID_ID');
    }
}
