<?php

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

Route::get('Homepage', ['uses' => 'PagesController@getDashboard', 'as' => 'Dashboard']);
Route::get('Customer', ['uses' => 'PagesController@getCustomerView' , 'as' => 'Customer']);
Route::get('Pricelist', ['uses' => 'PagesController@getPriceCustomerView', 'as' => 'Pricelist']);
Route::get('Cylinder', ['uses' => 'PagesController@getCylinderBalance', 'as' => 'Cylinder']);
Route::get('Purchase_Order', ['uses' => 'PagesController@getPurchaseOrder', 'as' => 'Purcase_Order']);
Route::get('SystemUtilities/SystemUsers', ['uses' => 'PagesController@getSystemUsers', 'as' => 'SystemUsers']);
Route::get('/', ['uses' => 'PagesController@getLogin' , 'as' => 'loginPage']);
route::post('Login', ['uses' => 'PagesController@postLogin' , 'as' => 'Userlogin']);

// Resources Exception

// Get
Route::get('PriceController/create/{id}', ['uses' => 'PriceController@create', 'as' => 'PriceController.create']);
Route::get('CylinderController/create/{id}', ['uses' => 'CylinderController@create', 'as' => 'CylinderController.create']);
Route::get('SalesInvoice/create/{id}', ['uses' => 'SalesInvoiceController@create', 'as' => 'SalesInvoiceController.create']);
Route::get('ICR/create/{id}', ['uses' => 'ICRController@create', 'as' => 'ICRController.create']);
Route::get('CLC/create/{id}', ['uses' => 'CLCController@create', 'as' => 'CLCController.create']);
Route::get('DR/create/{id}', ['uses' => 'DRController@create', 'as' => 'DRController.create']);
Route::get('OR/create/{id}', ['uses' => 'ORController@create', 'as' => 'ORController.create']);
Route::get('Sales/AddInvoice', ['uses' => 'SalesInvoice@create', 'as' => 'Sales.create']);
// Post
Route::post('CylinderController/delete', ['uses' => 'CylinderController@destroy', 'as' => 'CylinderController.destroy']);


// Jquery Controller

// Declaration Controller

//GET
Route::get('viewSalesInvoiceDeclaration/{id}', ['uses' => 'DeclarationController@viewSalesDeclaration' , 'as' => 'viewSD']);
Route::get('viewICRDeclaration/{id}', ['uses' => 'DeclarationController@viewicrDeclaration' , 'as' => 'viewICR']);
Route::get('viewCLCDeclaration/{id}', ['uses' => 'DeclarationController@viewclcDeclaration' , 'as' => 'viewCLC']);
Route::get('viewDRDeclaration/{id}', ['uses' => 'DeclarationController@viewdrDeclaration' , 'as' => 'viewDR']);
Route::get('viewORDeclaration/{id}', ['uses' => 'DeclarationController@vieworDeclaration' , 'as' => 'viewOR']);


//POST
Route::post('updateSalesInvoiceDeclaration', ['uses' => 'DeclarationController@updateSalesDeclaration' , 'as' => 'updateSD']);
Route::post('updateICRDeclaration', ['uses' => 'DeclarationController@updateICRDeclaration' , 'as' => 'updateICR']);
Route::post('updateCLCDeclaration', ['uses' => 'DeclarationController@updateCLCDeclaration' , 'as' => 'updateCLC']);
Route::post('updateDRDeclaration', ['uses' => 'DeclarationController@updateDRDeclaration' , 'as' => 'updateDR']);
Route::post('updateORDeclaration', ['uses' => 'DeclarationController@updateORDeclaration' , 'as' => 'updateORDeclaration']);

//POST DELETE

Route::post('deleteSales', ['uses' => 'DeclarationController@deleteInvoice' , 'as' => 'deleteSALES']);
Route::post('deleteIcr', ['uses' => 'DeclarationController@deleteIcr' , 'as' => 'deleteICR']);
Route::post('deleteClc', ['uses' => 'DeclarationController@deleteClc' , 'as' => 'deleteCLC']);
Route::post('deleteDr', ['uses' => 'DeclarationController@deleteDr' , 'as' => 'deleteDR']);
Route::post('deleteOr', ['uses' => 'DeclarationController@deleteOr' , 'as' => 'deleteOR']);

//Sales Record Update

Route::post('UpdateCLC', ['uses' => 'SalesRecordUpdate@updateCLC', 'as' => 'UpdateCLC']);
Route::post('UpdateICR', ['uses' => 'SalesRecordUpdate@updateICR', 'as' => 'UpdateICR']);
Route::post('UpdateDR', ['uses' => 'SalesRecordUpdate@updateDELIVER', 'as' => 'UpdateDELIVER']);
Route::post('UpdateDRSALES', ['uses' => 'SalesRecordUpdate@updateDELIVERSALES', 'as' => 'UpdateDELIVERSALES']);
Route::post('UpdateSALES', ['uses' => 'SalesRecordUpdate@updateSALES', 'as' => 'updateSALES']);
Route::post('UpdateOR', ['uses' => 'SalesRecordUpdate@updateOR', 'as' => 'updateOR']);
Route::post('updatePR', ['uses' => 'SalesRecordUpdate@updatePR', 'as' => 'updatePR']);



//Sales Record Product Delete

