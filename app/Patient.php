<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $Patient_ID
 * @property string $SUBJID
 * @property string $SUBJINIT
 * @property int $Protocol_ID
 * @property int $Center_ID
 * @property string $Class
 * @property int $Sex
 * @property int $Age
 * @property float $Height (m)
 * @property string $Birth_Date
 * @property string $Race
 * @property int $Family_ID
 * @property int $Family_Structure
 * @property int $Female premenopausal
 * @property string $Female use Oral contraceptives
 * @property string $Type_Contraceptive
 * @property string $Mother urine pregnant
 * @property int $Parents eligible for inclusion
 * @property int $Eating disorder
 * @property string $Eating disorder comment
 * @property string $Alcohol or drug abuse
 * @property int $Drink alcohol
 * @property int $Alcohol(WK)
 * @property string $Concomitant condition
 * @property int $Cigarettes-Pipes/year
 * @property int $EER
 * @property CenterProtocol $centerProtocol
 * @property CenterProtocol $centerProtocol
 * @property Cid[] $cids
 * @property Week[] $weeks
 */
class Patient extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'Patient_ID';

    /**
     * @var array
     */
    protected $fillable = ['SUBJID', 'SUBJINIT', 'Protocol_ID', 'Center_ID', 'Class', 'Sex', 'Age', 'Height (m)', 'Birth_Date', 'Race', 'Family_ID', 'Family_Structure', 'Female premenopausal', 'Female use Oral contraceptives', 'Type_Contraceptive', 'Mother urine pregnant', 'Parents eligible for inclusion', 'Eating disorder', 'Eating disorder comment', 'Alcohol or drug abuse', 'Drink alcohol', 'Alcohol(WK)', 'Concomitant condition', 'Cigarettes-Pipes/year', 'EER'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function centerProtocol()
    {
        return $this->belongsTo('App\CenterProtocol', 'Center_ID', 'Center_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function protocolCenter()
    {
        return $this->belongsTo('App\CenterProtocol', 'Protocol_ID', 'Protocol_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cids()
    {
        return $this->belongsToMany('App\Cid', null, 'Patient_ID', 'CID_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function weeks()
    {
        return $this->belongsToMany('App\Week', null, 'Patient_ID', 'WK_ID');
    }
}
