# BEAR.Sample05

`BEAR\Resource\ResourceObject::transfer` の型宣言と
`BEAR\Streamer\StreamTransferInject::transfer` の型宣言不一致によるエラー

## 手順

1. インストール

```bash
composer install --prefer-dist --no-dev
```

このプロジェクトを作成時は以下コマンド

```bash
composer create-project -n bear/skeleton app --prefer-dist --no-dev
```

結果

```
Installing bear/skeleton (1.7.5)
  - Installing bear/skeleton (1.7.5): Downloading (100%)
Created project in app
> BEAR\Skeleton\Composer::install
composer.json for my-vendor/my-project is created.
```

2. リクエスト確認をして正常動作を確認

```bash
composer page get /
```

3. ストリーム出力をするリソースを作成

`src/Resource/Page/Download.php` を作成

```php
<?php
declare(strict_types=1);
namespace MyVendor\MyProject\Resource\Page;

use BEAR\Resource\ResourceObject;
use BEAR\Streamer\StreamTransferInject;

class Download extends ResourceObject
{
    use StreamTransferInject;

    public $headers = [
        'Content-Type' => 'image/jpeg',
        'Content-Disposition' => 'attachment; filename="image.jpg"'
    ];

    public function onGet() : ResourceObject
    {
        $fp = fopen(__DIR__ . '/BEAR.jpg', 'rb');
        $this->body = $fp;

        return $this;
    }
}
```

4. ストリーム出力のリソースを実行するとエラーになる

```bash
composer page get /download
```

```
PHP Fatal error:  Declaration of BEAR\Streamer\StreamTransferInject::transfer(BEAR\Resource\TransferInterface $responder, array $server) must be compatible with BEAR\Resource\ResourceObject::transfer(BEAR\Resource\TransferInterface $responder, array $server): void in /var/www/vhosts/bear/app/src/Resource/Page/Download.php on line 8

Fatal error: Declaration of BEAR\Streamer\StreamTransferInject::transfer(BEAR\Resource\TransferInterface $responder, array $server) must be compatible with BEAR\Resource\ResourceObject::transfer(BEAR\Resource\TransferInterface $responder, array $server): void in /var/www/vhosts/bear/app/src/Resource/Page/Download.php on line 8
```