Route::post('DeleteCLC', ['uses' => 'DeleteSalesProduct@deleteCLC', 'as' => 'productCLC']);


// Get
Route::get('getProductSize', ['uses'  => 'JqueryController@prodCodeToSize' , 'as' => 'getProductSize']);
Route::get('getProductSize2', ['uses'  => 'JqueryController@getProductSize2' , 'as' => 'getProductSize2']);
Route::get('getProductPO', ['uses'  => 'JqueryController@getProductPO' , 'as' => 'getProductPO']);
Route::get('getProductSizePO', ['uses'  => 'JqueryController@getProductSizePO' , 'as' => 'getProductSizePO']);
Route::get('InvoiceModal', ['uses' => 'JqueryController@invoiceNoModal' , 'as' => 'invoiceModal']);
Route::get('getICRPRoduct', ['uses' => 'JqueryController@icrProduct' , 'as' => 'icrProduct']);
Route::get('getICRProductDetails', ['uses' => 'JqueryController@icrProductDetails' , 'as' => 'icrProductDetails']);
// Post
Route::post('updateProductPrice', ['uses' => 'JqueryController@updateProductPrice', 'as' => 'updatePrice']);
Route::post('noValidate', ['uses' => 'JqueryController@noValidate', 'as' => 'noValidate']);
Route::post('poCustomerDetails', ['uses' => 'JqueryController@poCustomerDetails', 'as' => 'poCustDetails']);
Route::post('poProductDetails', ['uses' => 'JqueryController@poProductDetails', 'as' => 'poProdDetails']);
Route::post('getClientSalesInvoice', ['uses' => 'JqueryController@client_sales_invoice', 'as' => 'clientsalesinvoice']);
Route::post('getClientSalesInvoice2', ['uses' => 'JqueryController@client_sales_invoice2', 'as' => 'clientsalesinvoice2']);
Route::post('validateCylinderType', ['uses' => 'JqueryController@cylinder_type_validation', 'as' => 'cylinderTypeValidation']);
Route::post('customer_po', ['uses' => 'JqueryController@customer_po', 'as' => 'customerpo']);
Route::post('DeletePricelist', ['uses' => 'JqueryController@delete_pricelist', 'as' => 'delete_pricelist']);


// Resoures

Route::resource('CustomerController', 'CustomerController');
Route::resource('PriceController', 'PriceController' , ['except' => 'create']);
Route::resource('CylinderController', 'CylinderController' , ['except' => ['create','destroy']]);
Route::resource('PurchaseOrderController', 'PurchaseOrderController');
Route::resource('SystemUsersController', 'SystemUsersController');
Route::resource('SalesRepController', 'SalesRepController');
Route::resource('SalesInvoice', 'SalesInvoiceController', ['except' => 'create']);
Route::resource('ICRDeclaration', 'ICRController', ['except' => 'create']);
Route::resource('CLCDeclaration', 'CLCController', ['except' => 'create']);
Route::resource('DRDeclaration', 'DRController', ['except' => 'create']);
Route::resource('ORDeclaration', 'ORController', ['except' => 'create']);
Route::resource('Sales', 'SalesInvoice', ['except' => ['create'] ]);
Route::resource('CylinderReceipt', 'CylinderReceipt');
Route::resource('CylinderLoan', 'CylinderLoan');
Route::resource('Deliver', 'DeliverController');
Route::resource('DeliverSales','DeliverSalesinvoice');
Route::resource('OfficialReceipt', 'OfficialReceipt');
Route::resource('ProvisionalReceipt', 'ProvisionalController');

// Reports

Route::get('getUserAccounts', ['uses'=> 'ReportPageController@viewStatementReport', 'as' => 'StatementReport']);

Route::post('statementReport', ['uses'=> 'ReportPageController@statement_report', 'as' => 'statement_report']);

Route::get('agingReport', ['uses'=> 'ReportPageController@aging_account', 'as' => 'aging_account']);
Route::get('agingView', ['uses' => 'ReportPageController@view_aging', 'as' => 'viewaging']);
Route::post('agingView2', ['uses' => 'ReportPageController@view_aging2', 'as' => 'viewaging2']);

Route::post('summaryReport', ['uses'=> 'ReportPageController@summary_account', 'as' => 'summary_account']);
Route::post('statementcylinder', ['uses'=> 'ReportPageController@statement_cylinder', 'as' => 'statement_cylinder']);


Route::get('Logout', ['uses'=> 'PagesController@AccountLogout', 'as' => 'Logout']);

// DataTables Controller

Route::get('SalesInvoiceData', ['uses' => 'PagesDatatablesController@sales_invoice_data', 'as'=>'sales_invoice_data']);
Route::get('DeliveryInvoiceDate', ['uses' => 'PagesDatatablesController@delivery_sales', 'as'=>'delivery_sales_data']);
Route::get('DeliveryDate', ['uses' => 'PagesDatatablesController@delivery_sales_2', 'as'=>'delivery_sales_data2']);
Route::get('official_receipt_data', ['uses' => 'PagesDatatablesController@official_receipt_data', 'as'=>'official_receipt_data']);
Route::get('provisional_data', ['uses' => 'PagesDatatablesController@provisional_data', 'as'=>'provisional_data']);

Route::get('dashboard_data', ['uses' => 'PagesDatatablesController@dashboard_data', 'as'=>'dashboard_data']);

