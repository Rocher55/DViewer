<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $biochemistry_ID
 * @property int $CID_ID
 * @property int $Patient_ID
 * @property string $Date_Bio
 * @property float $Valeur
 * @property int $Nomenclature_ID
 * @property int $Unite_Mesure_ID
 * @property CidPatient $cidPatient
 * @property Nomenclature $nomenclature
 * @property CidPatient $cidPatient
 * @property UniteMesure $uniteMesure
 */
class Biochemistry extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'biochemistry';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'biochemistry_ID';

    /**
     * @var array
     */
    protected $fillable = ['CID_ID', 'Patient_ID', 'Date_Bio', 'Valeur', 'Nomenclature_ID', 'Unite_Mesure_ID'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cid()
    {
        return $this->belongsTo('App\CidPatient', 'CID_ID', 'CID_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nomenclature()
    {
        return $this->belongsTo('App\Nomenclature', 'Nomenclature_ID', 'Nomenclature_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\CidPatient', 'Patient_ID', 'Patient_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function uniteMesure()
    {
        return $this->belongsTo('App\UniteMesure', 'Unite_Mesure_ID', 'Unite_Mesure_ID');
    }
}
