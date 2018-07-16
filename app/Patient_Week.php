<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $WK_ID
 * @property int $Patient_ID
 * @property Patient $patient
 * @property Week $week
 */
class Patient_Week extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'patient_week';

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['WK_ID', 'Patient_ID'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Patient', 'Patient_ID', 'Patient_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function week()
    {
        return $this->belongsTo('App\Week', 'WK_ID', 'WK_ID');
    }
}
