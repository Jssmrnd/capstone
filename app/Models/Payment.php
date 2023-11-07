<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_application_id',  //
        'payment_status',           //p 
        'payment_type',             //
        'payment_amount',           // 2000.00
    ];

    public function makePayment(){
        dd($this->customerApplication());
    }


    public static function calculateMonthlyPayments():array{
        $monthlyPayments = DB::table('payments')
        ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'), DB::raw('SUM(payment_amount) as total'))
        ->whereYear('created_at', Carbon::now()->year) // Filter by the current year
        ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
        ->get();
        
        $monthlyTotals = array_fill(1, 12, 0);

        foreach ($monthlyPayments as $payment) {
            $year = $payment->year;
            $month = $payment->month;
            $total = $payment->total;    
            
            $monthlyTotals[$month] = $total;
        }

        return array_values($monthlyTotals);
    }


    public function customerApplication():BelongsTo{
        return $this->belongsTo(CustomerApplication::class);
    }
    
}
