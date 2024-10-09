<?php

namespace App\Mail;

use App\Models\DynamicText;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DenunciaRecibida extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre_completo;
    public $fecha;
    public $hora;
    public $tipo_denuncia;
    public $identificador;
    public $clave;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre_completo, $fecha, $hora, $tipo_denuncia, $identificador, $clave)
    {
        $this->nombre_completo = $nombre_completo;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->tipo_denuncia = $tipo_denuncia;
        $this->identificador = $identificador;
        $this->clave = $clave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            $dynamicText = DynamicText::where('seccion', 'email-body')->first();

            if($dynamicText) {
                return $this->subject('Denuncia recibida')
                ->view('emails.denuncia_recibida', compact('dynamicText')); // Se refiere a la vista del correo
            }
        } catch (Exception $e) {
            Log::error('Existe un error al momento de enviar el correo al denunciante: ' . $e);
        }
    }
}
