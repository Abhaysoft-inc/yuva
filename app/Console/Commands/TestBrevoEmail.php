<?php

namespace App\Console\Commands;

use App\Services\BrevoService;
use Illuminate\Console\Command;

class TestBrevoEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brevo:test {email : The email address to send test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Brevo API email sending functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $this->info('Testing Brevo API email...');
        $this->info('Sending to: ' . $email);
        $this->newLine();

        try {
            $brevoService = new BrevoService();

            $subject = 'Test Email - Brevo API Integration';
            $htmlContent = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: linear-gradient(135deg, #2d7a5e 0%, #1a5c8a 100%); 
                              color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
                    .content { background: #f9f9f9; padding: 30px; border: 2px solid #2d7a5e; 
                               border-top: none; border-radius: 0 0 10px 10px; }
                    .success { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; 
                               border-radius: 5px; color: #155724; margin: 20px 0; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>✉️ Test Email Successful!</h1>
                        <p>Yuva Maitree Foundation</p>
                    </div>
                    <div class="content">
                        <h2>Hello!</h2>
                        <p>This is a test email from <strong>Yuva Maitree Foundation</strong> using Brevo API.</p>
                        
                        <div class="success">
                            <strong>✓ Success!</strong><br>
                            Your Brevo API integration is working correctly!
                        </div>
                        
                        <h3>Configuration Details:</h3>
                        <ul>
                            <li><strong>Method:</strong> Brevo Transactional Email API</li>
                            <li><strong>API Key:</strong> Configured</li>
                            <li><strong>Status:</strong> Active</li>
                        </ul>
                        
                        <p>You can now send donation receipts and other transactional emails via Brevo API.</p>
                        
                        <p style="margin-top: 30px;">
                            <strong>Best regards,</strong><br>
                            <span style="color: #2d7a5e; font-size: 18px;">Yuva Maitree Foundation</span>
                        </p>
                    </div>
                </div>
            </body>
            </html>';

            $result = $brevoService->sendEmail(
                $email,
                'Test Recipient',
                $subject,
                $htmlContent
            );

            if ($result['success']) {
                $this->newLine();
                $this->info('✓ SUCCESS! Email sent successfully!');
                $this->info('Message ID: ' . $result['message_id']);
                $this->newLine();
                $this->comment('Check your inbox at: ' . $email);
                $this->comment('Note: Check spam folder if you don\'t see the email.');
                return Command::SUCCESS;
            } else {
                $this->newLine();
                $this->error('✗ FAILED! Could not send email.');
                $this->error('Error: ' . $result['error']);
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('✗ ERROR! ' . $e->getMessage());
            $this->newLine();
            $this->comment('Please check:');
            $this->comment('1. BREVO_API_KEY is set in your .env file');
            $this->comment('2. Your Brevo API key is valid');
            $this->comment('3. Your sender email is verified in Brevo');
            return Command::FAILURE;
        }
    }
}
