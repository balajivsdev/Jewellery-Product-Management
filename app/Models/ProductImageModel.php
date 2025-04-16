<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table = 'product_images';
    protected $allowedFields = ['product_id', 'images'];
    protected $useTimestamps = true;
}
