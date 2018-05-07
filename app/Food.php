<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $food_diaries_ID
 * @property int $WK_ID
 * @property int $Patient_ID
 * @property int $NB_Days
 * @property float $Valeur
 * @property int $Nomenclature_ID
 * @property int $Unite_Mesure_ID
 * @property Nomenclature $nomenclature
 * @property UniteMesure $uniteMesure
 */
class Food extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'food_diaries';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'food_diaries_ID';

    /**
     * @var array
     */
    protected $fillable = ['WK_ID', 'Patient_ID', 'NB_Days', 'Valeur', 'Nomenclature_ID', 'Unite_Mesure_ID'];

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
    public function uniteMesure()
    {
        return $this->belongsTo('App\UniteMesure', 'Unite_Mesure_ID', 'Unite_Mesure_ID');
    }
}
