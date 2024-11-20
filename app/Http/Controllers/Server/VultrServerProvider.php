<?php

namespace App\Http\Controllers\Server;

use App\Models\Instance;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VultrServerProvider implements ServerInterface
{

    private $data;

    public function setData($data): void
    {
        $this->data = $data;
        dump($this->data);
        dump("1. Data Submitted");
    }

    public function provision(): void
    {
        $apiKey = env('VULTR_API_KEY');
        if (!$apiKey) {
            throw new \Exception('Vultr API key is missing');
        }
        dump("2. Api Key checked");


        $osId = 1743; // Ubuntu 22.04 LTS x64
        $region = 'ams'; // Amsterdam

        dump('3. Ready to send Request');

        $response = Http::withToken($apiKey)
            ->post('https://api.vultr.com/v2/instances', [
                "region" => $region,
                "plan" => $this->data['server']['slug'],
                "label" => "Test Instance",
                "os_id" => $osId,
            ]);

        
        if ($response->successful()) {
            $jsonResponse = json_encode($response->json());

            if (isset($jsonResponse)) {
                $instance = Instance::create([
                    'user_id' => $this->data['user_id'],
                    'product_id' => $this->data['id'],
                    'server_id' => $this->data['server_id'],
                    'meta' => $jsonResponse
                ]);
                
                $product = Product::find($this->data['id']);
                if ($product) {
                    $product->provisioned();
                }

            } else {
                Log::error('Vultr API response does not contain instance data', ['response' => $jsonResponse]);
            }
        } else {
            Log::error('Vultr API Error', ['response' => $response->body()]);
            // Handle failure or throw an exception
        }
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
