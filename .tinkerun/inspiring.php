<?php

use App\Events\Order\OrderCreated;
use App\Models\Order;

OrderCreated::dispatch( Order::find(7) );