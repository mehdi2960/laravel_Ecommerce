<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons=Coupon::latest()->paginate(20);
        return view('admin.coupons.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons.create');
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
            'code'=>'required|unique:coupons,code',
            'type'=>'required',
            'amount'=>'required_if:type,=,amount',
            'percentage'=>'required_if:type,=,percentage',
            'max_percentage_amount'=>'required_if:type,=,percentage',
            'expired_at'=>'required'
        ]);

        Coupon::create([
            'name'=>$request->name,
            'code'=>$request->code,
            'type'=>$request->type,
            'amount'=>$request->amount,
            'percentage'=>$request->percentage,
            'max_percentage_amount'=>$request->max_percentage_amount,
            'expired_at'=>convertShamsiToGregorianDate($request->expired_at)
        ]);

        alert()->success('کوپن موردنظر ایجاد شد', 'باتشکر');
        return redirect()->route('admin.coupons.index');
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
        //
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
        //
    }
}
