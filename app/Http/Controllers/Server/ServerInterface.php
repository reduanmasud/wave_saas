<?php
namespace App\Http\Controllers\Server;
interface ServerInterface
{
    public function provision(): void;
    public function destroy(): void;

    public function getIP(): string;

    public function setSSH(): string;

    public function getRootUser(): string;
    
    public function getRootPassword(): string;
}