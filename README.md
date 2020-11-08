# Lesson 2 Router, RESTful, Controller

[![hackmd-github-sync-badge](https://hackmd.io/Bfy048sIQfWu9wZI6hYb3Q/badge)](https://hackmd.io/Bfy048sIQfWu9wZI6hYb3Q)


###### tags: `Laravel` `Router` `controller`

---

## Router

簡單的(closure)直接return 
```php=
Route::get('foo', function () {
    return 'Hello World';
});

```
比較少會這樣寫....

----

我們比較喜歡....

```php=
use App\Http\Controllers\UserController;

Route::get('/user', [UserController::class, 'index']);

```

[參考](https://laravel.com/docs/8.x/routing#the-default-route-files)

----

### Route Parameters
[參考](https://laravel.com/docs/8.x/routing#route-parameters)

```php=
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
});
```
用 **{**變數**}** 放入變數

---

### [Route Groups](https://laravel.com/docs/8.x/routing#route-groups)
> Route groups allow you to share route attributes, such as middleware, across a large number of routes without needing to define those attributes on each individual route.

----

#### Middleware
```php=
Route::middleware(['first', 'second'])->group(function () {
    Route::get('/', function () {
        // Uses first & second middleware...
    });

    Route::get('user/profile', function () {
        // Uses first & second middleware...
    });
});
```

----

#### Route Prefixes

網址有共同的路徑
* /admin/users
* /admin/products
```php=


Route::prefix('admin')->group(function () {
    Route::get('users', function () {
        // Matches The "/admin/users" URL
    });
    
    Route::get('products', function () {
        // Matches The "/admin/users" URL
    });
});
```

---


## Controller

### [RESTful](https://laravel.com/docs/8.x/controllers#actions-handled-by-resource-controller)
`Representational state transfer `


![](https://i.imgur.com/miPVNOQ.png =600x)

----

#### get:
取資料，一般用於顯示，可用參數代資料，參數通常為可有可無的。
#### post
送資料，一用於新增資料，可以夾帶檔案(form-data)

----

#### put
整筆資料更新
#### patch
部分資料更新
#### delete
刪除資料用


----

### [HTTP Status Code](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status)

> **100** Informational responses (100–199),
**200** Successful responses (200–299),
**300** Redirects (300–399),
**400** Client errors (400–499),
**500** and Server errors (500–599).

---

## JSON(JavaScript Object Notation)

```json=
{
    "key": "value"
}

{
    "key": ["v", "a", "l", "u", "e"]
}

{
    "key": {
        "k": "value",
        "e": "value",
        "y": "value"
    }
}
```

---

### Basic Controllers

#### Create Controller

```bash=
php artisan make:controller [Model]Controller
```

##### example
```bash=
php artisan make:controller UserController
```

----

```php=
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
```

----

#### Single Action Controllers

```bash=
php artisan make:controller ShowProfile --invokable
```
```php=
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class ShowProfile extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function __invoke($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
```

----

##### In Router

```php=
use App\Http\Controllers\ShowProfile;

Route::get('user/{id}', ShowProfile::class);
```

----

#### JSON Response

```php=
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class ShowProfile extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function __invoke($id)
    {
        return response()->json([
            "key" => 'value'
        ], 200);
    }
}
```

---

## 作業
1. 完成 案子的 router
2. 完成 案子的 controller

## 讀書報告
* [request](https://laravel.com/docs/8.x/requests)








