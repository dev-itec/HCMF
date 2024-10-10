<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Answer;

class CasoCerradoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $denuncia;
    public $nombre_completo;
    public $fecha;
    public $hora;
    public $tipo_denuncia;
    public $identificador;
    public $clave;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @param Answer $denuncia
     * @param string|null $pdfPath
     */
    public function __construct(Answer $denuncia, $pdfPath, $fecha, $hora)
    {
        $this->denuncia = $denuncia;
        $this->pdfPath = $pdfPath;
        $fecha = Carbon::now()->format('d/m/Y');
        $hora = Carbon::now()->format('H:i:s');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject('Caso Cerrado - Denuncia '.$this->denuncia->identificador)
            ->view('emails.caso_cerrado')
            ->with([
                'denuncia' => $this->denuncia,
            ]);

        // Adjuntar el PDF si existe
        if ($this->pdfPath) {
            $email->attach(storage_path("/reportes/{$this->pdfPath}"));
        }

        return $email;
    }
}
