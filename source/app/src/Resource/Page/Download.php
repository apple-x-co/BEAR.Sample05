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
