<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use Auth;
use DataTables;
use Toastr;

class MemberController extends Controller
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
        //$get_contact = Contact::with('ownerData')->get();
        //dd($get_contact);
        
        if ($request->ajax()){
            $data = Member::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $btn = '<a href="'.route('member.edit',$row->id).'" class="btn btn-sm btn-primary"><i class="zmdi zmdi-edit"></i></a>';
                        $btn .= '<a href="javascript:void()" data-id="'.$row->id.'" data-name="'.$row->Name.'" class="btn btn-sm btn-danger rm-contact" style="margin-left:10px;"><i class="zmdi zmdi-delete"></i></a>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        

        return view('member.index');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('member.create');
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
            'name'=>'required',
        ]);

        $member = new Member([
            'Name' => $request->get('name'),
            'Point' => 0,
        ]);
        $member->save();
        Toastr::success('Member Created','Success');
        return redirect('/member');
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
        $member = Member::find($id);
        return view('member.edit', compact('member'));        
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
        $request->validate([
            'name'=>'required',
            // 'email'=>'required|email|unique:App\Contact,email'
        ]);

        $member = Member::find($id);
        $member->Name =  $request->get('name');
        $member->save();
         
        Toastr::success('Member Updated','Success');
        return redirect('/member');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();
        
        return json_encode([
          "success" => true,
          "msg" => "The member has been successfully removed"
        ]);
        //return redirect('/contacts')->with('success', 'Contact deleted m8!');
    }
}
