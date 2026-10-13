<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisaController extends Controller
{
    public function index(Request $request)
    {
        $CusId = $request->input('CusId');

        // customer
        $customers = DB::table('customer')
            ->where('CusId', $CusId)
            ->get();

        // 該旅客已辦理的簽證種類
        $visas = DB::table('visatype2')
            ->where('CusId', $CusId)
            ->pluck('V1_Id')
            ->toArray();

        // 全部簽證種類
        $visaTypes = DB::table('visatype1')
            ->orderBy('V1_Id')
            ->get();

        // 性別
        $sexs = DB::table('sex')->get();

        // 票種
        $tickets = DB::table('tickettype')->get();

        // 已收證件
        $signs = DB::table('sign2')
            ->where('CusId', $CusId)
            ->pluck('S1_Id')
            ->toArray();

        // 全部證件類型
        $sign1s = DB::table('sign1')
            ->orderBy('S1_Id')
            ->get();

        // 證件進度
        $lists = DB::table('list')
            ->leftJoin('schedule', 'schedule.S_Id', '=', 'list.S_Id')
            ->leftJoin('window', 'window.W_Id', '=', 'list.window')
            ->where('list.CusId', $CusId)
            ->select(
                'list.*',
                'schedule.S_Name',
                'window.W_Name'
            )
            ->orderByDesc('list.L_date')
            ->orderByDesc('list.L_Id')
            ->get();

        // 進度品項
        $schedules = DB::table('schedule')
            ->orderBy('S_Id')
            ->get();

        // 窗口品項
        $windows = DB::table('window')
            ->orderBy('W_Id')
            ->get();

        return view('visa.index', compact(
            'customers',
            'visas',
            'visaTypes',
            'signs',
            'sign1s',
            'lists',
            'tickets',
            'sexs',
            'windows',
            'schedules',
            'CusId'
        ));
    }

    public function update(Request $request, $CusId)
    {
        DB::transaction(function () use ($request, $CusId) {

            // 更新 customer
            DB::table('customer')
                ->where('CusId', $CusId)
                ->update([
                    'Name'         => $request->input('Name'),
                    'EName'        => $request->input('EName'),
                    'ID'           => $request->input('ID'),
                    'Birthday'     => $request->input('Birthday'),
                    'Phone'        => $request->input('Phone'),
                    'TicketType'   => $request->input('TicketType'),
                    'Sex'          => $request->input('Sex'),
                    'Ps'           => $request->input('Ps'),
                    'PpNumber'     => $request->input('PpNumber'),
                    'PpDate'       => $request->input('PpDate'),
                    'PpDate1'      => $request->input('PpDate1'),
                    'TbNumber'     => $request->input('TbNumber'),
                    'TbDate'       => $request->input('TbDate'),
                    'CarNo'        => $request->input('CarNo'),
                    'CarNo2'       => $request->input('CarNo2'),
                    'StartPNR'     => $request->input('StartPNR'),
                    'StartETicket' => $request->input('StartETicket'),
                    'ComePNR'      => $request->input('ComePNR'),
                    'ComeETicket'  => $request->input('ComeETicket'),
                ]);

            // 更新 visatype2
            DB::table('visatype2')->where('CusId', $CusId)->delete();

            $visaTypes = $request->input('visa_types', []);
            foreach ($visaTypes as $visaType) {
                DB::table('visatype2')->insert([
                    'CusId' => $CusId,
                    'V1_Id' => $visaType,
                ]);
            }

            // 更新 sign2
            DB::table('sign2')->where('CusId', $CusId)->delete();

            $signTypes = $request->input('sign_types', []);
            foreach ($signTypes as $signType) {
                DB::table('sign2')->insert([
                    'CusId' => $CusId,
                    'S1_Id' => $signType,
                ]);
            }
        });

        return redirect()->route('visa.index', ['CusId' => $CusId]);
    }

    public function store(Request $request)
    {
        $CusId   = $request->input('CusId');
        $Exp     = $request->input('Exp', 0);
        $Income  = $request->input('Income', 0);
        $Income2 = $request->input('Income2', 0);
        $L_date  = $request->input('L_date');
        $Ps      = $request->input('Ps');
        $S_Id    = $request->input('schedule');
        $window  = $request->input('window');

        DB::table('list')->insert([
            'CusId'   => $CusId,
            'L_date'  => $L_date,
            'S_Id'    => $S_Id,
            'window'  => $window,
            'Ps'      => $Ps,
            'Income2' => $Income2,
            'Exp'     => $Exp,
            'Income'  => $Income,
        ]);

        return redirect()->route('visa.index', ['CusId' => $CusId]);
    }

    public function destroy(Request $request, $L_Id)
    {
        DB::table('list')->where('L_Id', $L_Id)->delete();

        $CusId = $request->input('CusId');

        return redirect()->route('visa.index', ['CusId' => $CusId]);
    }
}