# Laravel Admin Scaffolding based on Laravel 5.3

#Dependecies
 1. [Laravel Uuid 2.*](https://github.com/webpatser/laravel-uuid) [User model uses uuid v4 as primary key]


#Instructions to install
	1. composer install
	2. php artisan migrate
	3. php artisan db:seed

#Process Description 
	1. Install Laravel composer create-project --prefer-dist laravel/laravel laravel-admin
	2. Scaffolding of authentication php artisan make:auth 
	3. Install [Laravel Uuid 2.*](https://github.com/webpatser/laravel-uuid).
	4. Change id column type of users table from unsigned integer to uuid.
	5. Create Traits\Uuid and add line use \App\Traits\Uuid; in User model.
	6. Set incrementing property false  in User model, adding public $incrementing=false; 
	7. Create Role model with migration 
		php artisan make:model Admin\Role --migration

		migration :
			Schema::create('roles', function (Blueprint $table) {
	            $table->increments('id');
	            $table->string('name');
	            $table->timestamps();
	        });

	8. Create intermediate role_user table
		php artisan make:migration create_role_user_table
		
		migration :
			 Schema::create('role_user', function (Blueprint $table) {
	            $table->increments('id');
	            $table->uuid('user_id');
	            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
	            $table->integer('role_id')->unsigned();
	            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
	            $table->timestamps();
	        });

	9. Make Admin and Role seeds
		php artisan make:seed AdminSeed
		php artisan make:seed RoleSeed

		AdminSeed :

		public function run()
    	{
			$admins=[
	        	[
	        		'name'=>'admin',
	        		'email'=>'admin@admin.com',
	        		'password'=>bcrypt('password')
	        	]
	        ];
	        foreach($admins as $key=>$admin)
	        {
	        	$user=\App\User::firstOrCreate($admin);
	        	$user->roles()->attach(1);//1 is admin id by default
	        };
	    }
	    RoleSeed :

		public function run()
    	{
	    	$roles=['admin','superadmin'];//admin seed needs to be changed if this array changed
	        foreach ($roles as $key => $role) {
	        	\App\Models\Admin\Role::firstOrCreate(['name'=>$role]);
	        };
	    }
	  9. Run the seeds php artisan db:seed
	  10. Create middleware Admin, php artisan make:middleware Admin

	  	configure it, at app\Http\Middleware\Admin.php,

	  	public function handle($request, Closure $next)
	    {
	        if(!Auth::user()->isAdmin()){
	            return redirect('/home')->with('error','You are not authorized!');
	        }
	        
	        return $next($request);
	    }
	  11. Before able to use Admin middleware we need to register it at Kernel.php by adding 
	  	'admin' => \App\Http\Middleware\Admin::class,  at $routeMiddleware array and add  two functions roles and isAdmin to User model as 

	  	public function roles()
	    {
	    	//Many to many relationship
	        return $this->belongsToMany('\App\Models\Admin\Role');
	    }
	    public function isAdmin()
	    {
	    	//Check to admin role
	        return $this->roles()->where('name','admin')->first();
	    }

	   12. To test the middleware create a test route with 'auth' and 'admin' as middlewares.

