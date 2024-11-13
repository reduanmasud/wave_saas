<?php 

namespace App\Factories\Server;

use App\Http\Controllers\Server\ServerInterface;
use App\Http\Controllers\Server\VultrServerProvider;

class VultrServerFactory implements ServerFactoryInterface
{

    public function createServer(): ServerInterface
    {
        return new VultrServerProvider();
    }
}