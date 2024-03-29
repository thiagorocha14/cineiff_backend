<?php

namespace App\Mail;

use App\Models\SolicitacaoReserva;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitacaoReservaIndeferidaMail extends Mailable
{
    use Queueable, SerializesModels;

    private $solicitacao;

    /**
     * Create a new message instance.
     */
    public function __construct(SolicitacaoReserva $solicitacao)
    {
        $this->solicitacao = $solicitacao;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->solicitacao->nome_evento . ' - Solicitação de Reserva Indeferida',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.rejeitado',
            with: [
                'solicitacao' => $this->solicitacao,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}