<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    //use custom response traits
    use HttpResponses;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //retrive all coupon
        $coupons = Coupon::all();
        return $this->success(['coupons' => $coupons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        //validate the form data
        $request->validated($request->all());

        $coupon = Coupon::create([
            'code' => $request->code,
            'type' => $request->type,
            'value' => $request->value,
            'expiry_date' => $request->expiry_date
        ]);

        if ($coupon == null) {
            return $this->error('', 'Unable to create coupone', 400);
        }

        return $this->success(['coupon' => $coupon]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //find the coupon details by id
        $coupon = Coupon::find($id);

        //check coupon is found
        if ($coupon == null) return $this->error('', 'Coupon not found', 404);

        //finally return the success response
        return $this->success(['coupon' => $coupon]);
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
    public function update(CouponRequest $request, $id)
    {
        //validate the request
        $request->validated($request->only(['code', 'type', 'value', 'expiry_date']));

        //find the coupon
        $coupon = Coupon::find($id);

        //check coupon is found or not. if not then return error response
        if ($coupon == null) return $this->error('', 'Coupon not found', 404);

        // if found update the data
        $coupon->update($request->all());
        // $coupon->code = $request->code;
        // $coupon->type = $request->type;
        // $coupon->value = $request->value;
        // $coupon->expiry_date = $request->expiry_date;
        // $coupon->save();

        //return the success response with update data;

        return $this->success(['coupon' => $coupon]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find the coupon
        $coupon = Coupon::find($id);

        //check coupon is found or not. if not then return error response
        if ($coupon == null) return $this->error('', 'Coupon not found', 404);

        //if found delete the coupon
        $coupon->delete();

        return $this->success('', 'Coupon deleted successfully');
    }
}
