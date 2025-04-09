<?php

namespace App\Enums;

enum Permission: string
{
    case CREATE_PRODUCT = 'create product';
    case UPDATE_PRODUCT = 'update product';
    case DELETE_PRODUCT = 'delete product';
    
}
