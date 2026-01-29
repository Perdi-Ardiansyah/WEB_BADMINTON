<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Jadwal extends BaseConfig
{
    public int $jamMulai = 8;   // default 08.00
    public int $jamSelesai = 22; // default 22.00
}
