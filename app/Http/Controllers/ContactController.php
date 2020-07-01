<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Auth;
use DataTables;
use Toastr;

class ContactController extends Controller
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
            $data = Contact::with('ownerData')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $btn = '<a href="'.route('contacts.edit',$row->id).'" class="btn btn-sm btn-primary"><i class="zmdi zmdi-edit"></i></a>';
                        $btn .= '<a href="javascript:void()" data-id="'.$row->id.'" data-name="'.$row->first_name.'" class="btn btn-sm btn-danger rm-contact" style="margin-left:10px;"><i class="zmdi zmdi-delete"></i></a>';
                        return $btn;
                })
                ->editColumn('owner', function($row){
                    $v = $row->ownerData['name'];
                     return $v;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        //return view('contacts.index',compact($data));

        return view('contacts.index');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
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
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:App\Contact,email'
        ]);

        $contact = new Contact([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'job_title' => $request->get('job_title'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'owner' => Auth::user()->id
        ]);
        $contact->save();
        Toastr::success('Contact Created','Success');
        return redirect('/contacts');
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
        $contact = Contact::find($id);
        return view('contacts.edit', compact('contact'));        
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
            'first_name'=>'required',
            'last_name'=>'required',
            // 'email'=>'required|email|unique:App\Contact,email'
        ]);

        $contact = Contact::find($id);
        $contact->first_name =  $request->get('first_name');
        $contact->last_name = $request->get('last_name');
        //$contact->email = $request->get('email');
        $contact->job_title = $request->get('job_title');
        $contact->city = $request->get('city');
        $contact->country = $request->get('country');
        $contact->save();
         
        Toastr::success('Contact Updated','Success');
        return redirect('/contacts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        
        return json_encode([
          "success" => true,
          "msg" => "The contact has been successfully removed"
        ]);
        //return redirect('/contacts')->with('success', 'Contact deleted m8!');
    }
}
