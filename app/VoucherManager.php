<?php


namespace App;


use App\Models\Agreement;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VoucherManager
{
    private ?Voucher $voucher;

    public function __construct(?Voucher $voucher = null)
    {
        $this->voucher = $voucher;
    }

    public function create(array $data, $agr){
        DB::transaction(function () use ($data, $agr) {
            $this->voucher=app(Voucher::class);
            $this->voucher->agreement=$agr;
            $this->voucher->transport = $data['transport'];
            $this->voucher->transfer = $data['transfer'];
            $this->voucher->save();
        });
    }
}
