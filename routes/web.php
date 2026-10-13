<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TrafficController;
use App\Http\Controllers\LocaltsController;
use App\Http\Controllers\HotelOrderListController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BusListController;
use App\Http\Controllers\FinalPayController;
use App\Http\Controllers\TbillController;
use App\Http\Controllers\GbillController;
use App\Http\Controllers\Gbill2Controller;
use App\Http\Controllers\VbillController;
use App\Http\Controllers\ReceController;
use App\Http\Controllers\OrderSearchController;
use App\Http\Controllers\BudaiController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\LongDistanceController;
use App\Http\Controllers\ShortDistanceController;
use App\Http\Controllers\ShortDistance2Controller;
use App\Http\Controllers\OrderMoreController;
use App\Http\Controllers\SearchHotelController;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\PrintCusController;
use App\Http\Controllers\CusSelectController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketWorkController;
use App\Http\Controllers\VisaOnlyController;
use App\Http\Controllers\VisaSearchController;
use App\Http\Controllers\TempOrderController;
use App\Http\Controllers\TempOrder2Controller;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CarinfoController;
use App\Http\Controllers\CHotelOrderController;
use App\Http\Controllers\CustomerInquiryController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\GuestbookController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('accountsma', AccountsController::class);
    Route::resource('guestbook', GuestbookController::class);
    Route::resource('location', LocationController::class);
    Route::resource('carinfo', CarinfoController::class);
    Route::resource('schedulema', ScheduleController::class);
    Route::resource('trafficma', TrafficController::class);
    Route::resource('localts', LocaltsController::class);
    Route::resource('hotelorderlist', HotelOrderListController::class);
    Route::resource('mbill', BillController::class);
    Route::resource('buslist', BusListController::class);
    Route::resource('finalpay', FinalPayController::class);
    Route::resource('tbill', TbillController::class);
    Route::resource('rece', ReceController::class);
    Route::resource('hotellist', HotelController::class)->except(['show']);
    Route::resource('longdistance', LongDistanceController::class);
    Route::resource('shortdistance', ShortDistanceController::class);
    Route::resource('shortdistance2', ShortDistance2Controller::class);
    Route::resource('ordermore', OrderMoreController::class);
    Route::resource('visa', VisaController::class);
    Route::resource('visaonly', VisaOnlyController::class);
    Route::resource('flight', FlightController::class);
    Route::resource('temporder', TempOrderController::class);
    Route::resource('temporder2', TempOrder2Controller::class);
    Route::resource('group', GroupController::class);
    Route::resource('chotelorder', CHotelOrderController::class);
    Route::resource('cusselect', CusSelectController::class);
    Route::resource('customer_inquiries', CustomerInquiryController::class)->except(['show']);

    Route::post('tbill/{id}/editmoney', [TbillController::class, 'editmoney'])->name('tbill.editmoney');

    Route::resource('ordersearche', OrderSearchController::class);
    Route::get('ordersearch', [OrderSearchController::class, 'index'])->name('ordersearch.index');

    Route::get('visasearch', [VisaSearchController::class, 'index'])->name('visasearch.index');
    Route::get('/budai', [BudaiController::class, 'index'])->name('budai.index');
    Route::get('/output', [OutputController::class, 'index'])->name('output.index');

    Route::get('/gbill', [GbillController::class, 'index'])->name('gbill');
    Route::get('/gbill2', [Gbill2Controller::class, 'index'])->name('gbill2');
    Route::get('/vbill', [VbillController::class, 'index'])->name('vbill');

    Route::post('/ordermore/import/{OrderId}/{date}', [OrderMoreController::class, 'import'])->name('ordermore.import');
    Route::post('/flight/renew', [FlightController::class, 'renew'])->name('flight.renew');

    Route::get('/search-continent', [SearchHotelController::class, 'SearchHotelWithoutContinent'])->name('search-continent-no-param');
    Route::get('/search-hotel/{ContinentID}', [SearchHotelController::class, 'SearchHotel'])->name('search-continent');

    Route::get('/printcus', [PrintCusController::class, 'index'])->name('printcus.index');

    Route::get('/ticket', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/ticket/index2', [TicketController::class, 'index2'])->name('ticket.index2');
    Route::post('/ticket', [TicketController::class, 'store'])->name('ticket.store');
    Route::put('/ticket/{id}', [TicketController::class, 'update'])->name('ticket.update');
    Route::delete('/ticket/{id}', [TicketController::class, 'destroy'])->name('ticket.destroy');

    Route::post('/ticketwork/step_one', [TicketWorkController::class, 'step_one'])->name('ticketwork.step_one');
    Route::post('/ticketwork/step_final', [TicketWorkController::class, 'step_final'])->name('ticketwork.step_final');

    Route::middleware('permission:1')->group(function () {
        Route::resource('usermanage', UserManageController::class)->except(['show']);
    });

    Route::fallback(function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
    });

});