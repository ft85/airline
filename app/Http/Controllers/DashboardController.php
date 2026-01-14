<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Airline;
use App\Models\Invoice;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's statistics
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        $stats = [
            'today_tickets' => Ticket::whereDate('created_at', $today)->count(),
            'today_revenue' => Ticket::whereDate('created_at', $today)->sum('total_amount'),
            'month_tickets' => Ticket::whereDate('created_at', '>=', $thisMonth)->count(),
            'month_revenue' => Ticket::whereDate('created_at', '>=', $thisMonth)->sum('total_amount'),
            'total_tickets' => Ticket::count(),
            'total_revenue' => Ticket::sum('total_amount'),
            'active_airlines' => Airline::where('is_active', true)->count(),
            'pending_invoices' => Invoice::where('status', 'draft')->count()
        ];

        // Recent tickets
        $recentTickets = Ticket::with(['airline', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top airlines by revenue this month
        $topAirlines = Commission::select(
                'airlines.name',
                'airlines.code',
                DB::raw('COUNT(*) as ticket_count'),
                DB::raw('SUM(tickets.total_amount) as total_revenue')
            )
            ->join('airlines', 'commissions.airline_id', '=', 'airlines.id')
            ->join('tickets', 'commissions.ticket_id', '=', 'tickets.id')
            ->whereDate('commissions.commission_date', '>=', $thisMonth)
            ->groupBy('airlines.id', 'airlines.name', 'airlines.code')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentTickets', 'topAirlines'));
    }
}
