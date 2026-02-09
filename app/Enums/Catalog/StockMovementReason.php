<?php

namespace App\Enums\Catalog;

enum StockMovementReason : string
{
 case Receipt = 'receipt';
 case Sale = 'sale';
 case Adjustment = 'adjustment';
 case Return = 'return';


}
