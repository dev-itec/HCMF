<?php

namespace App\Mail;

use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstadoDenunciaActualizado extends Mailable
{
    use Queueable, SerializesModels;

    public $denuncia;
    public $nuevoEstado;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Answer $denuncia
     * @param string $nuevoEstado
     * @return void
     */
    public function __construct(Answer $denuncia, $nuevoEstado)
    {
        $this->denuncia = $denuncia;
        $this->nuevoEstado = $nuevoEstado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Estado de su denuncia ha sido actualizado')
            ->view('emails.denuncia_estado_actualizado')
            ->with([
                'denuncia' => $this->denuncia,
                'nuevoEstado' => $this->nuevoEstado,
            ]);
    }
}
