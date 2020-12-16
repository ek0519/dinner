# Lesson 7 Filesystem and formdata
###### tags: `Laravel` `Filesystem` `formdata`

---

## Configuration

`config/filesystems.php`

### setting default and clound filesystem disk
```php=
'default' => env('FILESYSTEM_DRIVER', 'local'),

'cloud' => env('FILESYSTEM_CLOUD', 's3'),

```

----

### Filesystem Disks

1. driver
Supported Drivers: "local", "ftp", "sftp", "s3" or other driver [gcs](https://github.com/Superbalist/laravel-google-cloud-storage)

2. root
root folder in filesystem.

3. url 
link prefix

4. visibility 
**public** or **private**

```php=
'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],

    ],

```

----

### Symbolic Links
create soft link from public folder to storage folder

```php=
'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
```

---

## The Local Driver

```php=
use Illuminate\Support\Facades\Storage;

Storage::disk('local')->put('example.txt', 'Contents');
```

---

## The Public Disk
To make these files accessible from the web, you should create a symbolic link from `public/storage` to `storage/app/public`.

To create the symbolic link, you may use the storage:link Artisan command:

```bash=
php artisan storage:link
```

----

You may configure additional symbolic links in your filesystems configuration file. Each of the configured links will be created when you run the storage:link command:

```php=
'links' => [
    public_path('storage') => storage_path('app/public'),
    public_path('images') => storage_path('app/images'),
],
```

---

## Obtaining Disk Instances
If your application interacts with multiple disks, you may use the disk method on the Storage facade to work with files on a particular disk:
```php=
Storage::disk('s3')->put('avatars/1', $content);
```

---

## Retrieving Files

```php=
$contents = Storage::get('file.jpg');
```
The exists method may be used to determine if a file exists on the disk:
```php=
if (Storage::disk('s3')->exists('file.jpg')) {
    // ...
}
```

---

## Downloading Files

```php=
return Storage::download('file.jpg');

return Storage::download('file.jpg', $name, $headers);
```

---

## File URLs

```php=
use Illuminate\Support\Facades\Storage;

$url = Storage::url('file.jpg');
```

---

## File Uploads
```php=
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAvatarController extends Controller
{
    /**
     * Update the avatar for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $path = $request->file('avatar')->store('avatars');

        return $path;
    }
}
```

----

You may also call the putFile method on the Storage facade to perform the same file storage operation as the example above:
```php=
$path = Storage::putFile('avatars', $request->file('avatar'));
```

---

## Specifying A File Name

```php=
$path = $request->file('avatar')->storeAs(
    'avatars', $request->user()->id
);
```
or
```php=
$path = Storage::putFileAs(
    'avatars', $request->file('avatar'), $request->user()->id
);
```

---

## Specifying A Disk

`store` method
```php=
$path = $request->file('avatar')->store(
    'avatars/'.$request->user()->id, 's3'
);
```
`storeAs` method
```php=
$path = $request->file('avatar')->storeAs(
    'avatars',
    $request->user()->id,
    's3'
);
```

---

## Other Uploaded File Information

* get upload file oreiginal name
```php=
$name = $request->file('avatar')->getClientOriginalName();
```
* get upload file extension
```php=
$extension = $request->file('avatar')->extension();
```

---

## File Visibility

default was private.
```php=
use Illuminate\Support\Facades\Storage;

Storage::put('file.jpg', $contents, 'public');
```


```php=
$path = $request->file('avatar')->storePubliclyAs(
    'avatars',
    $request->user()->id,
    's3'
);
```

---


## 作業

1. 在meals post的方法中加入檔案上傳功能
2. 在取得meals時，可以得到上傳檔案的url

### 參考 
1. [增加model的attribute](https://laravel.com/docs/8.x/eloquent-mutators#defining-an-accessor)
2. [預載attribute](https://laravel.com/docs/8.x/eloquent-serialization#appending-values-to-json)

## 讀書報告
* [Authentication-1](https://laravel.com/docs/8.x/authentication)