<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

      $purchaseCount = Purchase::wheredate('updated_at', Carbon::today())->sum('total_amount');
    $purchaseCounty = Purchase::wheredate('updated_at', Carbon::yesterday())->sum('total_amount');

    $invoiceCount = Invoice::wheredate('updated_at', Carbon::today())->sum('total_amount');
    $invoiceCounty = Invoice::wheredate('updated_at', Carbon::yesterday())->sum('total_amount');

    // for total revenue
    $totalPurchases = Purchase::sum('paid_amount');
    $totalInvoices = Invoice::sum('paid_amount');
    $totalExpenses = Expense::sum('paid_amount');
    $subtotalRevenue = $totalInvoices-$totalPurchases;
    $totalRevenue = $subtotalRevenue - $totalExpenses;

    // revenue percentage
    $saleCount = Invoice::count('id');
    $pecentage = $subtotalRevenue / 100 * $saleCount;

    // expenses percentage
     $expensePer = $totalExpenses / 100 * $saleCount;

    // for table
    $unpaidInvoices = Invoice::where('due_amount', '!=', 0)->get();
    $unpaidInvoicesTotal = Invoice::sum('due_amount');

    $unpaidPurchases = Purchase::where('due_amount', '!=', 0)->get();
    $unpaidPurchasesTotal = Purchase::sum('due_amount');

    $unpaidExpenses = Expense::where('due_amount', '!=', 0)->get();
    $unpaidExpensesTotal = Expense::sum('due_amount');


    // sales purchase count
    $totalSales = Invoice::sum('paid_amount');
    $totalBuy = Purchase::sum('paid_amount');


    //charts

      // purchase chart
      $TotalPurchaseChart = Purchase::select('paid_amount', 'updated_at')->get()->groupBy(function($TotalPurchaseChart){
          return Carbon::parse($TotalPurchaseChart->updated_at)->format('M'); //  M means month
      });

      $months=[];
      $monthsCount=[];

      foreach($TotalPurchaseChart as $month=>$values){
          $months[]=$month;
          $monthsCount[]=count($values);
      };

      // Sales chart
      $TotalSalesChart = Invoice::select('paid_amount', 'updated_at')->get()->groupBy(function($TotalSalesChart){
        return Carbon::parse($TotalSalesChart->updated_at)->format('M'); //  M means month
      });

      $monthsSales=[];
      $monthsCountSales=[];

      foreach($TotalSalesChart as $month=>$values){
        $monthsSales[]=$month;
        $monthsCountSales[]=count($values);
      };


      return view('content.dashboard.dashboards-analytics',
      [
        'TotalPurchaseChart'=>$TotalPurchaseChart, 'months'=>$months, 'monthsCount'=>$monthsCount,
        'TotalSalesChart'=>$TotalSalesChart, 'monthsSales'=>$monthsSales, 'monthsCountSales'=>$monthsCountSales,
      ],
      compact(
        'purchaseCount',
        'purchaseCounty',
        'invoiceCount',
        'invoiceCounty',
        'totalInvoices',
        'totalRevenue',
        'totalExpenses',
        'expensePer',
        'pecentage',
        'unpaidInvoices',
        'unpaidInvoicesTotal',
        'unpaidPurchases',
        'unpaidPurchasesTotal',
        'unpaidExpenses',
        'unpaidExpensesTotal',
        'totalSales',
        'totalBuy'
      ));


    }

    public function report($type)
    {
        if ($type == 'invoice'){

            $reports = Invoice::all();

        }else{
            $reports = Purchase::all();
        }


        $page_title = 'Report';

        return view('report.index', compact('reports', 'page_title', 'type'));

    }


    public function cashierIndex(){
      return view('content.dashboard.cashier');
    }

}
