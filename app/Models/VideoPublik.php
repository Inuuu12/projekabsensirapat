<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPublik extends Model
{
    use HasFactory;

    protected $table = 'sirapi_md_video';
    protected $primaryKey = 'id_video';
    protected $fillable = ['judul', 'deskripsi', 'youtube_url', 'youtube_embed_url'];
}
