<?php
namespace App\Factories\Server;

use App\Http\Controllers\Server\ServerInterface;

interface ServerFactoryInterface 
{
    public function createServer(): ServerInterface;
}