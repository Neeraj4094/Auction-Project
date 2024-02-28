<?php

use App\Http\Controllers\Admin\AuctionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GodownController;
use App\Http\Controllers\Admin\Inventory_imageController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/add-student',[StudentController::class,'add'])->name('add.student');
Route::post('/store-student',[StudentController::class,'store'])->name('store.student');
Route::get('/show-student',[StudentController::class,'index'])->name('show.student');
Route::get('/show-all-student',[StudentController::class,'allstudent'])->name('show.allstudent');
Route::get('/edit/student/{id}',[StudentController::class,'edit'])->name('edit.allstudent');
Route::post('/update/student',[StudentController::class,'update'])->name('update.student');
Route::get('/delete/student/{id}',[StudentController::class,'delete'])->name('delete.student');


Route::get('/add/employee',[CrudController::class,'add'])->name('add.employee');
Route::get('/crud',[CrudController::class,'create'])->name('create.employee');
Route::post('/add-employee',[CrudController::class,'store'])->name('store.employee');
Route::get('/fetch-employee',[CrudController::class,'show'])->name('show.employee');
Route::get('/fetch-all-employee',[CrudController::class,'get_students_data'])->name('show.all.employee');
Route::get('/edit-employee/{id}',[CrudController::class,'edit_employee'])->name('edit.employee');
Route::post('/update-employee',[CrudController::class,'update_employee'])->name('update.employee');
Route::get('/delete-employee/{id}',[CrudController::class,'delete_employee'])->name('delete.employee');



// Route::get('/', function () {
//     $url = "/register";
//     return view('admin.dashboard',compact('url'));
// });

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function (){
    Route::middleware('admin')->group(function(){
        // Admin Dashboard
        Route::get('/dashboard',[AdminController::class,'index']);
        
        // Location Related Routes Start
        Route::get('/location',[LocationController::class,'show'])->name('show.location_data');
        Route::get('/location/trash_data',[LocationController::class,'trash_data'])->name('show.location_trash_data');
        Route::get('/location/add',[LocationController::class,'add'])->name('add.location');
        Route::post('/location/store',[LocationController::class,'store'])->name('store.location');
        Route::get('/location/edit/{id}',[LocationController::class,'edit'])->name('edit.location');
        Route::post('/location/update/{id}',[LocationController::class,'update'])->name('update.location');
        Route::post('/location/delete/{id}',[LocationController::class,'delete'])->name('delete.location');
        Route::post('/location/restore/{id}',[LocationController::class,'restore_data'])->name('restore.location');
        // Location Related Routes End
        
        // Category Related Routes Start
        Route::get('/category',[CategoryController::class,'index'])->name('category');
        Route::get('/category/add',[CategoryController::class,'add'])->name('add.category');
        Route::post('/category/store',[CategoryController::class,'store'])->name('store.category');
        Route::get('/category/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
        Route::post('/category/update/{id}',[CategoryController::class,'update'])->name('category.update');
        Route::post('/category/delete/{id}',[CategoryController::class,'soft_delete'])->name('category.soft_delete');
        Route::get('/category/trash_data',[CategoryController::class,'category_trash_data'])->name('category.trash_data');

        // _______CATEGORY ROUTES________
        Route::get('/add-category',[CategoryController::class,'addCategory'])->name('add.new.category');
        Route::post('/store-category',[CategoryController::class,'storeCategory'])->name('store.new.category');
        Route::get('/show-category',[CategoryController::class,'showCategory'])->name('show.category');
        Route::get('/show-category-list',[CategoryController::class,'categoryLists'])->name('category.lists');
        // Category Related Routes End
        
        // Godown Related Routes Start
        Route::get('/godown',[GodownController::class,'index']);
        Route::get('/godown/add',[GodownController::class,'add'])->name('add.godown');
        Route::post('/godown/store',[GodownController::class,'store']);
        Route::get('/godown/edit/{id}',[GodownController::class,'edit'])->name('edit.godown');
        Route::post('/godown/update/{id}',[GodownController::class,'update']);
        Route::post('/godown/delete/{id}',[GodownController::class,'delete'])->name('delete.godown');
        Route::get('/godown/trash_data',[GodownController::class,'trash_data'])->name('delete.godown');
        Route::post('/godown/restore/{id}',[GodownController::class,'restore_data'])->name('restore_data.godown');
        // Godown Related Routes End
        
    });
});

Route::namespace('Manager')->prefix('manager')->name('manager.')->group(function (){
    Route::middleware('manager')->group(function(){
        // Manager Dashboard
        Route::get('/dashboard',[ManagerController::class,'index']);
    });
});

