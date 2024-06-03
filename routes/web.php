<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\Admin\CategoryController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\Admin\CourseController;
use App\Http\Controllers\web\Admin\CourseLectureController;
use App\Http\Controllers\web\Admin\SectionController;
use App\Http\Controllers\web\Admin\VideoLessonController;
use App\Http\Controllers\web\Admin\PdfLessonController;
use App\Http\Controllers\web\User\UserProfileController;
use App\Http\Controllers\web\User\ProfileController;
use App\Http\Controllers\web\User\InstructorController;
use App\Http\Controllers\web\User\GetInstructorController;
use App\Http\Controllers\web\Courses\UserCourseController;
use App\Http\Controllers\web\Courses\CourseEnrollController;
use App\Http\Controllers\web\Courses\CourseLessonController;
use App\Http\Controllers\web\Carts\CartController;
use App\Http\Controllers\web\Carts\BuyController;
use App\Http\Controllers\web\Rates\RateController;
use App\Http\Controllers\web\Questions\QuestionController;
use App\Http\Controllers\web\Carts\CheckoutController;
use App\Http\Controllers\web\Carts\PayPalBuyController;
use App\Http\Controllers\web\Carts\PayPalPayoutController;
use App\Http\Controllers\web\Admin\OrderController;
use App\Http\Controllers\web\Admin\CouponController;
use App\Http\Controllers\web\Admin\UserController;
use App\Http\Controllers\web\Admin\Settings\GeneralSettingController;
use App\Http\Controllers\web\Admin\Settings\HomeSettingController;
use App\Http\Controllers\web\Admin\Settings\AboutSettingController;
use App\Http\Controllers\web\Admin\Settings\HomeSliderController;
use App\Http\Controllers\web\Admin\DashboardController;
use App\Http\Controllers\web\Locale\LocaleController;
use App\Http\Controllers\web\Search\SearchController;

/*Route::get('/', function () {
    return view('welcome');
});
*/

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.',
    'middleware' => 'auth',
], function () {
   // Route::get('/', 'HomeController@index')->name('AdminHome');

    Route::prefix('categories')->as('categories.')->group(function () {

        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::get('{category}', [CategoryController::class, 'show'])->name('show');
        Route::put('{category}', [CategoryController::class, 'update'])->name('update');
        Route::get('{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::delete('{category}/delete', [CategoryController::class, 'destroy'])->name('delete');

        Route::delete('CategoriesDeleteAll', [CategoryController::class, 'deleteAll'])->name('deleteAll');
    });

    Route::prefix('courses')->as('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::get('/{course}', [CourseController::class, 'show'])->name('show');
        Route::put('{course}', [CourseController::class, 'update'])->name('update');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::delete('/{course}/delete', [CourseController::class, 'delete'])->name('delete');

        Route::get('/course/{id}/sections/lectures', [CourseLectureController::class, 'show'])->name('lectures.show');
    });

    Route::prefix('sections')->as('sections.')->group(function () {
        Route::post('/section', [SectionController::class, 'store'])->name('store');
        //TODO:refactor the update route to take the section id in it instead in request
        Route::put('section', [SectionController::class, 'update'])->name('update');
        Route::delete('section/{id}', [SectionController::class, 'delete'])->name('delete');
    });

    Route::prefix('lessones.video')->as('lessones.video.')->group(function () {
        Route::post('lesson', [VideoLessonController::class, 'store'])->name('store');
        Route::put('lesson', [VideoLessonController::class, 'update'])->name('update');
        Route::delete('lesson/{id}', [VideoLessonController::class, 'delete'])->name('delete');
    });

    Route::prefix('lessones/pdf')->as('lessones.pdf.')->group(function () {
        Route::post('', [PdfLessonController::class, 'store'])->name('store');
        Route::put('update', [PdfLessonController::class, 'update'])->name('update');
        Route::delete('/{id}', [PdfLessonController::class, 'delete'])->name('delete');
    });

    Route::prefix('questions')->as('questions.')->group(function () {
        Route::get('/', [App\Http\Controllers\web\Admin\QuestionController::class, 'index'])->name('index');
        Route::put('/', [App\Http\Controllers\web\Admin\QuestionController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\web\Admin\QuestionController::class, 'delete'])->name('delete');
    });

    Route::prefix('orders')->as('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::delete('/{order}', [OrderController::class, 'delete'])->name('delete');
    });
    Route::prefix('coupons')->as('coupons.')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::get('/generate', [CouponController::class, 'generate'])->name('generate');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/edit/{coupon}', [CouponController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupon}', [CouponController::class, 'delete'])->name('delete');
    });

    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::delete('/{user}', [UserController::class, 'delete'])->name('delete');
    });

    Route::prefix('settings')->as('settings.')->group(function () {
        Route::get('/general', [GeneralSettingController::class, 'index'])->name('general.index');
        Route::put('/general', [GeneralSettingController::class, 'update'])->name('general.update');

        Route::get('/home', [HomeSettingController::class, 'index'])->name('home.index');
        Route::put('/home/{id}', [HomeSettingController::class, 'update'])->name('home.update');
        Route::put('/home/homeSlider/{id}', [HomeSliderController::class, 'Update'])->name('homeSlider.update');

        Route::get('/about', [AboutSettingController::class, 'index'])->name('about.index');
        Route::put('/about/{id}', [AboutSettingController::class, 'update'])->name('about.update');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});


