<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Transaction;
use Auth;
use DataTables;
use Toastr;
use DB;

class TransactionController extends Controller
{
   // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    
    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()){
            $data = Transaction::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        // $btn = '<a href="'.route('transaction.edit',$row->id).'" class="btn btn-sm btn-primary"><i class="zmdi zmdi-edit"></i></a>';
                        // return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        

        return view('transaction.index');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::get();
        return view('transaction.create', compact('members'));    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_date'=>'required',
            'description'=>'required',
            'amount' =>'required|integer',
            
        ]);

        $transaction = new Transaction([
            'AccountId' => $request->get('member'),
            'TransactionDate' => $request->get('transaction_date'),
            'Description' => $request->get('description'),
            'Amount' => $request->get('amount'),
            'DebitCreditStatus' => $request->get('status'),
        ]);
        $transaction->save();

        $getPoint = $this->calculatePoint($transaction->Amount, $transaction->Description);

        $member = Member::find($transaction->AccountId);
        $member->Point =  $member->Point + $getPoint;
        $member->save();
       

        Toastr::success('Transaction Created','Success');
        return redirect('/transaction');
    }


    public function calculatePoint($amount, $description){
        switch($description){
            case "Bayar Listrik":
                switch ($amount) {
                    case  ($amount <= "50000"):
                       $point = 0;
                    break;
                    case ($amount >= "50001" && $amount <= "100000") :
                        $count = $amount / 2000;
                        $point = round($count) * 1;
                    break;
                    case  ($amount > "100000"):
                        $count = $amount / 2000;
                        $point = round($count) * 2;
                    break;
                }
            return $point;
            break;
            case "Beli Pulsa":
                switch ($amount) {
                    case  ($amount <= "10000"):
                       $point = 0;
                    break;
                    case ($amount >= "10001" && $amount <= "30000") :
                        $count = $amount / 1000;
                        $point = round($count) * 1;
                    break;
                    case  ($amount > "30000"):
                        $count = $amount / 1000;
                        $point = round($count) * 2;
                    break;
                }
            return $point;
            break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction = Transaction::find($id);
        return view('transaction.edit', compact('transaction'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        
        return json_encode([
          "success" => true,
          "msg" => "The transaction has been successfully removed"
        ]);
        //return redirect('/contacts')->with('success', 'Contact deleted m8!');
    }

    public function report(){
        $members = Member::get();
        $transactions = '';
        return view('transaction.report', compact('members','transactions')); 
    }
    public function generateReport(Request $request){
        $request->validate([
            'member'=>'required',
            'transaction_date_start'=>'required',
            'transaction_date_end' =>'required',
            
        ]);
        $uid = $request->get('member');
        $date_from = $request->get('transaction_date_start');
        $date_to = $request->get('transaction_date_end');
        $members = Member::get();
        $transactions = Transaction::with('memberData')
                        ->where('AccountId', $uid)
                        ->whereBetween('TransactionDate', [$date_from, $date_to])
                        ->get();

        // $transactions = DB::statement('
        // SELECT AccountId
        //     , SUM(COALESCE(CASE WHEN DebitCreditStatus = 'D' THEN Amount END,0)) total_debits
        //     , SUM(COALESCE(CASE WHEN DebitCreditStatus = 'C' THEN Amount END,0)) total_credits
        //     , SUM(COALESCE(CASE WHEN DebitCreditStatus = 'D' THEN Amount END,0)) 
        //     - SUM(COALESCE(CASE WHEN DebitCreditStatus = 'C' THEN Amount END,0)) balance 
        // FROM transactions 
        // GROUP  
        //     BY AccountId
        // HAVING balance <> 0;

        // ');

       // dd($transactions);
        return view('transaction.report', compact('members','transactions')); 

    }
}
