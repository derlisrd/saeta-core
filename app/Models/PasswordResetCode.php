<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PasswordResetCode extends Model
{


    protected $table = 'password_reset_codes';
    protected $fillable = ['email', 'code', 'expires_at'];
    
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    
    public $timestamps = false;
    
    public static function generateCode($email)
    {
        // Eliminar códigos anteriores del mismo email
        self::where('email', $email)->delete();
        
        // Generar código de 4 dígitos
        $code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        
        // Crear nuevo código con expiración de 15 minutos
        return self::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);
    }
    
    public static function verifyCode($email, $code)
    {
        $resetCode = self::where('email', $email)
                         ->where('code', $code)
                         ->where('expires_at', '>', Carbon::now())
                         ->first();
                         
        return $resetCode;
    }
    
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }
}