Route::middleware(['auth'])->group(function () {
    // Employee Dashboard
        Route::get('/dashboard',[UserController::class,'index']);

        // User Related Routes Start
        // Route::get('/add_user',[UserController::class,'add_user'])->name('user.add');
        // Route::post('/create',[RegisteredUserController::class,'store']);
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('admin.edit');
        Route::post('/update/{id}',[UserController::class,'update'])->name('admin.update');
        Route::post('/delete/{id}',[UserController::class,'delete'])->name('admin.delete');
        Route::get('/trash_data',[UserController::class,'trash_data'])->name('admin.trash_data');
        Route::post('/restore/{id}',[UserController::class,'restore_data'])->name('admin.restore_data');
        // User Related Routes End

        // Inventory Related Routes Start
        Route::get('/inventory',[InventoryController::class,'index']);
        Route::get('/inventory/add',[InventoryController::class,'add'])->name('add.inventory');
        Route::post('/inventory/store',[InventoryController::class,'store'])->name('store.inventory');
        Route::get('/inventory/edit/{id}',[InventoryController::class,'edit'])->name('edit.inventory');
        Route::post('/inventory/update/{id}',[InventoryController::class,'update'])->name('update.inventory');
        Route::post('/inventory/delete/{id}',[InventoryController::class,'delete'])->name('delete.inventory');
        Route::get('/inventory/trash_data',[InventoryController::class,'trash_data'])->name('trash_data.inventory');
        Route::post('/inventory/restore/{id}',[InventoryController::class,'restore_data'])->name('restore.inventory');
        // Inventory Related Routes End
        
        // Inventory Images Related Routes Start
        Route::get('/inventory_images',[Inventory_imageController::class,'index']);
        Route::get('/inventory_images/add',[Inventory_imageController::class,'add'])->name('add.inventory_images');
        Route::post('/inventory_images/store',[Inventory_imageController::class,'store'])->name('store.inventory_images');
        Route::get('/inventory_images/edit/{id}',[Inventory_imageController::class,'edit'])->name('edit.inventory_images');
        Route::post('/inventory_images/update/{id}',[Inventory_imageController::class,'update'])->name('update.inventory_images');
        Route::get('/inventory_images/trash_data',[Inventory_imageController::class,'trash_data'])->name('trash_data.inventory');
        Route::post('/inventory_images/delete/{id}',[Inventory_imageController::class,'delete'])->name('delete.inventory_images');
        Route::post('/inventory_images/restore/{id}',[Inventory_imageController::class,'restore_data'])->name('restore_data.inventory_images');
        // Inventory Images Related Routes End
        
        // Event Related Routes Start
        Route::get('/event',[EventController::class,'index']);
        Route::get('/event/add',[EventController::class,'add'])->name('add.event');
        Route::post('/event/store',[EventController::class,'store']);
        Route::get('/event/edit/{id}',[EventController::class,'edit'])->name('edit.event');
        Route::post('/event/update/{id}',[EventController::class,'update'])->name('update.event');
        Route::post('/event/delete/{id}',[EventController::class,'delete'])->name('delete.event');
        Route::get('/event/trash_data',[EventController::class,'trash_data'])->name('trash_data.event');
        Route::post('/event/restore/{id}',[EventController::class,'restore_data'])->name('restore.event');
        // Event Related Routes End
        
        // Auction Related Routes Start
        Route::get('/auction',[AuctionController::class,'index'])->name('index.auction');
        Route::get('/auction/add',[AuctionController::class,'add'])->name('add.auction');
        Route::post('/auction/create',[AuctionController::class,'create'])->name('create.auction');
        Route::get('/auction/edit/{id}/{user_id}',[EventController::class,'edit'])->name('edit.auction');
        Route::post('/auction/update/{id}',[AuctionController::class,'update'])->name('update.auction');
        Route::post('/auction/delete/{id}',[AuctionController::class,'delete'])->name('delete.auction');
        Route::get('/auction/trash_data',[AuctionController::class,'trash_data'])->name('trash_data.auction');
        // Auction Related Routes End
        // Route::get('/admin',[AdminController::class,'admintest']);
        // Route::get('/emp',[AdminController::class,'editortest']);
    });

Route::get('/',[HomeController::class,'auction_details'])->name('home');
Route::get('/add_user',[UserController::class,'add_user'])->name('user.add');
Route::post('/create',[RegisteredUserController::class,'store'])->name('store.user');
Route::get('/auction/inventory',[HomeController::class,'view_inventory']);
Route::get('/buy_now',[HomeController::class,'buy_now'])->name('buy_now');


// Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('auth')->group(function () {
   
// });
// Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function(){
    
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
