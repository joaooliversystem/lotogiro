<?php

    use App\Http\Controllers\Admin\Pages\Auth\RegisterController;
    use App\Http\Controllers\Admin\Pages\Dashboards\WalletController;
    use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Pages\Auth\LoginController;
use App\Http\Controllers\Admin\Pages\HomeController;
use App\Http\Controllers\Admin\Pages\Settings\UserController;
use App\Http\Controllers\Admin\Pages\Settings\PermissionController;
use App\Http\Controllers\Admin\Pages\Settings\RoleController;
use App\Http\Controllers\Admin\Pages\Bets\ClientController;
use App\Http\Controllers\Admin\Pages\Bets\CompetitionController;
use App\Http\Controllers\Admin\Pages\Bets\TypeGameController;
use App\Http\Controllers\Admin\Pages\Bets\TypeGameValueController;
use App\Http\Controllers\Admin\Pages\Bets\GameController;
use App\Http\Controllers\Admin\Pages\Bets\ValidateGamesController;
use App\Http\Controllers\Admin\Pages\Bets\DrawController;
use App\Http\Controllers\Admin\Pages\Dashboards\SaleController;
use App\Http\Controllers\Admin\Pages\Dashboards\ReportDayController;
use App\Http\Controllers\Admin\Pages\Dashboards\GainController;
use App\Http\Controllers\Admin\Pages\Dashboards\ExtractController;
use App\Http\Controllers\Admin\Pages\Bets\PaymentController;

// recuperar senha controller
use App\Http\Controllers\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// rotas para recuperar senha
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/', [LoginController::class, 'showLoginForm']);
Route::get('/admin/indicate/{indicate?}', [RegisterController::class, 'registerIndicate'])->name('indicateRegister');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::get('/updateStatusPaymentCron/2de1ce3ddcb20dda6e6ea9fba8031de4/', [WalletController::class, 'updateStatusPayment'])->name('updateStatusPaymentCron');

Route::get('/', [LoginController::class, 'showLoginForm'])->middleware('guest:admin');

Route::middleware('guest:web')->group(function () {
    Route::prefix('games')->name('games.')->group(function () {
        Route::get('/{user}/{bet?}', [\App\Http\Controllers\Site\Pages\Bets\GameController::class, 'betIndex'])->name('bet');
        Route::post('/{user}/store', [\App\Http\Controllers\Site\Pages\Bets\GameController::class, 'betStore'])->name('bet.store');
        Route::post('/{user}/{bet?}/update', [\App\Http\Controllers\Site\Pages\Bets\GameController::class, 'betUpdate'])->name('bet.update');
        Route::get('/{user}/{bet}/{typeGame}/game-create', [\App\Http\Controllers\Site\Pages\Bets\GameController::class, 'gameCreate'])->name('bet.game.create');
    });
});

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('get.login');
        Route::post('/login', [LoginController::class, 'login'])->name('post.login');
    });
    Route::middleware(['auth:admin', 'check.openModal'])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::prefix('dashboards')->name('dashboards.')->group(function () {
            Route::prefix('sales')->name('sales.')->group(function () {
                Route::get('/', [SaleController::class, 'index'])->name('index');
            });
            Route::prefix('Reportday')->name('Reportday.')->group(function () {
                Route::get('/', [ReportDayController::class, 'index'])->name('index');
                Route::get('/FiltroEspecifico/{slug}', [ReportDayController::class, 'getFiltro'])->name('getFiltro');
                Route::post('/filtro-especifico', [ReportDayController::class, 'FiltroEspecifico'])->name('filtro-especifico');
            });
            Route::prefix('gains')->name('gains.')->group(function () {
                Route::get('/', [GainController::class, 'index'])->name('index');
            });
            Route::prefix('extracts')->name('extracts.')->group(function () {
                Route::get('/', [ExtractController::class, 'index'])->name('index');
                Route::get('/sales', [ExtractController::class, 'sales'])->name('sales');
                Route::get('/manual-recharge', [ExtractController::class, 'manualRecharge'])->name('manualRecharge');
            });


            Route::prefix('wallet')->name('wallet.')->group(function () {
                Route::get('/', [WalletController::class, 'index'])->name('index');
                Route::get('/convert', [WalletController::class, 'convert'])->name('convert');
                Route::get('/recharge', [WalletController::class, 'recharge'])->name('recharge');
                Route::get('/transfer', [WalletController::class, 'transfer'])->name('transfer');
                Route::get('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw');
                Route::get('/extract', [WalletController::class, 'extract'])->name('extract');
                Route::get('/withdraw-list', [WalletController::class, 'withdrawList'])->name('withdraw-list');
                Route::get('/recharge-order', [WalletController::class, 'rechargeOrder'])->name('recharge-order');
                Route::get('/order-detail/{id}', [WalletController::class, 'orderDetail'])->name('order-detail');
                Route::get('/updateStatusPayment/2de1ce3ddcb20dda6e6ea9fba8031de4/', [WalletController::class, 'updateStatusPayment'])->name('updateStatusPayment');
                Route::get('/thanks/', [WalletController::class, 'thanks'])->name('thanks');
            });
        });
        Route::prefix('/bets')->name('bets.')->group(function () {
            Route::resource('clients', ClientController::class);
            Route::resource('competitions', CompetitionController::class);
            Route::resource('type_games', TypeGameController::class);
            Route::resource('type_games.values', TypeGameValueController::class);
            Route::get('/games/create-link', [GameController::class, 'createLink'])->name('games.link');
            Route::get('/games/receipt/{game}/{format}/{prize?}', [GameController::class, 'getReceipt'])->name('games.receipt');
            Route::get('/games/receiptTudo/{idcliente}', [GameController::class, 'getReceiptTudo'])->name('games.receiptTudo');
            Route::get('/games/receiptTudoTxt/{idcliente}', [GameController::class, 'getReceiptTudoTxt'])->name('games.getReceiptTudoTxt');
            Route::get('/games/{type_game}', [GameController::class, 'index'])->name('games.index');
            Route::get('games/carregarjogo/{type_game}', [GameController::class, 'carregarJogo'])->name('games.carregarjogo');
            Route::get('/games/create/{type_game}', [GameController::class, 'create'])->name('games.create');
            Route::resource('games', GameController::class)->except([
                'index', 'create'
            ]);
            Route::resource('draws', DrawController::class);
            Route::get('report-draws/{type}', [DrawController::class, 'reportDraws'])->name('report-draws');
            Route::resource('validate-games', ValidateGamesController::class)->except([
                'store'
            ]);;
            Route::prefix('payments')->name('payments.')->group(function () {
                Route::prefix('commissions')->name('commissions.')->group(function () {
                    Route::get('/', [PaymentController::class, 'commissionIndex'])->name('index');
                });
                Route::prefix('draws')->name('draws.')->group(function () {
                    Route::get('/', [PaymentController::class, 'drawIndex'])->name('index');
                });
            });
        });
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::resource('users', UserController::class);
            Route::get('indicated', [UserController::class, 'indicated'])->name('users.indicated');
            Route::get('indicated/{userId}', [UserController::class, 'indicatedByLevel'])->name('users.indicatedByLevel');
            Route::get('users/{userId}/statementBalance', [UserController::class, 'statementBalance'])->name('users.statementBalance');
            Route::resource('permissions', PermissionController::class);
            Route::resource('roles', RoleController::class);
        });
    });
});

