<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelIgnition\FlareMiddleware\AddJobs;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = ['foreign_table', 'foreign_id', 'postal_code', 'state', 'city', 'sublocality', 'street', 'street_number', 'complement'];
    public $timestamps = false;

    public function store()
    {
        return $this->belongsTo(Store::class, 'foreign_id');
    }

    public static function getAll()
    {
        $results = DB::table('addresses')
            ->join('stores', 'stores.id', '=', 'addresses.foreign_id')
            ->select(
                'stores.id as store_id',
                'stores.name as store_name',
                'addresses.*',
            )
            ->get();
        return response()->json($results);
    }
}
