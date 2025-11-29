<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Admin\BookController as AdminBookController;

class BookController extends AdminBookController
{
    // Inherit all methods from Admin BookController
    // Petugas has same access to book management
}
