<?php
namespace App\Http\Controllers\Server;

class VultrServerProvider implements ServerInterface 
{
    public function provision(): void
    {
        // VULTR-specific provision logic
    }

    public function destroy(): void
    {
        // VULTR-specific destroy logic
    }

    public function getIP(): string
    {
        // Return VULTR server IP
        return '192.168.1.1';
    }

    public function setSSH(): string
    {
        // Set up SSH for VULTR server
        return 'VULTR SSH Configured';
    }

    public function getRootUser(): string
    {
        return 'vultr-root';
    }

    public function getRootPassword(): string
    {
        return 'vultr-root-password';
    }
}