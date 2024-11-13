<?php

namespace App\Enums;

enum ServerProvider: string
{
    case VULTR = 'vultr';
    case HETZNER = 'hetzner';
    case AWS = 'aws';
    case DigitlOcean = 'digitalocean';
    case GCP = 'gcp';
}