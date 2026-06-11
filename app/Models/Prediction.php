<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $fillable = [
        'type', 'filename',
        'gender', 'age', 'married', 'dependents',
        'tenure', 'phone_service', 'internet_service',
        'monthly_charge', 'total_charges',
        'prediction_result', 'probability',
        'total_data', 'churn_count', 'nonchurn_count', 'churn_rate'
    ];
}