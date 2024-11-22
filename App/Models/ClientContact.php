<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    use HasFactory;

    protected $table = 'clients_contacts';

    protected $fillable = ['client', 'contact', 'role', 'updated_at', 'created_by', 'updated_by', 'status'];
}
