<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Tổng doanh thu (chỉ tính các booking đã hoàn thành)
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');

        // 2. Tổng số lượt đặt phòng (tất cả trừ hủy)
        $totalBookings = Booking::where('status', '!=', 'canceled')->count();

        // 3. Số khách hàng
        $totalCustomers = Customer::count();

        // 4. Phòng được đặt nhiều nhất (Top 5)
        // Group by room_id, count occurrences, order by count desc
        $topRooms = Booking::select('room_id', DB::raw('count(*) as total'))
            ->where('status', '!=', 'canceled')
            ->groupBy('room_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('room') // Eager load room details
            ->get();

        // 5. Booking gần đây (Latest Bookings)
        $recentBookings = Booking::with(['customer', 'room'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('totalRevenue', 'totalBookings', 'totalCustomers', 'topRooms', 'recentBookings'));
    }
}