Route::group([
    'prefix' => 'instructor',
    'namespace' => 'Instructor',
    'as' => 'instructor.',
    'middleware' => 'auth',
], function () {
    Route::prefix('courses')->as('courses.')->group(function () {
        Route::get('/', [App\Http\Controllers\web\Instructor\CourseController::class, 'index'])->name('index');
        Route::get('/create/step1', [App\Http\Controllers\web\Instructor\CourseController::class, 'createStep1'])->name('createStep1');
        Route::get('/create/step2', [App\Http\Controllers\web\Instructor\CourseController::class, 'createStep2'])->name('createStep2');
        Route::get('/create/complete-course/step3', [App\Http\Controllers\web\Instructor\CourseController::class, 'createCourseStep3'])
            ->name('createCourseStep3');
        Route::get('/create/complete-course/step4', [App\Http\Controllers\web\Instructor\CourseController::class, 'createCourseStep4'])
            ->name('createCourseStep4');
        Route::post('/', [App\Http\Controllers\web\Instructor\CourseController::class, 'store'])->name('store');
        Route::get('/{course}', [App\Http\Controllers\web\Instructor\CourseController::class, 'show'])->name('show');
        Route::put('/{course}', [App\Http\Controllers\web\Instructor\CourseController::class, 'update'])->name('update');
      //  Route::delete('/{course}/delete', [CourseController::class, 'delete'])->name('delete');

        Route::get('/{id}/sections/lectures', [App\Http\Controllers\web\Instructor\CourseLessonController::class, 'show'])
            ->name('lessons.show');
    });

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/index', [App\Http\Controllers\web\Instructor\ProfileController::class, 'index'])->name('index');
        Route::get('/{id}', [App\Http\Controllers\web\Instructor\ProfileController::class, 'show'])->name('show');
        Route::put('/', [App\Http\Controllers\web\Instructor\ProfileController::class, 'update'])->name('update');
        Route::delete('/', [App\Http\Controllers\web\Instructor\ProfileController::class, 'destroy'])->name('delete');
    });
});

Route::group([
    'middleware' => 'auth'
], function () {

    Route::prefix('profiles')->as('profiles.')->group(function () {
        Route::get('/create', [ProfileController::class, 'create'])->name('create');
        Route::put('/profile', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('instructors')->as('instructors.')->group(function () {
        Route::get('/create', [InstructorController::class, 'create'])->name('create');
        Route::post('/instructor', [InstructorController::class, 'store'])->name('store');

        Route::get('/getInstructor', [GetInstructorController::class, 'create'])->name('get.create');
    });

    Route::prefix('courses')->as('courses.')->group(function () {
        Route::get('/course/{id}', [App\Http\Controllers\web\Courses\CourseController::class, 'show'])->name('show');
    });
    Route::prefix('/user/courses')->as('user.courses.')->group(function () {
        Route::get('', [UserCourseController::class, 'index'])->name('index');
        Route::get('/{id}', [UserCourseController::class, 'show'])->name('show');
    });
    Route::post('/courses/enroll', [CourseEnrollController::class, 'store'])->name('course.enroll.store');

    Route::prefix('/user/courses')->as('course.lesson.')->group(function () {
        Route::get('/{courseId}/lesson/{lessonId}', [CourseLessonController::class, 'show'])->name('show');
        Route::post('/lesson', [CourseLessonController::class, 'store'])->name('store');
    });

    Route::prefix('carts')->as('carts.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::delete('/{id}', [CartController::class, 'delete'])->name('delete');
    });

    Route::prefix('rates')->as('courses.rate.')->group(function () {
        Route::post('/', [RateController::class, 'store'])->name('store');
    });
    Route::post('/buy', [BuyController::class, 'store'])->name('buy.store');

    Route::prefix('checkout')->as('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
    });

    Route::prefix('questions')->as('questions.')->group(function () {
        Route::post('/', [QuestionController::class, 'store'])->name('store');
        Route::put('/{id}', [QuestionController::class, 'update'])->name('update');
        Route::delete('/{id}', [QuestionController::class, 'delete'])->name('delete');
    });

    Route::prefix('paypal')->as('paypal.')->group(function () {
        Route::get('/return', [PayPalBuyController::class, 'return'])->name('return');
        Route::get('/buyNow/return', [PayPalBuyController::class, 'buyNowReturn'])->name('buynow.return');
        Route::delete('/cancel', [PayPalBuyController::class, 'delete'])->name('delete');

        Route::get('/payout', [PayPalPayoutController::class, 'index'])->name('payout.index');
        Route::post('/withdraw', [PayPalPayoutController::class, 'store'])->name('withdraw.store');
    });

    Route::prefix('coupons')->as('coupons.')->group(function () {
        Route::post('/apply', [App\Http\Controllers\web\Carts\CouponController::class, 'apply'])->name('apply');
        Route::delete('/delete', [App\Http\Controllers\web\Carts\CouponController::class, 'delete'])->name('delete');
    });
});

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Auth::routes();
Route::post('/lang', [LocaleController::class, 'store'])->name('changelang.store');

Route::get('/', [HomeController::class, 'index'])->name('home');
