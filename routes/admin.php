<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\StoreItemCategoriesController;
use App\Http\Controllers\Admin\AccountsCategoriesController;
use App\Http\Controllers\Admin\ClientsCategoriesController;
use App\Http\Controllers\Admin\ArrangementEntryController;
use App\Http\Controllers\Admin\DashboardSettingController;
use App\Http\Controllers\Admin\SalesCategoriesController;
use App\Http\Controllers\Admin\ReceptionEntryController;
use App\Http\Controllers\Admin\ReceiptEntriesController;
use App\Http\Controllers\Admin\AccountsTypesController;
use App\Http\Controllers\Admin\DeliveryEntryController;
use App\Http\Controllers\Admin\PositionEntryController;
use App\Http\Controllers\Admin\RepositoriesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ArrangementController;
use App\Http\Controllers\Admin\TreasuriesController;
use App\Http\Controllers\Admin\StoreItemsController;
use App\Http\Controllers\Admin\StoreBoxesController;
use App\Http\Controllers\Admin\UsersRolesController;
use App\Http\Controllers\Admin\ReceptionController;
use App\Http\Controllers\Admin\SubMenuesController;
use App\Http\Controllers\Admin\ContractsController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ReceiptsController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\AccountsCategories;
use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\DasboardController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\SectionsController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\DriversController;
use App\Http\Controllers\Admin\VendorsController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\TablesController;
use App\Http\Controllers\Admin\MenuesController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ItemsController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PeriodsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StoreItemGradesController;

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
Route::group([
    'namespace'     => 'Admin',
    'prefix'        => 'admin',
    'middleware'    => 'auth:admin'], function () {
        // dashboard
        // Route::get('dashboard',                                         [DasboardController::class, 'index'])->name('dashboard.home');
        // Route::get('dashboard',                                         [HomeController::class, 'index'])->name('home.dashboard');
        Route::get('dashboard',                                         [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('operations/log',                                    [HomeController::class, 'log'])->name('operations.log');
        Route::get('dashboard/home',                                    [HomeController::class, 'index'])->name('home.index');
        Route::get('/',                                                 [DasboardController::class, 'index']);
        Route::get('logout',                                            [LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard/show',                                   [DashboardSettingController::class, 'index'])->name('admin.dashboard.show');
        
        //=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=
        //======================================================= General Stats ==========================================================================================
        //=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=
        Route::get('home/index',                                         [HomeController::class, 'index'])->name('home.index');
        
        //=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=
        //======================================================= Dashboard Rotes ==========================================================================================
        //=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=
        Route::get('/dashboard/edit',                                   [DashboardSettingController::class, 'edit'])->name('admin.dashboard.edit');
        Route::get('/dashboard/setting/home',                           [DashboardSettingController::class, 'setting'])->name('setting.home');
        Route::post('/dashboard/add/storing/period',                    [DashboardSettingController::class, 'addStoringPeriod'])->name('add.storing.period');
        Route::get('/dashboard/set/storing/period/active/{id}',         [DashboardSettingController::class, 'setPeriodActive'])->name('set.period.active');

        //=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=
        //======================================================= Treasuries Routes ==========================================================================================
        //=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=
        Route::get('/treasuries/index',                                 [TreasuriesController::class, 'index'])->name('treasuries.home');
        Route::get('/treasuries/create',                                [TreasuriesController::class, 'create'])->name('treasuries.add');
        Route::get('/treasuries/edit/{id}',                             [TreasuriesController::class, 'edit'])->name('treasuries.edit');
        Route::get('treasuries/delete/{id}',                            [TreasuriesController::class, 'delete'])->name('treasuries.delete');
        Route::get('treasuries/view/{id}',                              [TreasuriesController::class, 'view'])->name('treasuries.view');
        Route::post('/treasuries/store',                                [TreasuriesController::class, 'store'])->name('treasuries.store');
        Route::post('/treasuries/addpull',                              [TreasuriesController::class, 'addSubTreasury'])->name('treasuries.addpull');
        Route::post('/treasuries/sit/{id}',                             [TreasuriesController::class, 'update'])->name('treasuries.update');
        Route::post('/treasuries/aj',                                   [TreasuriesController::class, 'ajax_search'])->name('treasuries.aj');
        Route::post('/treasuries/addmpr/{id}',                          [TreasuriesController::class, 'addmpr'])->name('treasuries.addmpr');
        Route::get('/treasuries/remmpr/{id}',                           [TreasuriesController::class, 'remmpr'])->name('treasuries.remmpr');
        Route::get('/treasuries/test',                                  [TreasuriesController::class, 'test'])->name('treasuries.test');
        Route::get('/treasuries/status/{id}',                           [TreasuriesController::class, 'status'])->name('treasuries.status');
        
        //===============================================================================================================================================================
        //========= Store Items Categories ========================================================================================================================================
        //===============================================================================================================================================================
        Route::get('/storeS/items/categories/home',                           [StoreItemCategoriesController::class, 'index'])->name('store-items-categories-list');
        Route::post('/storeS/items/categories/store',                         [StoreItemCategoriesController::class, 'store'])->name('store-items-categories-store');
        Route::get('/storeS/items/categories/edit/{id}',                      [StoreItemCategoriesController::class, 'edit'])->name('store-items-categories-edit');
        Route::post('/storeS/items/categories/update/{id}',                   [StoreItemCategoriesController::class, 'update'])->name('store-items-categories-update');
        Route::get('/storeS/items/categories/view/{id}',                      [StoreItemCategoriesController::class, 'view'])->name('store-items-categories-view');
        Route::get('/storeS/items/categories/remove/{id}',                    [StoreItemCategoriesController::class, 'destroy'])->name('store-items-categories-remove');

        //===============================================================================================================================================================
        //========= Store Items Routes ========================================================================================================================================
        //===============================================================================================================================================================
        Route::get('/stores/items/stats',                               [StoreItemsController::class, 'stats'])->name('store.items.stats');
        Route::get('/stores/items/home',                                [StoreItemsController::class, 'home'])->name('store.items.home');
        Route::get('/stores/items/edit/{id}',                           [StoreItemsController::class, 'edit'])->name('store.items.edit');
        Route::post('/stores/items/change/image',                       [StoreItemsController::class, 'change_image'])->name('store.items.change.image');
        Route::post('/stores/item/add',                                 [StoreItemsController::class, 'store'])->name('store.items.store');
        Route::post('/stores/item/update',                              [StoreItemsController::class, 'update'])->name('store.items.update');
        Route::get('/stores/items/remove/{id}',                         [StoreItemsController::class, 'delete'])->name('store.items.remove');
        Route::get('/stores/items/view/{id}',                           [StoreItemsController::class, 'view'])->name('store.items.view');

        //===============================================================================================================================================================
        //========= Store Items Grades Routes ========================================================================================================================================
        //===============================================================================================================================================================
        Route::get('/storeS/items/grades/home',                           [StoreItemGradesController::class, 'index'])->name('store-items-grades-list');
        Route::post('/storeS/items/grades/store',                         [StoreItemGradesController::class, 'store'])->name('store-items-grades-store');
        Route::get('/storeS/items/grades/edit/{id}',                      [StoreItemGradesController::class, 'edit'])->name('store-items-grades-edit');
        Route::post('/storeS/items/grades/update/{id}',                   [StoreItemGradesController::class, 'update'])->name('store-items-grades-update');
        Route::get('/storeS/items/grades/view/{id}',                      [StoreItemGradesController::class, 'view'])->name('store-items-grades-view');
        Route::get('/storeS/items/grades/remove/{id}',                    [StoreItemGradesController::class, 'destroy'])->name('store-items-grades-remove');

        //===============================================================================================================================================================
        //========= Sales Routes ========================================================================================================================================
        //===============================================================================================================================================================
        Route::get('/sales/home',                                       [SalesController::class, 'index'])->name('sales.home');
        Route::get('/sales/cats/home',                                  [SalesCategoriesController::class, 'index'])->name('sales.cats.home');
        Route::get('/sales/cats/create',                                [SalesCategoriesController::class, 'create'])->name('sales.cats.create');
        Route::post('/sales/cats/store',                                [SalesCategoriesController::class, 'store'])->name('sales.cats.store');
        Route::get('/sales/cats/view/{id}',                             [SalesCategoriesController::class, 'view'])->name('sales.cats.view');
        Route::get('/sales/cats/edit/{id}',                             [SalesCategoriesController::class, 'edit'])->name('sales.cats.edit');
        Route::post('/sales/cats/update/{id}',                          [SalesCategoriesController::class, 'update'])->name('sales.cats.update');
        Route::get('/sales/cats/delete/{id}',                           [SalesCategoriesController::class, 'delete'])->name('sales.cats.delete');
        Route::get('/sales/cats/status/{id}',                           [SalesCategoriesController::class, 'status'])->name('sales.cats.status');

        //=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=
        //======================================================= Contracts Routes ==========================================================================================
        //=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=//=
        Route::get('/contracts/index',                                  [ContractsController::class, 'index'])->name('contracts.index');
        Route::get('/contracts/home',                                   [ContractsController::class, 'home'])->name('contracts.home');
        Route::get('/contracts/invent',                                 [ContractsController::class, 'invent'])->name('contracts.invent');
        Route::post('/contracts/search',                                [ContractsController::class, 'ajax_search'])->name('contracts.search');
        Route::get('/contracts/track/tables/{id}',                      [ContractsController::class, 'track_tables'])->name('contracts.track.tables');
        Route::get('/contract/create/{id}',                             [ContractsController::class, 'create'])->name('contract.create');
        Route::post('/contract/store/{i}',                              [ContractsController::class, 'store'])->name('contract.store');
        Route::get('/contract/view/{id}/{t}',                           [ContractsController::class, 'view'])->name('contract.view');
        Route::get('/contract/edit/{id}/{t}',                           [ContractsController::class, 'edit'])->name('contract.edit');
        Route::get('/contract/edit/basic/info/{id}',                    [ContractsController::class, 'editBasicInfo'])->name('edit-contract-basic-info');
        Route::get('/contract/inputs/{id}/{t}',                         [ContractsController::class, 'inputs'])->name('contract.inputs');
        Route::post('/contract/update',                                 [ContractsController::class, 'update'])->name('contract.update');
        Route::get('/contract/approve/{id}',                            [ContractsController::class, 'approve'])->name('contract.approve');
        Route::get('/contract/print/{id}',                              [ContractsController::class, 'print'])->name('contract.print');
        Route::get('/contract/park/{id}',                               [ContractsController::class, 'park'])->name('contract.park');
        Route::post('/contract/setting',                                [ContractsController::class, 'setting'])->name('contracts.setting');
        Route::get('/contract/delete/{id}',                             [ContractsController::class, 'delete'])->name('delete-contract');
        Route::get('/contract/status/{id}',                             [ContractsController::class, 'status'])->name('contract.status');
        Route::get('/contract/additems',                                [ContractsController::class, 'additem'])->name('contract.additems');
        Route::post('/contract/items/history',                          [ContractsController::class, 'itemHistory'])->name('contract.items.history');
        Route::get('/contract/receive/{id}',                            [ContractsController::class, 'receive'])->name('contract.receive');
        Route::post('/contract/storeitems',                             [ContractsController::class, 'storeContractItems'])->name('contract.items.store');
        Route::post('/contract/updateitem',                             [ContractsController::class, 'updateContractItems'])->name('contract-items-update');
        Route::get('/contract/deleteitem/{id}',                         [ContractsController::class, 'deleteContractItem'])->name('contract-item-delete');
        Route::post('/contract/payment/schedule/entry/store',           [ContractsController::class, 'paymnetSchEntrystore'])->name('contract.payment.entry.store');
        Route::post('/contract/payment/schedule/entry/update',          [ContractsController::class, 'paymnetSchEntryUpdate'])->name('contract.payment.entry.update');
        Route::get('/contract/payment/schedule/entry/delete/{id}',      [ContractsController::class, 'paymnetSchEntryDelete'])->name('contract.payment.entry.delete');
        Route::get('/contract/extend/{id}',                             [ContractsController::class, 'extend'])->name('contract.extend');
        Route::post('/contract/update/extend/',                         [ContractsController::class, 'extendAndUpdate'])->name('contract.update.extend');
        Route::get('/contract/receipt/create/{id}/{t}',                 [ContractsController::class, 'createReceipt'])->name('receipt.create');
        Route::post('/contract/receipt/store',                          [ContractsController::class, 'storeReceipt'])->name('receipt.store');
        Route::get('/contract/delete/items/{id}',                       [ContractsController::class, 'deleteContractItem'])->name('contract.delete.item');
        Route::get('/contract/setting/store/{id}',                      [ContractsController::class, 'store_setting'])->name('contract.setting.store');
        Route::get('/contract/setting/update/{id}',                     [ContractsController::class, 'update_setting'])->name('contract.setting.update');
        Route::get('/period/edit/{id}',                                 [ContractsController::class, 'editPeriodInfo'])->name('period.edit');
        
        Route::get('/periods/statistics',                               [periodsController::class, 'index'])->name('contracts-periods-report');
        Route::get('/period/status/{id}',                               [periodsController::class, 'changeStatus'])->name('period.status-change');
        Route::post('/period/create/initial/{id}',                      [PeriodsController::class, 'storeInitial'])->name('create-first-period');
        Route::get('/period/create/view/{id}',                          [PeriodsController::class, 'create'])->name('create-period-view');
        Route::post('/period/store/info',                               [PeriodsController::class, 'store'])->name('store-period-info');
        Route::get('/period/create/form/{id}',                          [PeriodsController::class, 'createForm'])->name('create-period-form');
        Route::get('/period/delete/{id}',                               [PeriodsController::class, 'destroy'])->name('delete-period');

        Route::get('/contacts/tables/credit',                           [ContractsController::class, 'table_credit'])->name('contracts.table.credit');
        Route::get('/contacts/payment/info/{id}',                       [ContractsController::class, 'paymentInfo'])->name('contract-payment-info');
        Route::post('/contacts/search/by/client',                       [ContractsController::class, 'search_contracts_by_client'])->name('search-contracts-by-client');
        Route::post('/contacts/get/client/contracts',                   [ContractsController::class, 'get_client_contracts'])->name('get-client-contracts');
        Route::post('/contacts/get/contract/tables/count',              [ContractsController::class, 'get_contracts_tables_count'])->name('get-contract-tables-count');
        Route::post('/contacts/get/general/stats',                      [ContractsController::class, 'get_contract_stats'])->name('get.contract.stats');

        Route::post('/clients/contracts/get/tables/credit',             [ContractsController::class, 'get_table_credit'])->name('get.contracts.table.credit');
        Route::post('/clients/with/active/contracts',                   [ContractsController::class, 'clients_with_active_contracts'])->name('get.contracts.table.credit');

        //Services
        Route::get('/services/home',                                    [salesController::class, 'services'])->name('services.home');
        Route::get('/services/create',                                  [salesController::class, 'createService'])->name('services.create');
        Route::post('/services/store',                                  [salesController::class, 'storeService'])->name('services.store');
        Route::get('/services/view/{id}',                               [salesController::class, 'viewService'])->name('services.view');
        Route::get('/services/edit/{id}',                               [salesController::class, 'editService'])->name('services.edit');
        Route::post('/services/update/{id}',                            [salesController::class, 'updateService'])->name('services.update');
        Route::get('/services/delete/{id}',                             [salesController::class, 'deleteService'])->name('services.delete');
        Route::post('/services/status/{id}',                            [salesController::class, 'statusService'])->name('services.status');
        
        ################################### MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS ################################################
        Route::get('/receipts/entries/create/{con}/{cl}',               [ReceiptEntriesController::class, 'create'])->name('input.entry.create');
        Route::get('/entries/output/create/{con}/{cl}',                 [ReceiptEntriesController::class, 'create_out'])->name('output.entry.create');
        Route::get('/entries/inventory/create/{con}',                   [ReceiptEntriesController::class, 'create_inv'])->name('inventory.entry.create');
        Route::post('/receipts/entries/store',                          [ReceiptEntriesController::class, 'store'])->name('receipt.entry.store');
        Route::post('/receipts/entries/save',                           [ReceiptEntriesController::class, 'saveEntry'])->name('receipt.entry.save');
        Route::post('/receipts/entries/store/out',                      [ReceiptEntriesController::class, 'store_out'])->name('receipt.entry.store.out');
        Route::post('/receipts/storeInventory',                         [ReceiptEntriesController::class, 'storeInventoryReceipt'])->name('receipts.storeInventoryReceipt');
        Route::post('/receipts/table/contents',                         [ReceiptEntriesController::class, 'table_contents'])->name('receipt.entry.table.contents');
        Route::post('/receipts/table/contents/aj',                      [ReceiptEntriesController::class, 'table_info_to_extract_items'])->name('table.contents.aj');
        Route::post('/receipts/table/itemQty/aj',                       [ReceiptEntriesController::class, 'item_qty_to_extract_items'])->name('table.itemQty.aj');
        Route::post('/receipts/table/itemBox/aj',                       [ReceiptEntriesController::class, 'item_Box_to_extract_items'])->name('table.itemBox.aj');
        Route::post('/receipts/table/item/qty',                         [ReceiptEntriesController::class, 'tableItemQty'])->name('receipt.entry.item.qty');
        Route::post('/receipts/table/item/box',                         [ReceiptEntriesController::class, 'tableItemBox'])->name('receipt.entry.item.box');
        Route::post('/receipts/entries/update',                         [ReceiptEntriesController::class, 'update'])->name('receipt.entry.update');
        Route::get('/receipts/entries/entry/delete/{id}',               [ReceiptEntriesController::class, 'destroy'])->name('receipt.entry.delete');
        Route::get('/receipts/entries/view/{id}',                       [ReceiptEntriesController::class, 'view'])->name('receipt.entry.view');
        Route::post('/receipts/entries/check/table',                    [ReceiptEntriesController::class, 'checkTable'])->name('receipt.entry.check.table');
        Route::post('/receipts/entries/table/contents',                 [ReceiptEntriesController::class, 'tableContents'])->name('receipt.entry.get.table.contents');
        Route::post('/table/items/array',                               [ReceiptEntriesController::class, 'tableItemsArray'])->name('table.items.array');
        Route::post('/table/items/boxes/array',                         [ReceiptEntriesController::class, 'tableItemsBoxesArray'])->name('table.items.boxes.array');
        Route::get('/receipts/entries/entry/print/{id}',                [ReceiptEntriesController::class, 'print'])->name('receipt.entry.print');
        ################################### MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS ##########################################
        
        //#//#//#//#//#//#//#//#//#//#//# RECEPTION RECEIPTS #////# RECEPTION RECEIPTS #//#//# RECEPTION RECEIPTS #//#//# RECEPTION RECEIPTS  #//
        // ======================================================= سندات وعمليات استلام البضاعة =============================================
        //#//#//#//#//#//#//#//#//#//#//# RECEPTION RECEIPTS #////# RECEPTION RECEIPTS #//#//# RECEPTION RECEIPTS #//#//# RECEPTION RECEIPTS  #//
        Route::get('/reception/home/{tab}',                             [ReceptionController::class, 'index'])->name('reception.home');    
        Route::get('/reception/deleted',                                [ReceptionController::class, 'deletedReceipts'])->name('reception.deleted');    
        Route::get('/reception/create/{id}',                            [ReceptionController::class, 'create'])->name('reception.create');
        Route::get('/reception/approve/{id}',                           [ReceptionController::class, 'approve'])->name('reception.approve');
        Route::get('/reception/print/{id}',                             [ReceptionController::class, 'print'])->name(' ');
        Route::get('/reception/park/{id}',                              [ReceptionController::class, 'park'])->name('reception.park');
        Route::get('/reception/edit/{id}',                              [ReceptionController::class, 'edit'])->name('reception.edit');
        Route::get('/reception/view/{id}',                              [ReceptionController::class, 'view'])->name('reception.view');
        Route::get('/reception/print/{id}',                             [ReceptionController::class, 'print'])->name('reception.print');
        Route::get('/reception/destroy/{id}',                           [ReceptionController::class, 'destroy'])->name('reception.destroy');
        Route::post('/reception/store',                                 [ReceptionController::class, 'store'])->name('reception.store');
        Route::post('/reception/search',                                [ReceptionController::class, 'search'])->name('reception.search');
        Route::post('/reception/update',                                [ReceptionController::class, 'update'])->name('reception.update');
        Route::post('/reception/view',                                  [ReceptionController::class, 'view'])->name('reception.info');
        Route::post('/entry/table/info',                                [ReceptionController::class, 'table_info'])->name('entry.table.info');
        //#//#//#//#//#//#//#//#//#//#//# RECEPTION RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#

        //#//#//#//#//#//#//#//#//#//#//# RECEPTION RECEIPTS #////# RECEPTION RECEIPTS #//#//# RECEPTION RECEIPTS #//#//# RECEPTION RECEIPTS  #//
        // ======================================================= سندات وعمليات استلام البضاعة =============================================
        //#//#//#//#//#//#//#//#//#//#//# RECEPTION RECEIPTS #////# RECEPTION RECEIPTS #//#//# RECEPTION RECEIPTS #//#//# RECEPTION RECEIPTS  #//
        Route::get('/delivery/home/{tab}',                             [DeliveryController::class, 'index'])->name('delivery.home');    
        Route::get('/delivery/deleted',                                [DeliveryController::class, 'deletedReceipts'])->name('delivery.deleted');    
        Route::get('/delivery/create/{id}',                            [DeliveryController::class, 'create'])->name('delivery.create');
        Route::get('/delivery/approve/{id}',                           [DeliveryController::class, 'approve'])->name('delivery.approve');
        Route::get('/delivery/print/{id}',                             [DeliveryController::class, 'print'])->name('delivery.print');
        Route::get('/delivery/park/{id}',                              [DeliveryController::class, 'park'])->name('delivery.park');
        Route::get('/delivery/edit/{id}',                              [DeliveryController::class, 'edit'])->name('delivery.edit');
        Route::get('/delivery/view/{id}',                              [DeliveryController::class, 'view'])->name('delivery.view');
        Route::get('/delivery/print/{id}',                             [DeliveryController::class, 'print'])->name('delivery.print');
        Route::get('/delivery/destroy/{id}',                           [DeliveryController::class, 'destroy'])->name('delivery.destroy');
        Route::post('/delivery/store',                                 [DeliveryController::class, 'store'])->name('delivery.store');
        Route::post('/delivery/search',                                [DeliveryController::class, 'search'])->name('delivery.search');
        Route::post('/delivery/update',                                [DeliveryController::class, 'update'])->name('delivery.update');
        Route::post('/delivery/view',                                  [DeliveryController::class, 'view'])->name('delivery.info');
        Route::post('/entry/table/info',                               [ReceptionController::class, 'table_info'])->name('entry.table.info');
        //#//#//#//#//#//#//#//#//#//#//# RECEPTION RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#
       
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        //=======================================================  سندات وعمليات الجرد على المخازن =============================================================
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        Route::get('/stocking/home/{tab}',                              [StockController::class, 'index'])->name('stocking.home');    
        Route::get('/stocking/deleted',                                 [StockController::class, 'deletedReceipts'])->name('reception.deleted');    
        Route::get('/stocking/create/{id}',                             [StockController::class, 'create'])->name('stocking.create');
        Route::get('/stocking/approve/{id}',                            [StockController::class, 'approve'])->name('stocking.approve');
        Route::get('/stocking/receipt/print/{id}',                      [StockController::class, 'print'])->name('stocking.receipt.print');
        Route::get('/stocking/receipt/park/{id}',                       [StockController::class, 'park'])->name('stocking.receipt.park');
        Route::get('/stocking/edit/{id}',                               [StockController::class, 'edit'])->name('stocking.edit');
        Route::get('/stocking/print/{id}',                              [StockController::class, 'print'])->name('stocking.print');
        Route::get('/stocking/destroy/{id}',                            [StockController::class, 'destroy'])->name('stocking.destroy');
        Route::post('/stocking/store',                                  [StockController::class, 'store'])->name('stocking.store');
        Route::post('/stocking/update',                                 [StockController::class, 'update'])->name('stocking.update');
        Route::post('/stocking/view',                                   [StockController::class, 'view'])->name('stocking.receipt.info');
        Route::post('/stocking/table/info',                             [StockController::class, 'table_info'])->name('entry.table.info');
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
       
        //#//#//#//#//#//#//#//#//#//#//# ARRANGEMENT RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#
        //======================================================= سندات وعمليات الترتيب على الطبالى =============================================================
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        Route::get('/arrange/receipts/home/{tab}',                      [ArrangementController::class, 'index'])->name('arrange.home');    
        Route::get('/arrange/receipts/create/{id}',                     [ArrangementController::class, 'create'])->name('arrange.create');
        Route::get('/arrange/receipts/edit/{id}',                       [ArrangementController::class, 'edit'])->name('arrange.edit');
        Route::get('/arrange/receipts/approve/{id}',                    [ArrangementController::class, 'approve'])->name('arrange.approve');
        Route::get('/arrange/receipts/destroy/{id}',                    [ArrangementController::class, 'destroy'])->name('arrange.destroy');
        Route::get('/arrange/receipts/print/{id}',                      [ArrangementController::class, 'print'])->name('arrange.print');
        Route::get('/arrange/receipts/park/{id}',                       [ArrangementController::class, 'park'])->name('arrange.park');
        Route::post('/arrange/receipts/store',                          [ArrangementController::class, 'store'])->name('arrange.store');
        Route::post('/arrange/receipts/info',                           [ArrangementController::class, 'view'])->name('arrange.info');
        Route::post('/arrange/receipts/search',                         [ArrangementController::class, 'search'])->name('arrange.search');
        Route::post('/entry/table/info',                                [ArrangementController::class, 'table_info'])->name('entry.table.info');
        //#//#//#//#//#//#//#//#//#//#//#// ARRANGEMENT RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        
        //#//#//#//#//#//#//#//#//#//#//# POSITION RECEIPTS #//#//#//#// POSITION RECEIPTS //#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#
        //======================================================= سندات وعمليات تسكين الطبالى فى الغرف  =============================================================
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        Route::get('/position/receipts/home',                            [PositionController::class, 'index'])->name('position.home');    
        Route::get('/position/receipts/create',                          [PositionController::class, 'create'])->name('position.create');
        Route::get('/position/receipts/edit/{id}',                       [PositionController::class, 'edit'])->name('position.edit');
        Route::get('/position/receipts/approve/{id}',                    [PositionController::class, 'approve'])->name('position.approve');
        Route::get('/position/receipts/destroy/{id}',                    [PositionController::class, 'destroy'])->name('position.destroy');
        Route::get('/position/receipts/print/{id}',                      [PositionController::class, 'print'])->name('position.print');
        Route::get('/position/receipts/park/{id}',                       [PositionController::class, 'park'])->name('position.park');
        Route::post('/position/receipts/store',                          [PositionController::class, 'store'])->name('position.store');
        Route::post('/position/receipts/info',                           [PositionController::class, 'view'])->name('position.info');
        Route::post('/position/receipts/search',                         [PositionController::class, 'search'])->name('position.search');
        //#//#//#//#//#//#//#//#//#//#//# POSITION RECEIPTS #//#//#//#// POSITION RECEIPTS //#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#
        
        // RECEPTION ENTRIES //#//#//#/ RECEPTION ENTRIES //#//#//#//#//# RECEPTION ENTRIES #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        //======================================================= سجلات عمليات استلام الطبالى فى الغرف  =============================================================
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        Route::get('/reception/entries/create/{id}/{copy}',             [ReceptionEntryController::class, 'create'])->name('reception.entries.create');
        Route::get('/reception/entries/copy/{id}/{copy}',               [ReceptionEntryController::class, 'copy'])->name('reception.entries.copy');
        Route::post('/reception/rentries/store',                        [ReceptionEntryController::class, 'store'])->name('reception.entries.store');
        Route::post('/reception/rentries/update',                       [ReceptionEntryController::class, 'update'])->name('reception.entries.update');
        Route::get('/reception/rentries/delete/{id}',                   [ReceptionEntryController::class, 'destroy'])->name('reception.entries.delete');
        // RECEPTION ENTRIES //#//#//#/ RECEPTION ENTRIES //#//#//#//#//# RECEPTION ENTRIES #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#
        
        // RECEPTION ENTRIES //#//#//#/ RECEPTION ENTRIES //#//#//#//#//# RECEPTION ENTRIES #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        //======================================================= سجلات عمليات تسكين الطبالى فى الغرف =============================================================
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        Route::get('/position/entries/create/{id}/{copy}',             [PositionEntryController::class, 'create'])->name('position.entries.create');
        Route::get('/position/entries/copy/{id}/{copy}',               [PositionEntryController::class, 'copy'])->name('position.entries.copy');
        Route::post('/position/rentries/store',                        [PositionEntryController::class, 'store'])->name('position.entries.store');
        Route::post('/position/rentries/update',                       [PositionEntryController::class, 'update'])->name('position.entries.update');
        Route::get('/position/rentries/delete/{id}',                   [PositionEntryController::class, 'destroy'])->name('position.entries.delete');
        // RECEPTION ENTRIES //#//#//#/ RECEPTION ENTRIES //#//#//#//#//# RECEPTION ENTRIES #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#
        
        // DELIVERY ENTRIES //#//#//#/ DELIVERY ENTRIES //#//#//#//#//# DELIVERY ENTRIES #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        //======================================================= سجلات عمليات تسليم البضاعة للعملاء =============================================================
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        Route::get('/delivery/entries/create/{id}/{copy}',             [DeliveryEntryController::class, 'create'])->name('delivery.entries.create');
        Route::get('/delivery/entries/copy/{id}/{copy}',               [DeliveryEntryController::class, 'copy'])->name('delivery.entries.copy');
        Route::post('/delivery/rentries/store',                        [DeliveryEntryController::class, 'store'])->name('delivery.entries.store');
        Route::post('/delivery/rentries/update',                       [DeliveryEntryController::class, 'update'])->name('delivery.entries.update');
        Route::get('/delivery/rentries/delete/{id}',                   [DeliveryEntryController::class, 'destroy'])->name('delivery.entries.delete');
        // DELIVERY ENTRIES //#//#//#/ DELIVERY ENTRIES //#//#//#//#//# DELIVERY ENTRIES #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#
        
        // ARRANGEMENT ENTRIES //#//#//#//#// ARRANGEMENT ENTRIES //#//#//#//#//# ARRANGEMENT ENTRIES #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//
        //======================================================= سجلات عمليات ترتيب البضاعة على الطبالى  =============================================================
        //#//#//#//#//#//#//#//#//#//#//# STOCKTACKING RECEIPTS #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#/
        Route::get('/arrange/entries/create/{id}/{copy}',               [ArrangementEntryController::class, 'create'])->name('arrange.entries.create');
        Route::get('/arrange/entries/copy/{id}/{copy}',                 [ArrangementEntryController::class, 'copy'])->name('arrange.entries.copy');
        Route::post('/arrange/rentries/store',                          [ArrangementEntryController::class, 'store'])->name('arrange.entries.store');
        Route::post('/arrange/rentry/update',                           [ArrangementEntryController::class, 'update'])->name('arrange.entries.update');
        Route::get('/arrange/rentry/delete/{id}',                       [ArrangementEntryController::class, 'destroy'])->name('arrange.entries.delete');
        Route::post('arrange/entry/table/content',                      [ArrangementEntryController::class, 'tableContent'])->name('get.table.contents');
        // ARRANGEMENT ENTRIES //#//#//#//#// ARRANGEMENT ENTRIES //#//#//#//#//# ARRANGEMENT ENTRIES #//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//#//
        
        ################################### MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS #####################################################
        Route::get('/operating/home',                                   [ReceiptsController::class, 'home'])->name('operating.home');    
        Route::get('/receipts/home',                                    [ReceiptsController::class, 'home'])->name('receipts.home');    
        Route::get('/receipts/park/{id}',                               [ReceiptsController::class, 'park'])->name('receipt.park');    
        Route::get('/receipts/all/{tab}',                               [ReceiptsController::class, 'all'])->name('receipts.all');    
        Route::get('/receipts/input/receipts/{t}',                      [ReceiptsController::class, 'input_receipts'])->name('receipts.input_receipts');
        Route::get('/receipts/settlement/receipts/{t}',                 [ReceiptsController::class, 'settlement_receipts'])->name('operating.settlement.receipts');
        Route::get('/receipts/output/receipts/{t}/',                    [ReceiptsController::class, 'output_receipts'])->name('receipts.output_receipts');
        Route::get('/receipts/inventory/receipts/{t}',                  [ReceiptsController::class, 'inventory_receipts'])->name('operating.inventory.receipts');
        Route::get('/receipts/parked/home/{t}',                         [ReceiptsController::class, 'parked_receipts'])->name('parked.receipts.home');
        Route::get('/receipts/input/receipts/view/{id}',                [ReceiptsController::class, 'input_receipts_view'])->name('receipts.input.view');
        Route::get('/receipts/output/receipts/view/{id}',               [ReceiptsController::class, 'output_receipts_view'])->name('receipts.output.view');
        Route::get('/receipts/print/input/receipts/{id}',               [ReceiptsController::class, 'print_input_receipts'])->name('receipts.input.print');
        Route::get('/receipts/print/output/receipts/{id}',              [ReceiptsController::class, 'print_output_receipts'])->name('receipts.output.print');
        Route::get('/receipts/print/arrange/receipts/{id}',             [ReceiptsController::class, 'print_arrange_receipts'])->name('receipts.print_arrange_receipts');
        Route::get('/receipts/print/inventory/receipts/{id}',           [ReceiptsController::class, 'print_inventory_receipts'])->name('operating.print_inventory_receipts');
        Route::get('/receipts/out/all',                                 [ReceiptsController::class, 'out_all'])->name('receipts.out.all');
        Route::get('/receipts/test',                                    [ReceiptsController::class, 'test'])->name('receipts.test');
        Route::get('/receipts/input/create/{id}',                       [ReceiptsController::class, 'createInputReceipt'])->name('receipts.input.create');
        Route::get('/receipts/output/create/{id}',                      [ReceiptsController::class, 'createOutputReceipt'])->name('receipts.output.create');
        Route::get('/receipts/inventory/create/{id}',                   [ReceiptsController::class, 'createInventoryReceipt'])->name('operating.inventory.create');
        Route::get('/receipts/create/Arrange/receipt/{id}',             [ReceiptsController::class, 'createArrangeReceipt'])->name('receipts.createArrangeReceipt');
        Route::get('/receipts/create/{id}',                             [ReceiptsController::class, 'create'])->name('receipt.create');
        Route::get('/receipts/approve/{id}',                            [ReceiptsController::class, 'approve'])->name('receipt.approve');
        Route::get('/receipts/input/edit/{id}',                         [ReceiptsController::class, 'editInputReceipt'])->name('receipts.editInputReceipt');
        Route::get('/receipts/output/edit/{id}',                        [ReceiptsController::class, 'editOutputReceipt'])->name('receipts.editOutputReceipt');
        Route::get('/receipts/inventory/edit/{id}',                     [ReceiptsController::class, 'editInventoryReceipt'])->name('receipts.editInventoryReceipt');
        Route::get('/receipts/cancel/{id}',                             [ReceiptsController::class, 'cancel'])->name('receipt.cancel');
        Route::post('/receipts/storeInputReceipt',                      [ReceiptsController::class, 'storeInputReceipt'])->name('receipts.storeInputReceipt');
        Route::post('/receipts/storeOutputReceipt',                     [ReceiptsController::class, 'storeOutputReceipt'])->name('receipts.storeOutputReceipt');
        Route::post('/receipts/updateInputReceipt',                     [ReceiptsController::class, 'updateInputReceipt'])->name('receipts.updateInputReceipt');
        Route::post('/receipts/store',                                  [ReceiptsController::class, 'store'])->name('receipt.store');
        Route::get('/receipts/edit/id/{id}',                            [ReceiptsController::class, 'edit'])->name('receipts.edit');
        Route::post('/receipts/update',                                 [ReceiptsController::class, 'update'])->name('receipt.update');
        Route::get('/receipts/destroy/{id}',                            [ReceiptsController::class, 'destroy'])->name('receipt.destroy');
        Route::get('/receipts/view/{id}',                               [ReceiptsController::class, 'view'])->name('receipt.view');
        Route::get('/receipts/receipts/log',                            [ReceiptsController::class, 'log'])->name('operating.receipts.log');
        Route::post('/receipts/search/input/receipts',                  [ReceiptsController::class, 'search_input_receipts'])->name('receipts.search_input_receipts');
        Route::post('/receipts/search/output/receipts',                 [ReceiptsController::class, 'search_output_receipts'])->name('receipts.search_output_receipts');
        Route::post('/receipts/search/arrange/receipts',                [ReceiptsController::class, 'search_arrange_receipts'])->name('receipts.search_arrange_receipts');
        Route::post('/receipts/display/receipt/info',                   [ReceiptsController::class, 'displayReceiptInfo'])->name('receipts.displayReceiptInfo');
        ################################### MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS MOVEMENTS ###############################################################

        ################################### DRIVERS DRIVERS DRIVERS DRIVERS || DRIVERS DRIVERS DRIVERS DRIVERS #########################################################
        //Route::get('/receipts/home',                              [ReceiptEntriesController::class, 'index'])->name('receipts.home');
        Route::get('/drivers/home',                                     [DriversController::class, 'index'])->name('drivers.home');
        Route::get('/drivers/create',                                   [DriversController::class, 'create'])->name('drivers.create');
        Route::post('/drivers/store',                                   [DriversController::class, 'store'])->name('drivers.store');
        Route::get('/drivers/show/{id}/{t}',                            [DriversController::class, 'show'])->name('drivers.show');
        Route::get('/drivers/edit/{id}',                                [DriversController::class, 'edit'])->name('drivers.edit');
        Route::put('/drivers/update/',                                  [DriversController::class, 'update'])->name('drivers.update');
        Route::post('/drivers/roles/add',                               [DriversController::class, 'addRoles'])->name('drivers.add.roles');
        Route::put('/drivers/profile/update',                           [DriversController::class, 'updateProfile'])->name('drivers.profiles.update');
        Route::get('/drivers/delete/{id}',                              [DriversController::class, 'destroy'])->name('drivers.delete');
        ################################### DRIVERS  DRIVERS  DRIVERS  DRIVERS  || DRIVERS  DRIVERS  DRIVERS  DRIVERS  ##########################################
        
        ################################### GENERAL SETTINGS GENERAL SETTINGS || GENERAL SETTINGS GENERAL SETTINGS ##############################################
        //Route::get('/receipts/home',                              [ReceiptEntriesController::class, 'index'])->name('receipts.home');
        Route::get('/users/home',                                       [UsersController::class, 'index'])->name('users.home');
        Route::get('/users/create',                                     [UsersController::class, 'create'])->name('users.create');
        Route::post('/users/store',                                     [UsersController::class, 'store'])->name('users.store');
        Route::get('/users/show',                                       [UsersController::class, 'show'])->name('users.show');
        Route::get('/users/show/basic/info/{id}',                       [UsersController::class, 'showBasicInfo'])->name('users.show.basic.info');
        Route::get('/users/show/permissions/{id}',                      [UsersController::class, 'permissions'])->name('see.own.permissions');
        Route::get('/users/show/login/info/{id}',                       [UsersController::class, 'loginInfo'])->name('see.own.login.info');
        Route::get('/users/show/diaries/{id}',                          [UsersController::class, 'diaries'])->name('see.user.diaries');
        Route::get('/users/edit/{id}',                                  [UsersController::class, 'edit'])->name('users.edit');
        Route::post('/users/update/',                                   [UsersController::class, 'update'])->name('users.update');
        Route::post('/users/profile/update',                            [UsersController::class, 'updateProfile'])->name('users.profiles.update');
        Route::post('/users/change/password',                           [UsersController::class, 'changePassword'])->name('users.change.password');
        Route::get('/users/delete/{id}',                                [UsersController::class, 'delete'])->name('users.delete');
        Route::get('/delete/user/role/{id}',                            [UsersController::class, 'deleteRole'])->name('delete.user.role');
        ################################### GENERAL SETTINGS GENERAL SETTINGS || GENERAL SETTINGS GENERAL SETTINGS ########################################
        
        ################################### GENERAL SETTINGS GENERAL SETTINGS || GENERAL SETTINGS GENERAL SETTINGS ########################################
        Route::post('/users/roles/add',                                 [UsersRolesController::class, 'updateUserRoles'])->name('assign.role.to.user');
        
        // Route::get('/admins/home',                                      [AdminsController::class, 'index'])->name('admins.home');
        // Route::get('/admins/create',                                    [AdminsController::class, 'create'])->name('admins.create');
        // Route::post('/admins/store',                                    [AdminsController::class, 'store'])->name('admins.store');
        // Route::get('/admins/show',                                      [AdminsController::class, 'show'])->name('admins.show');
        // Route::get('/users/show/basic/info/{id}',                       [AdminsController::class, 'showBasicInfo'])->name('users.show.basic.info');
        // Route::get('/admins/show/permissions/{id}',                     [AdminsController::class, 'permissions'])->name('see.own.permissions');
        // Route::get('/admins/show/login/info/{id}',                      [AdminsController::class, 'loginInfo'])->name('see.own.login.info');
        // Route::get('/admins/edit/{id}',                                 [AdminsController::class, 'edit'])->name('admins.edit');
        // Route::post('/admins/update/',                                  [AdminsController::class, 'update'])->name('admins.update');
        // Route::post('/admins/profiles/update/',                         [AdminsController::class, 'profile_update'])->name('admins.profile.update');
        // Route::post('/admins/roles/add',                                [AdminsController::class, 'addRoles'])->name('admins.add.roles');
        // Route::put('/admins/profile/update',                            [AdminsController::class, 'updateProfile'])->name('admins.profiles.update');
        // Route::get('/admins/delete/{id}',                               [AdminsController::class, 'delete'])->name('admins.delete');
        ################################### GENERAL SETTINGS GENERAL SETTINGS || GENERAL SETTINGS GENERAL SETTINGS #######################################

        ################################### GENERAL SETTINGS GENERAL SETTINGS || GENERAL SETTINGS GENERAL SETTINGS #######################################
        // Route::get('/permissions/home',                                 [PermissionsController::class, 'index'])->name('permissions.home');
        // Route::get('/permissions/create',                               [PermissionsController::class, 'create'])->name('permissions.create');
        // Route::get('/permissions/edit/{id}',                            [PermissionsController::class, 'edit'])->name('permissions.edit');
        // Route::get('/permissions/destroy/{id}',                         [PermissionsController::class, 'destroy'])->name('permissions.destroy');
        // Route::post('/permissions/store',                               [PermissionsController::class, 'store'])->name('permissions.store');
        // Route::post('/permissions/getActionsOf',                        [PermissionsController::class, 'getActionsOf'])->name('permissions.getActionsOf');
        // Route::post('/permissions/update',                              [PermissionsController::class, 'update'])->name('permissions.update');
        ################################### GENERAL SETTINGS GENERAL SETTINGS || GENERAL SETTINGS GENERAL SETTINGS ########################################

        ################################### GENERAL SETTINGS RULES GENERAL SETTINGS RULES || GENERAL SETTINGS RULES GENERAL SETTINGS RULES ################
        // Route::get('/roles/home',                                       [RolesController::class, 'index'])->name('roles.home');
        // Route::get('/roles/nonactive',                                  [RolesController::class, 'nonactive'])->name('roles.nonactive');
        // Route::get('/roles/permissions',                                [RolesController::class, 'rolesPermissions'])->name('roles.permissions');
        // Route::post('/roles/permissions.assign',                        [RolesController::class, 'assignPermissionsToRole'])->name('roles.permissions.assign');
        // Route::post('/roles/permissions/by/ajax',                       [RolesController::class, 'ajaxRolePermissions'])->name('get.role.permissions.by.ajax');
        // Route::get('/roles/create',                                     [RolesController::class, 'create'])->name('roles.create');
        // Route::post('/roles/store',                                     [RolesController::class, 'store'])->name('roles.store');
        // Route::get('/roles/edit/{id}',                                  [RolesController::class, 'edit'])->name('roles.edit');
        // Route::get('/roles/view/{id}',                                  [RolesController::class, 'view'])->name('roles.view');
        // Route::get('/roles/addActions/{id}',                            [RolesController::class, 'addActions'])->name('roles.addActions');
        // Route::post('/roles/update',                                    [RolesController::class, 'update'])->name('roles.update');
        // Route::post('/roles/storeActions',                              [RolesController::class, 'storeActions'])->name('roles.storeActions');
        // Route::post('/roles/addmenu',                                   [RolesController::class, 'addMenuToRole'])->name('roles.add.menu');
        // Route::get('/roles/show/{id}',                                  [RolesController::class, 'show'])->name('roles.show');
        // Route::get('/roles/delete/{id}',                                [RolesController::class, 'destroy'])->name('roles.delete');
        // Route::get('/roles/setting',                                    [RolesController::class, 'setting'])->name('roles.setting');
        ################################### GENERAL SETTINGS RULES GENERAL SETTINGS RULES || GENERAL SETTINGS RULES GENERAL SETTINGS RULES ################

        ################################### GENERAL SETTINGS MENUES GENERAL SETTINGS MENUES || GENERAL SETTINGS MENUES GENERAL SETTINGS MENUES ############
        // Route::get('/menues/home',                                      [MenuesController::class, 'index'])->name('menues.home');
        // Route::get('/menues/create',                                    [MenuesController::class, 'create'])->name('menues.create');
        // Route::get('/menues/edit/{id}',                                 [MenuesController::class, 'edit'])->name('menues.edit');
        // Route::post('/menues/store',                                    [MenuesController::class, 'store'])->name('menues.store');
        // Route::post('/menues/update',                                   [MenuesController::class, 'update'])->name('menues.update');
        // Route::get('/menues/change/status/{id}',                        [MenuesController::class, 'change_status'])->name('menues.change_status');
        // Route::get('/menues/destroy/{id}',                              [MenuesController::class, 'destroy'])->name('menues.destroy');
        // Route::get('/menues/ajax/get/{id}',                             [MenuesController::class, 'getMenu'])->name('menues.get.one');
        ################################### GENERAL SETTINGS MENUES GENERAL SETTINGS MENUES || GENERAL SETTINGS MENUES GENERAL SETTINGS MENUES #############

        
        //Invoices
        Route::get('/invoices/home',                                    [InvoicesController::class, 'home'])->name('services.status');
        Route::get('/invoices/create/for/period/{id}',                 [InvoicesController::class, 'createPeriodInvoice'])->name('create-invoice-for-period'); // Pass the period id
        Route::get('/sales/invoice/home',                               [InvoicesController::class, 'index'])->name('sales.invoice.home');
        Route::get('/sales/itemsCategories/home',                       [SalesCategoriesController::class, 'home'])->name('sales.itemsCategories');
        Route::get('/sales/invoice/create',                             [InvoicesController::class, 'create'])->name('sales.invoice.create');
        Route::post('/sales/invoice/store',                             [InvoicesController::class, 'store'])->name('sales.invoice.store');
        Route::get('/sales/invoice/view/{id}',                          [InvoicesController::class, 'view'])->name('sales.invoice.view');
        Route::get('/sales/invoice/edit/{id}',                          [InvoicesController::class, 'edit'])->name('sales.invoice.edit');
        Route::post('/sales/invoice/update/{id}',                       [InvoicesController::class, 'update'])->name('sales.invoice.update');
        Route::get('/sales/invoice/delete/{id}',                        [InvoicesController::class, 'delete'])->name('sales.invoice.delete');
        Route::get('/sales/invoice/status/{id}',                        [InvoicesController::class, 'status'])->name('sales.invoice.status');

        //Invoices
        Route::get('/accounts/home',                                    [AccountsController::class, 'index'])->name('accounts.home');
        Route::get('/accounts/journal',                                 [AccountsController::class, 'journal'])->name('accounts.journals');
        Route::get('/accounts/chart',                                   [AccountsController::class, 'journal'])->name('accounts.chart');
        Route::get('/accounts/setting',                                 [AccountsController::class, 'setting'])->name('accounts.setting');
        Route::get('/accounts/create/{t}',                              [AccountsController::class, 'create'])->name('accounts.create');
        Route::post('/accounts/store',                                  [AccountsController::class, 'store'])->name('accounts.store');
        Route::get('/accounts/view/{id}',                               [AccountsController::class, 'view'])->name('accounts.view');
        Route::get('/accounts/edit/{id}',                               [AccountsController::class, 'edit'])->name('accounts.edit');
        Route::post('/accounts/update/{id}',                            [AccountsController::class, 'update'])->name('accounts.update');
        Route::get('/accounts/delete/{id}',                             [AccountsController::class, 'delete'])->name('accounts.delete');
        Route::get('/accounts/status/{id}',                             [AccountsController::class, 'status'])->name('accounts.status');

        //Invoices
        Route::get('/accounts/cats/home',                               [AccountsCategoriesController::class, 'index'])->name('accounts.cats.home');
        Route::post('/accounts/cats/store',                             [AccountsCategoriesController::class, 'store'])->name('accounts.cats.store');
        Route::get('/accounts/cats/edit/{id}',                          [AccountsCategoriesController::class, 'edit'])->name('accounts.cats.edit');
        Route::post('/accounts/cats/update',                            [AccountsCategoriesController::class, 'update'])->name('accounts.cats.update');
        Route::get('/accounts/cats/delete/{id}',                        [AccountsCategoriesController::class, 'delete'])->name('accounts.cats.delete');

        //Account
        Route::get('/clients/home',                                     [ClientsController::class, 'index'])->name('clients.home');
        Route::get('/contacts/home',                                    [ClientsController::class, 'index'])->name('contacts.home');
        Route::post('/client/add/contact',                              [ClientsController::class, 'addContact'])->name('clients.add.contact');
        Route::get('/clients/stats',                                    [ClientsController::class, 'stats'])->name('clients.stats');
        
        Route::get('/contacts/stats',                                   [ClientsController::class, 'stats'])->name('contracts.stats');
        
        
        Route::get('/contacts/all',                                     [ClientsController::class, 'index'])->name('contacts.all');
        Route::get('/clients/reports/home',                             [ClientsController::class, 'reports'])->name('clients.reports.home');
        Route::get('/clients/pricing/home',                             [ClientsController::class, 'pricing'])->name('clients.pricing.home');
        Route::get('/clients/reports/storeitems',                       [ClientsController::class, 'storeItemQuantityForClients'])->name('clients.reports.storeitems');
        Route::get('/clients/reports/contracts',                        [ClientsController::class, 'contracts'])->name('clients.reports.contracts');
        Route::post('/clients/reports/contracts/search',                [ClientsController::class, 'contracts_search'])->name('clients.reports.contracts.search');
        Route::get('/clients/create',                                   [ClientsController::class, 'create'])->name('clients.create');
        Route::get('/clients/ban/{id}',                                 [ClientsController::class, 'ban'])->name('clients.ban');
        Route::post('/clients/store',                                   [ClientsController::class, 'store'])->name('clients.store');
        Route::get('/clients/view/{id}',                                [ClientsController::class, 'view'])->name('clients.view');
        Route::get('/clients/edit/{id}',                                [ClientsController::class, 'edit'])->name('client.edit');
        Route::post('/clients/update',                                  [ClientsController::class, 'update'])->name('clients.update');
        Route::get('/clients/delete/{id}',                              [ClientsController::class, 'delete'])->name('clients.delete');
        Route::get('/clients/status/{id}',                              [ClientsController::class, 'status'])->name('clients.status');
        Route::post('/clients/items/stats',                             [ClientsController::class, 'itemsQuantitiesForClients'])->name('clients.items.stats');
        Route::post('/clients/ajax',                                    [ClientsController::class, 'ajax_search'])->name('clients.aj');
        Route::post('/clients/search/items',                            [ClientsController::class, 'searchStoreItemsReport'])->name('clients.search.items');
        Route::get('/clients_settings/home',                            [ClientsController::class, 'settings'])->name('clients.settings');


        //Account clientsCategories.home
        Route::get('/clientsCategories/home',                           [ClientsCategoriesController::class, 'index'])->name('clientsCategories.home');
        Route::get('/clientsCategories/create',                         [ClientsCategoriesController::class, 'create'])->name('clientsCategories.create');
        Route::post('/clientsCategories/store',                         [ClientsCategoriesController::class, 'store'])->name('clientsCategories.store');
        Route::get('/clientsCategories/view/{id}',                      [ClientsCategoriesController::class, 'view'])->name('clientsCategories.view');
        Route::get('/clientsCategories/edit/{id}',                      [ClientsCategoriesController::class, 'edit'])->name('clientsCategories.edit');
        Route::post('/clientsCategories/update',                        [ClientsCategoriesController::class, 'update'])->name('clientsCategories.update');
        Route::get('/clientsCategories/delete/{id}',                    [ClientsCategoriesController::class, 'delete'])->name('clientsCategories.delete');
        Route::get('/clientsCategories/status/{id}',                    [ClientsCategoriesController::class, 'status'])->name('clientsCategories.status');

        // Vendors
        Route::get('/vendors/home',                                     [VendorsController::class, 'index'])->name('vendors.home');
        Route::get('/vendors/create',                                   [VendorsController::class, 'create'])->name('vendors.create');
        Route::post('/vendors/store',                                   [VendorsController::class, 'store'])->name('vendors.store');
        Route::get('/vendors/view/{id}',                                [VendorsController::class, 'view'])->name('vendors.view');
        Route::get('/vendors/edit/{id}',                                [VendorsController::class, 'edit'])->name('vendors.edit');
        Route::post('/vendors/update',                                  [VendorsController::class, 'update'])->name('vendors.update');
        Route::get('/vendors/delete/{id}',                              [VendorsController::class, 'delete'])->name('vendors.delete');
        Route::get('/vendors/status/{id}',                              [VendorsController::class, 'status'])->name('vendors.status');

        // Tables
        Route::get('/tables/home',                                      [TablesController::class, 'home'])->name('tables.home');
        Route::get('/tables/stats',                                     [TablesController::class, 'stats'])->name('tables.stats');
        Route::get('/table/create',                                     [TablesController::class, 'create'])->name('table.create');
        Route::post('/table/getInfo/',                                  [TablesController::class, 'getInfo'])->name('table.getInfo');
        Route::post('/table/store',                                     [TablesController::class, 'store'])->name('table.store');
        Route::get('/table/edit/{id}',                                  [TablesController::class, 'edit'])->name('table.edit');
        Route::post('/table/update',                                    [TablesController::class, 'update'])->name('table.update');
        Route::get('/table/delete/{id}',                                [TablesController::class, 'delete'])->name('table.delete');
        Route::get('/table/view/{id}',                                  [TablesController::class, 'view'])->name('table.view');
        Route::get('/tables/report',                                    [TablesController::class, 'report'])->name('table.report');
        Route::get('/tables/setting',                                   [TablesController::class, 'setting'])->name('tables.setting');
        Route::post('/tables/search',                                   [TablesController::class, 'search'])->name('tables.search');

        // Sections
        Route::get('/sections/home',                                    [SectionsController::class, 'home'])->name('sections.home');
        Route::get('/sections/create',                                  [SectionsController::class, 'create'])->name('sections.create');
        Route::get('/sections/view/{id}',                               [SectionsController::class, 'view'])->name('sections.view');
        Route::post('/sections/store',                                  [SectionsController::class, 'store'])->name('sections.store');
        
        // Rooms
        Route::get('/rooms/home',                                       [RoomsController::class, 'home'])->name('rooms.home');
        Route::get('/rooms/create',                                     [RoomsController::class, 'create'])->name('rooms.create');
        Route::post('/rooms/store',                                     [RoomsController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/edit/{id}',                                  [RoomsController::class, 'edit'])->name('rooms.edit');
        Route::post('/rooms/update',                                    [RoomsController::class, 'update'])->name('rooms.update');
        Route::get('/rooms/delete/{id}',                                [RoomsController::class, 'delete'])->name('rooms.delete');
        Route::post('/rooms/search',                                    [RoomsController::class, 'store'])->name('rooms.search');
        Route::get('/rooms/view/{id}',                                  [RoomsController::class, 'view'])->name('rooms.view');
        
        // Contacts
        Route::get('/contacts/home',                                    [ContactsController::class, 'index'])->name('contacts.home');
        Route::get('/contacts/create',                                  [ContactsController::class, 'create'])->name('contacts.create');
        Route::post('/contacts/store',                                  [ContactsController::class, 'store'])->name('contacts.store');
        Route::get('/contacts/edit/{id}',                               [ContactsController::class, 'edit'])->name('contacts.edit');
        Route::post('/contacts/update',                                 [ContactsController::class, 'update'])->name('contacts.update');
        Route::get('/contacts/destroy/{id}',                            [ContactsController::class, 'destroy'])->name('contacts.destroy');
        Route::post('/contacts/search',                                 [ContactsController::class, 'store'])->name('contacts.search');
        Route::get('/contacts/show/{id}',                               [ContactsController::class, 'show'])->name('contacts.show');

       
        
        // Store
        Route::get('/stores/home',                                      [StoresController::class, 'home'])->name('stores.home');
        // Route::get('/sections/home',                                    [StoresController::class, 'home'])->name('stores.sections');
        Route::get('/stores/create',                                    [StoresController::class, 'create'])->name('store.create');
        Route::post('/stores/store',                                    [StoresController::class, 'store'])->name('store.store');
        Route::get('/stores/edit/{id}',                                 [StoresController::class, 'edit'])->name('store.edit');
        Route::post('/stores/update',                                   [StoresController::class, 'update'])->name('store.update');
        Route::get('/stores/delete/{id}',                               [StoresController::class, 'delete'])->name('store.delete');
        Route::post('/stores/search',                                   [StoresController::class, 'store'])->name('store.search');
        Route::get('/stores/view/{id}',                                 [StoresController::class, 'view'])->name('store.view');
        
        // Box Sizes main operations in the application
        Route::get('/box/size/home',                                    [StoreBoxesController::class, 'home'])->name('box.size.home');
        Route::post('/box/size/store',                                  [StoreBoxesController::class, 'store'])->name('box.size.store');
        Route::post('/box/size/update',                                 [StoreBoxesController::class, 'update'])->name('box.size.update');
        Route::get('/box/size/destroy/{id}',                            [StoreBoxesController::class, 'destroy'])->name('box.size.destroy');
        Route::get('/box/size/stats',                                   [StoreBoxesController::class, 'stats'])->name('box.size.stats');
       
        Route::get('/stores/settings/home',                             [StoresController::class, 'settings'])->name('store.settings');
        Route::get('/storeArray/home',                                  [StoresController::class, 'storeArray'])->name('store.storeArray');
        Route::get('/stores/tables/position/{id}',                      [StoresController::class, 'table_position'])->name('stores.table.position');
        Route::post('/stores/save/tables/position',                     [StoresController::class, 'save_table_position'])->name('stores.save.table.position');

        
        
        // repository
        Route::get('/areas/home',                                       [StoresController::class, 'areas'])->name('areas.home');
        Route::get('/repositories',                                     [RepositoriesController::class, 'home']);
        Route::get('/repositories/home',                                [RepositoriesController::class, 'home'])->name('repositories.home');
        Route::get('/repositories/create',                              [RepositoriesController::class, 'create'])->name('repositories.create');
        Route::post('/repositories/store',                              [RepositoriesController::class, 'store'])->name('repositories.store');
        Route::get('/repositories/settings',                            [RepositoriesController::class, 'settings'])->name('repositories.settings');
        Route::get('/repositories/view/{id}',                           [RepositoriesController::class, 'view'])->name('repositories.view');
        Route::get('/repositories/edit/{id}',                           [RepositoriesController::class, 'edit'])->name('repositories.edit');
        Route::get('/repositories/delete/{id}',                         [RepositoriesController::class, 'delete'])->name('repositories.delete');

        // Items
        Route::get('/item/create',                                      [ItemsController::class, 'create'])->name('item.create');
        Route::get('/item/copy/{id}',                                   [ItemsController::class, 'copy'])->name('item.copy');
        Route::get('/item/view/{id}',                                   [ItemsController::class, 'view'])->name('item.view');
        Route::get('/item/edit/{id}',                                   [ItemsController::class, 'edit'])->name('item.show');
        Route::post('/item/store',                                      [ItemsController::class, 'store'])->name('item.store');
        Route::post('/item/update',                                     [ItemsController::class, 'update'])->name('item.update');
        Route::get('/item/delete/{id}',                                 [ItemsController::class, 'delete'])->name('item.delete');
        Route::get('/items/home',                                       [ItemsController::class, 'home'])->name('items.home');
        Route::get('/item/setting',                                     [ItemsController::class, 'setting'])->name('items.setting');
        Route::get('/item/mu/home',                                     [ItemsController::class, 'measuringUnitsHome'])->name('items.mu.home');
        Route::get('/item/mu/create',                                   [ItemsController::class, 'measuringUnitsCreate'])->name('items.mu.create');
        Route::post('/item/mu/insert',                                  [ItemsController::class, 'measuringUnitsInsert'])->name('items.mu.insert');
        Route::get('/item/mu/edit/{id}',                                [ItemsController::class, 'measuringUnitsEdit'])->name('items.mu.edit');
        Route::get('/item/mu/delete/{id}',                              [ItemsController::class, 'measuringUnitsDelete'])->name('items.mu.destroy');
        Route::post('/item/mu/update',                                  [ItemsController::class, 'measuringUnitsUpdate'])->name('items.mu.update');
        Route::get('/item/cats/create/{id}',                            [ItemsController::class, 'createItemCat'])->name('items.cats.create');
        Route::get('/item/cats/copy/{id}',                              [ItemsController::class, 'copyItemCat'])->name('items.cats.copy');
        Route::get('/item/cats/home',                                   [ItemsController::class, 'itemCatHome'])->name('items.cats.home');
        Route::get('/item/cats/edit/{id}',                              [ItemsController::class, 'itemCatEdit'])->name('items.cats.edit');
        Route::post('/item/cats/store',                                 [ItemsController::class, 'itemCatStore'])->name('items.cats.store');
        Route::post('/item/cats/update',                                [ItemsController::class, 'itemCatUpdate'])->name('items.cats.update');
        Route::get('/item/cats/view/{id}',                              [ItemsController::class, 'itemCatView'])->name('items.cats.view');
        Route::get('/item/cats/delete/{id}',                            [ItemsController::class, 'itemCatDelete'])->name('items.cats.delete');

        // support
        Route::get('/support/gallery/{id}',                             [SupportController::class, 'gallery'])->name('files.gallery');
        Route::post('/support/upload',                                  [SupportController::class, 'upload'])->name('files.upload');
        Route::post('/support/store',                                   [SupportController::class, 'store'])->name('support.store');
    }       
);

Route::group([
    'namespace'     => 'Admin',
    'prefix'        => 'admin',
    'middleware'    => 'guest:admin'
    ],
    function () {
        // Route::get('logout',                                    [LoginController::class, 'logout']);
        // Route::get('logout',                                    [LoginController::class, 'logout']);
        Route::get('/auth/login',                                       [LoginController::class, 'index'])->name('admin.auth.login');
        Route::post('login',                                            [LoginController::class, 'login'])->name('admin.login');
    }
);

Route::group([
    'namespace'     => 'Admin',
    'prefix'        => 'admin',
    'middleware'    => 'auth:admin'
    ],
    function () {

        Route::get('logout',                                [LoginController::class, 'logout'])->name('logout');
        Route::get('home/index',                            [HomeController::class, 'index'])->name('home.index');
        Route::get('admins/all',                            [AdminsController::class, 'index'])->name('display-admins-list');
        Route::get('admins/create',                         [AdminsController::class, 'create'])->name('create-new-admin');
        Route::get('admins/display/profile/{id}',           [AdminsController::class, 'display'])->name('display-admin');
        Route::get('admins/display/roles/{id}',             [AdminsController::class, 'displayRoles'])->name('display-admin-roles');
        Route::get('admins/display/log/{id}',               [AdminsController::class, 'displayLog'])->name('display-admin-log');
        Route::get('admins/edit/{id}',                      [AdminsController::class, 'edit'])->name('edit-admin-info');
        Route::get('admins/destroy/{id}',                   [AdminsController::class, 'destroy'])->name('destroy-admin');
        Route::post('admins/store/',                        [AdminsController::class, 'store'])->name('store-admin-info');
        Route::post('admins/update',                        [AdminsController::class, 'update'])->name('update-admin-info');
        Route::post('assign/role/to/admins',                [AdminsController::class, 'assignRoles'])->name('assign-role-to-admins');
        Route::get('assign/role/to/admin/{admin}/{role}',   [AdminsController::class, 'assignRole'])->name('assign-role-to-admin');
        Route::get('dettach/role/from/admin/{a}/{r}',       [AdminsController::class, 'dettachRole'])->name('dettach-role-from-admin');
        Route::post('dettach/roles/from/admins',            [AdminsController::class, 'assignRoles'])->name('dettach-roles-from-admin');

        //Roles
        Route::get('roles/index',                           [RolesController::class, 'index'])->name('display-roles-list');
        Route::get('roles/create',                          [RolesController::class, 'create'])->name('create-new-role');
        Route::get('roles/display/profile/{id}',            [RolesController::class, 'display'])->name('display-role');
        Route::get('roles/display/roles/{id}',              [RolesController::class, 'displayRoles'])->name('display-role-roles');
        Route::get('roles/display/log/{id}',                [RolesController::class, 'displayLog'])->name('display-role-log');
        Route::get('roles/edit/{id}',                       [RolesController::class, 'edit'])->name('edit-role-info');
        Route::get('roles/permissions/{id}',                [RolesController::class, 'permissions'])->name('role-permissions');
        Route::post('roles/attach/permissions/{id}',        [RolesController::class, 'attachPermissions'])->name('attach-permissions-to-role');
        Route::get('roles/dettach/permission/{id}',         [RolesController::class, 'dettachPermission'])->name('dettach-permission-from-role');
        Route::get('roles/destroy/{id}',                    [RolesController::class, 'destroy'])->name('destroy-role');
        Route::post('roles/store/',                         [RolesController::class, 'store'])->name('store-role-info');
        Route::post('roles/update',                         [RolesController::class, 'update'])->name('update-role-info');

        //Roles
        Route::get('permissions/index',                         [PermissionsController::class, 'index'])->name('display-permissions-list');
        Route::get('permissions/create',                        [PermissionsController::class, 'create'])->name('create-new-permission');
        Route::get('permissions/display/profile/{id}',          [PermissionsController::class, 'display'])->name('display-permission');
        Route::get('permissions/display/permissions/{id}',      [PermissionsController::class, 'displayPermissions'])->name('display-permission-permissions');
        Route::get('permissions/display/log/{id}',              [PermissionsController::class, 'displayLog'])->name('display-permission-log');
        Route::get('permissions/edit/{id}',                     [PermissionsController::class, 'edit'])->name('edit-permission-info');
        Route::get('permissions/destroy/{id}',                  [PermissionsController::class, 'destroy'])->name('destroy-permission');
        Route::post('permissions/store/',                       [PermissionsController::class, 'store'])->name('store-permission-info');
        Route::post('permissions/update',                       [PermissionsController::class, 'update'])->name('update-permission-info');

        //Menues
        Route::get('menues/index',                          [MenuesController::class, 'index'])->name('display-menues-list');
        Route::get('menues/create',                         [MenuesController::class, 'create'])->name('create-new-menu');
        Route::get('menues/create/submenu/{id}',            [MenuesController::class, 'createSubmenu'])->name('create-submenu');
        Route::get('menues/display/profile/{id}',           [MenuesController::class, 'display'])->name('display-menu');
        Route::get('menues/display/menu/{id}',              [MenuesController::class, 'displayPermissions'])->name('display-menue-menues');
        Route::get('menues/display/log/{id}',               [MenuesController::class, 'displayLog'])->name('display-menu-log');
        Route::get('menues/edit/{id}',                      [MenuesController::class, 'edit'])->name('edit-menu-info');
        Route::get('menues/destroy/{id}',                   [MenuesController::class, 'destroy'])->name('destroy-menu');
        Route::post('menues/store/',                        [MenuesController::class, 'store'])->name('store-menu-info');
        Route::post('menues/update',                        [MenuesController::class, 'update'])->name('update-menu-info');

        // Settings
        
    }
);
