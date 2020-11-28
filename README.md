# Lesson 6 Validation Guzzle
###### tags: `Laravel` `Validation` `Guzzle`

---

## Writing The Validation Logic
```php=
public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
    ]);

    // The blog post is valid...
}
```

---

### A Note On Nested Attributes

If your HTTP request contains "nested" parameters, you may specify them in your validation rules using "dot" syntax:

```php=
$request->validate([
    'title' => 'required|unique:posts|max:255',
    'author.name' => 'required',
    'author.description' => 'required',
]);
```

---

### A Note On Optional Fields

use **nullable**

```php=
$request->validate([
    'title' => 'required|unique:posts|max:255',
    'body' => 'required',
    'publish_at' => 'nullable|date',
]);
```

---

## Form Request Validation

### Creating Form Requests


 To create a form request class, use the make:request Artisan CLI command:
 
```bash=
php artisan make:request AddMeal
```

----

The generated class will be placed in the **app/Http/Requests** directory. If this directory does not exist, it will be created when you run the **make:request** command. Let's add a few validation rules to the rules method:

```php=
/**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'meal_name' => 'required|min:2',
            'price' => 'required|integer',
            'description' => 'nullable',
            'meal_img' => 'nullable|image',
        ];
    }
```

----

So, how are the validation rules evaluated? All you need to do is type-hint the request on your controller method. The incoming form request is validated before the controller method is called, meaning you do not need to clutter your controller with any validation logic:

----

```php=
/**
 * Store the incoming blog post.
 *
 * @param  StoreBlogPost  $request
 * @return Response
 */
public function store(StoreBlogPost $request)
{
    // The incoming request is valid...

    // Retrieve the validated input data...
    $validated = $request->validated();
}
```

----

If validation fails, a redirect response will be generated to send the user back to their **previous location**. The errors will also be flashed to the session so they are available for display. If the request was an AJAX request, an HTTP response with a **422** status code will be returned to the user including a JSON representation of the validation errors.

----

### Authorizing Form Requests

The form request class also contains an **authorize** method. Within this method, you may check if the authenticated user actually has the authority to update a given resource. For example, you may determine if a user actually owns a blog comment they are attempting to update:

----

```php=
/**
 * Determine if the user is authorized to make this request.
 *
 * @return bool
 */
public function authorize()
{
    $comment = Comment::find($this->route('comment'));

    return $comment && $this->user()->can('update', $comment);
}
```

----

If the **authorize** method returns **false**, an HTTP response with a **403** status code will automatically be returned and your controller method will not execute.


----

If you plan to have authorization logic in another part of your application, return true from the authorize method:

```php=
/**
 * Determine if the user is authorized to make this request.
 *
 * @return bool
 */
public function authorize()
{
    return true;
}
```

---

## [Available Validation Rules](https://laravel.com/docs/8.x/validation#available-validation-rules)

---

---

## 作業

- [ ] 把所有送入 `post` `put` `patch` 的資料都做驗證

## 讀書報告
* [relationship](https://laravel.com/docs/8.x/eloquent-relationships#introduction)