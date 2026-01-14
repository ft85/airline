<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Ticket;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $commissions = Commission::with(['ticket', 'airline', 'user'])
            ->orderBy('commission_date', 'desc')
            ->paginate(20);
        
        return view('commissions.index', compact('commissions'));
    }

    public function customerReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $customerCommissions = Commission::select(
                'tickets.client_name',
                DB::raw('COUNT(*) as ticket_count'),
                DB::raw('SUM(commissions.commission_amount) as total_commission'),
                DB::raw('SUM(commissions.supplier_amount) as total_supplier_amount'),
                DB::raw('SUM(commissions.company_amount) as total_company_amount'),
                DB::raw('SUM(tickets.total_amount) as total_revenue')
            )
            ->join('tickets', 'commissions.ticket_id', '=', 'tickets.id')
            ->whereBetween('commissions.commission_date', [$startDate, $endDate])
            ->groupBy('tickets.client_name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        return view('commissions.customer-report', compact('customerCommissions', 'startDate', 'endDate'));
    }

    public function airlineReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $airlineCommissions = Commission::select(
                'airlines.name as airline_name',
                'airlines.code as airline_code',
                DB::raw('COUNT(*) as ticket_count'),
                DB::raw('SUM(commissions.commission_amount) as total_commission'),
                DB::raw('SUM(commissions.supplier_amount) as total_supplier_amount'),
                DB::raw('SUM(commissions.company_amount) as total_company_amount'),
                DB::raw('SUM(tickets.total_amount) as total_revenue'),
                DB::raw('AVG(commissions.commission_percentage) as avg_commission_rate')
            )
            ->join('airlines', 'commissions.airline_id', '=', 'airlines.id')
            ->join('tickets', 'commissions.ticket_id', '=', 'tickets.id')
            ->whereBetween('commissions.commission_date', [$startDate, $endDate])
            ->groupBy('airlines.id', 'airlines.name', 'airlines.code')
            ->orderBy('total_revenue', 'desc')
            ->get();

        return view('commissions.airline-report', compact('airlineCommissions', 'startDate', 'endDate'));
    }

    public function dailyReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $dailyCommissions = Commission::select(
                DB::raw('DATE(commissions.commission_date) as report_date'),
                DB::raw('COUNT(*) as ticket_count'),
                DB::raw('SUM(commissions.commission_amount) as total_commission'),
                DB::raw('SUM(commissions.supplier_amount) as total_supplier_amount'),
                DB::raw('SUM(commissions.company_amount) as total_company_amount'),
                DB::raw('SUM(tickets.total_amount) as total_revenue')
            )
            ->join('tickets', 'commissions.ticket_id', '=', 'tickets.id')
            ->whereBetween('commissions.commission_date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(commissions.commission_date)'))
            ->orderBy('report_date', 'desc')
            ->get();

        // Calculate totals
        $totals = [
            'ticket_count' => $dailyCommissions->sum('ticket_count'),
            'total_commission' => $dailyCommissions->sum('total_commission'),
            'total_supplier_amount' => $dailyCommissions->sum('total_supplier_amount'),
            'total_company_amount' => $dailyCommissions->sum('total_company_amount'),
            'total_revenue' => $dailyCommissions->sum('total_revenue')
        ];

        return view('commissions.daily-report', compact('dailyCommissions', 'totals', 'startDate', 'endDate'));
    }

    public function incomeReport(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth());

        $incomeData = Commission::select(
                DB::raw('SUM(tickets.total_amount) as total_income'),
                DB::raw('SUM(commissions.supplier_amount) as amount_to_suppliers'),
                DB::raw('SUM(commissions.company_amount) as company_profit'),
                DB::raw('COUNT(*) as total_tickets')
            )
            ->join('tickets', 'commissions.ticket_id', '=', 'tickets.id')
            ->whereBetween('commissions.commission_date', [$startDate, $endDate])
            ->first();

        // Breakdown by airline
        $airlineBreakdown = Commission::select(
                'airlines.name as airline_name',
                DB::raw('SUM(tickets.total_amount) as airline_income'),
                DB::raw('SUM(commissions.supplier_amount) as amount_to_supplier'),
                DB::raw('SUM(commissions.company_amount) as company_profit'),
                DB::raw('COUNT(*) as ticket_count')
            )
            ->join('airlines', 'commissions.airline_id', '=', 'airlines.id')
            ->join('tickets', 'commissions.ticket_id', '=', 'tickets.id')
            ->whereBetween('commissions.commission_date', [$startDate, $endDate])
            ->groupBy('airlines.id', 'airlines.name')
            ->get();

        return view('commissions.income-report', compact('incomeData', 'airlineBreakdown', 'startDate', 'endDate'));
    }

    public function show(Commission $commission)
    {
        $commission->load(['ticket', 'airline', 'user']);
        return view('commissions.show', compact('commission'));
    }
}
