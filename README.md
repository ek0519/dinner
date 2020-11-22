# Lesson 5 ORM in Controller

[![hackmd-github-sync-badge](https://hackmd.io/vyBIgyBQRIaBETNquA34gg/badge)](https://hackmd.io/vyBIgyBQRIaBETNquA34gg)

###### tags: `Laravel` `ORM` `Controller`

---

## [pagination](https://laravel.com/docs/8.x/pagination)


### DB Builder

```php=
DB::table('users')->paginate(15);
```

### Model

```php=
User::paginate();
```

per_page default  **15**

使用 **paginate** 會預設收 **page** 參數無須額外寫

----

### Appending To Pagination Links

```php=
$users->appends(['sort' => 'votes']);
```
or
```php=
$users->withQueryString();
```

----

### add other key

use Collection method **merge**

```php=
$custom = collect(['status' => Response::HTTP_OK]);
$data = $custom->merge($query->paginate($perPage)->withQueryString());
```

---

## parameter

```
example 
https://dinner.test/api/meals?price=70&per_page=10&page=2`
```
```php=
$price = $request->input('price')
```
or
```php=
$price = $request->price
```

$price : 70

---

## search 

### search Meal

```php=
public function index(Request $request)
{
    $query = Meal::query();
    if ($price = $request->input('price')) {
        $query->where('price', $price);
    }

    if ($meal_name = $request->input('meal_name')) {
        $query->where('meal_name', 'like', '%' . $meal_name . '%');
    }

    $perPage = $request->input('per_page') ?? 15;

    return $query->paginate($perPage)->withQueryString();
}
```

---

## Generalizing API Response

### create a trait

```php=
// App\Traits\ApiResponser.php

<?php

namespace App\Traits;


trait ApiResponser
{
    protected function successResponse($data, $code = 200, $message=null)
    {
        return response()->json([
            'status'=> $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($code, $message = null)
    {
        return response()->json([
            'status'=> $code,
            'message' => $message,
            'data' => null
        ], $code);
    }
}

```

----

### use trait in controller

```php=
<?php
....

use hApp\Traits\ApiResponser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponser;
}
```

----

### update response which in controller

before
```php=
return response()->json([
    'status'=> Response::HTTP_OK,
    'data' => $data
], Response::HTTP_OK);
```
after
```php=
return $this->successResponse($data);
```

---

## [Error Handling](https://laravel.com/docs/8.x/errors)

`app/Exceptions/Handler.php`
```php=
use App\Traits\ApiResponser;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    ........
    
    /**
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse|\Illuminate\Http\Response|Response|void
     */
    public function render($request, Throwable $e)
    {
        return $this->handleException($request, $e);
    }

    public function handleException(Request $request, Throwable $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(405, 'The specified method for the request is invalid');
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse(404, 'The specified URL cannot be found', );
        }

        if ($e instanceof HttpException) {
            return $this->errorResponse($e->getStatusCode(), $e->getMessage());
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        return $this->errorResponse(500, 'Unexpected Exception. Try later');
    }
}

```

----

`GET http://127.0.0.1:8000/meals/4000`

![](https://i.imgur.com/GZobsTR.png =600x)

[reference **Symfony\Component\HttpKernel\Exception**](https://github.com/symfony/symfony/tree/5.x/src/Symfony/Component/HttpKernel/Exception)

---

## 作業

- [ ] User 可以搜尋 `name` `mobile` `email` `status`，以及分頁功能 api
- [ ] Meal 可以搜尋 `price` `meal_name` 以及分頁功能 api


## 讀書報告
* [Blade-2/2](https://laravel.com/docs/8.x/blade#introduction)