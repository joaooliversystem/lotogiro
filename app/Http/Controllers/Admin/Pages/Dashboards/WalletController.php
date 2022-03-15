<?php

    namespace App\Http\Controllers\Admin\Pages\Dashboards;

    use App\Helper\Money;
    use App\Http\Controllers\Controller;
    use App\Models\RechargeOrder;
    use App\Models\TransactBalance;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;

    class WalletController extends Controller
    {
        public function index()
        {
            return view('admin.pages.dashboards.wallet.index');
        }
        public function convert()
        {
            return view('admin.pages.dashboards.wallet.convert');
        }
        public function recharge()
        {
            return view('admin.pages.dashboards.wallet.recharge');
        }
        public function transfer()
        {
            return view('admin.pages.dashboards.wallet.transfer');
        }
        public function withdraw()
        {
            return view('admin.pages.dashboards.wallet.withdraw');
        }
        public function extract()
        {
            return view('admin.pages.dashboards.wallet.extract');
        }
        public function withdrawList()
        {
            return view('admin.pages.dashboards.wallet.admin-list');
        }
        public function rechargeOrder()
        {
            return view('admin.pages.dashboards.wallet.recharge-order');
        }
        public function orderDetail()
        {
            return view('admin.pages.dashboards.wallet.order-detail');
        }
        public function thanks()
        {
            return view('admin.pages.dashboards.wallet.thanks');
        }
        public function updateStatusPayment(Request $request)
        {
            $typeStatus = [
                'pending' => 0,
                'approved' => 1,
                'failure' => 3
            ];

            if(!$request->has('status')){
                return response()->json(['status' => 403]);
            }

            if($request->status !== 'null'){
                $reference = $request->external_reference;
                $rechargeOrder = RechargeOrder::where('reference', $reference)->get();
                $user = User::find($rechargeOrder->first()->user_id);

                if($rechargeOrder->contains('status', 1) || $rechargeOrder->contains('status', 2)){
                    return response()->json(['status' => 403]);
                }

                if($typeStatus[$request->status] === 0){
                    return response()->json(['status' => 200]);
                }

                if($typeStatus[$request->status] !== 0){
                    $newRechargeOrder = $rechargeOrder->first()->replicate();
                    $newRechargeOrder->status = $typeStatus[$request->status];
                    $newRechargeOrder->push();

                    $commission = 0;
                    $totalRecharge = $newRechargeOrder->value;
                    $msgCommission = "";
                    if($user->commission > 0){
                        $commission = $newRechargeOrder->value * ($user->commission/100);
                        $totalRecharge = $newRechargeOrder->value + $commission;
                        $msgCommission = "Mais {$user->commission}% de comissão.";
                    }

                    if($typeStatus[$request->status] === 1){
                        TransactBalance::create([
                            'user_id_sender' => 759,
                            'user_id' => $user->id,
                            'value' => $totalRecharge,
                            'old_value' => $user->balance,
                            'type' => "Recarga efetuada por meio da plataforma. {$msgCommission}"
                        ]);

                        $user->balance += $newRechargeOrder->value + $commission;
                        $user->save();
                    }

                    return response()->json(['status' => 201]);
                }
            }
            return response()->json(['status' => 403]);
        }
    }
