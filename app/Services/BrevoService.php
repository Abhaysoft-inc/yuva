<?php

namespace App\Services;

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BrevoService
{
    protected $apiInstance;
    protected $senderEmail;
    protected $senderName;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('services.brevo.api_key'));
        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
        $this->senderEmail = config('services.brevo.sender_email');
        $this->senderName = config('services.brevo.sender_name');
    }

    /**
     * Send email via Brevo API
     * 
     * @param string $toEmail Recipient email
     * @param string $toName Recipient name
     * @param string $subject Email subject
     * @param string $htmlContent HTML content
     * @param string|null $textContent Plain text content (optional)
     * @param array $attachments Array of attachments (optional)
     * @return array Response from Brevo API
     */
    public function sendEmail(
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlContent,
        ?string $textContent = null,
        array $attachments = []
    ): array {
        try {
            $sendSmtpEmail = new SendSmtpEmail();

            // Set sender
            $sendSmtpEmail['sender'] = [
                'name' => $this->senderName,
                'email' => $this->senderEmail
            ];

            // Set recipient
            $sendSmtpEmail['to'] = [
                ['email' => $toEmail, 'name' => $toName]
            ];

            // Set subject
            $sendSmtpEmail['subject'] = $subject;

            // Set content
            $sendSmtpEmail['htmlContent'] = $htmlContent;

            if ($textContent) {
                $sendSmtpEmail['textContent'] = $textContent;
            }

            // Set attachments if provided
            if (!empty($attachments)) {
                $sendSmtpEmail['attachment'] = $attachments;
            }

            // Send email
            $result = $this->apiInstance->sendTransacEmail($sendSmtpEmail);

            Log::info('Brevo email sent successfully', [
                'to' => $toEmail,
                'subject' => $subject,
                'message_id' => $result->getMessageId()
            ]);

            return [
                'success' => true,
                'message_id' => $result->getMessageId(),
                'data' => $result
            ];
        } catch (\Exception $e) {
            Log::error('Brevo email failed', [
                'to' => $toEmail,
                'subject' => $subject,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send email with PDF attachment
     * 
     * @param string $toEmail Recipient email
     * @param string $toName Recipient name
     * @param string $subject Email subject
     * @param string $htmlContent HTML content
     * @param string $pdfContent Base64 encoded PDF content
     * @param string $pdfFilename PDF filename
     * @return array Response from Brevo API
     */
    public function sendEmailWithPdf(
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlContent,
        string $pdfContent,
        string $pdfFilename
    ): array {
        $attachments = [
            [
                'content' => $pdfContent,
                'name' => $pdfFilename
            ]
        ];

        return $this->sendEmail($toEmail, $toName, $subject, $htmlContent, null, $attachments);
    }
}
