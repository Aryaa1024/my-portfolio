<?php

namespace App\Services;

use App\Mail\CommonMail;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * @param  string|array<int, string>  $recipients
     * @param  array{
     *     attachments?: array<int, string|array{path: string, as?: string, mime?: string}>,
     *     text_view?: string,
     *     from?: string,
     *     cc?: string|array<int, string>,
     *     bcc?: string|array<int, string>,
     *     reply_to?: string|array<int, string>,
     *     tags?: array<int, string>,
     *     metadata?: array<string, string|int>,
     *     mailer?: string,
     *     locale?: string,
     *     queue?: bool,
     *     delay?: DateTimeInterface|DateInterval|int
     * }  $options
     */
    public function send(
        string|array $recipients,
        string $subject,
        string $view,
        array $data = [],
        array $options = [],
    ): void {
        $mailable = new CommonMail(
            mailSubject: $subject,
            templateView: $view,
            templateData: $data,
            fileAttachments: $options['attachments'] ?? [],
            textTemplateView: $options['text_view'] ?? null,
            fromAddress: $options['from'] ?? null,
            ccAddresses: $this->addresses($options['cc'] ?? []),
            bccAddresses: $this->addresses($options['bcc'] ?? []),
            replyToAddresses: $options['reply_to'] ?? null,
            mailTags: $options['tags'] ?? [],
            mailMetadata: $options['metadata'] ?? [],
        );

        if (isset($options['mailer'])) {
            $mailable->mailer($options['mailer']);
        }

        $pendingMail = Mail::to($recipients);

        if (isset($options['locale'])) {
            $pendingMail->locale($options['locale']);
        }

        if ($options['queue'] ?? false) {
            if (isset($options['delay'])) {
                $pendingMail->later($options['delay'], $mailable);

                return;
            }

            $pendingMail->queue($mailable);

            return;
        }

        $pendingMail->send($mailable);
    }

    /**
     * @param  string|array<int, string>  $addresses
     * @return array<int, string>
     */
    private function addresses(string|array $addresses): array
    {
        return is_array($addresses) ? $addresses : [$addresses];
    }
}
