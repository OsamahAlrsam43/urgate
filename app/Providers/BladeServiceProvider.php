<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Print simple string for admin only
	    Blade::directive('foradmin', function ($string) {
		    return '<?php if(Auth::user()->type == \'Super Admin\' ) { echo "'.$string.'"; }?>';
	    });

	    // Print simple string for normal users only
	    Blade::directive('foruser', function ($string) {
		    return '<?php if(Auth::user()->type == \'User\' ) { echo "'.$string.'"; }?>';
	    });

	    // If user is admin
	    Blade::directive('isadmin', function ($string) {
		    return "<?php if(Auth::user()->type == 'Super Admin' ) { ?>";
	    });

	    Blade::directive('endisadmin', function ($string) {
		    return "<?php } ?>";
	    });

	    Blade::directive('required', function ($string) {
		    return '<span class="text-danger">*</span>';
	    });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
