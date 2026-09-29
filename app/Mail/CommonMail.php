<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommonMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $mailSubject,
        public string $templateView,
        public array $templateData = [],
        public array $fileAttachments = [],
        public ?string $textTemplateView = null,
        public ?string $fromAddress = null,
        public array $ccAddresses = [],
        public array $bccAddresses = [],
        public string|array|null $replyToAddresses = null,
        public array $mailTags = [],
        public array $mailMetadata = [],
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->fromAddress,
            cc: $this->ccAddresses,
            bcc: $this->bccAddresses,
            replyTo: is_array($this->replyToAddresses)
                ? $this->replyToAddresses
                : array_filter([$this->replyToAddresses]),
            subject: $this->mailSubject,
            tags: $this->mailTags,
            metadata: $this->mailMetadata,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->templateView,
            text: $this->textTemplateView,
            with: $this->templateData,
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->fileAttachments as $attachment) {

            // Simple file path
            if (is_string($attachment)) {
                $attachments[] = Attachment::fromPath($attachment);

                continue;
            }

            // Advanced attachment
            if (is_array($attachment) && isset($attachment['path'])) {

                $file = Attachment::fromPath($attachment['path']);

                if (isset($attachment['as'])) {
                    $file = $file->as($attachment['as']);
                }

                if (isset($attachment['mime'])) {
                    $file = $file->withMime($attachment['mime']);
                }

                $attachments[] = $file;
            }
        }

        return $attachments;
    }
}
