<?php

namespace App\Http\Controllers\Saler;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $customer;
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
    public function index(Request $request)
    {
        // if(isset($request)){
        //     dd($request->all());
        // }
        $customers = $this->customer->filter_customsers($request->all());

        $status = [
            'total' => $this->customer->count(),
            'vip' => $this->customer->where('rank', 'vip')->count(),
            'blacklist' => $this->customer->where('rank', 'blacklist')->count(),
        ];

        return view('saler.manage-customers', compact('customers', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $this->customer->create($request->validated());
        return redirect()->route('customer.manage-customer')->with('success', 'Thêm khách hàng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Return customer data for ajax
        return response()->json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string',
            'email'       => 'nullable|email',
            'address'     => 'nullable|string',
            'gender'      => 'nullable|in:male,female',
            'nationality' => 'nullable|string',
            'citizen_id'  => 'nullable|string',
            'rank'        => 'required|in:normal,vip,blacklist',
            'status'      => 'required|in:active,locked',
            'note'        => 'nullable|string',
        ]);

        $customer->update($data);

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Soft delete or hard delete? Let's just update status/rank for now or delete if requested.
        // Usually, we don't delete customers with bookings.
        if ($customer->bookings()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa khách hàng đã có lịch sử đặt phòng!');
        }
        $customer->delete();
        return redirect()->back()->with('success', 'Xóa khách hàng thành công!');
    }
}
