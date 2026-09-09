<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SirapiMailer
{
    /**
     * Kirim email menggunakan Brevo / Resend REST API (Port 443 HTTPS) dengan fallback ke Laravel Mail.
     *
     * @param string $to Alamat email penerima
     * @param string $subject Judul email
     * @param string $content Isi pesan (teks biasa atau HTML)
     * @param bool $isHtml True jika konten berformat HTML
     * @return bool
     * @throws \RuntimeException Jika pengiriman gagal
     */
    public static function send(string $to, string $subject, string $content, bool $isHtml = false): bool
    {
        // 1. Prioritaskan Brevo REST API jika API Key disetel
        $brevoApiKey = trim((string) (config('sirapi.brevo_api_key') ?: env('BREVO_API_KEY', '')));
        if ($brevoApiKey !== '') {
            try {
                return self::sendViaBrevo($brevoApiKey, $to, $subject, $content, $isHtml);
            } catch (\Throwable $e) {
                Log::warning("SirapiMailer: Brevo API gagal (" . $e->getMessage() . "), mencoba fallback ke SMTP default.");
            }
        }

        // 2. Gunakan Resend REST API jika API Key disetel
        $resendApiKey = trim((string) (config('sirapi.resend_api_key') ?: env('RESEND_API_KEY', '')));
        if ($resendApiKey !== '') {
            try {
                return self::sendViaResend($resendApiKey, $to, $subject, $content, $isHtml);
            } catch (\Throwable $e) {
                Log::warning("SirapiMailer: Resend API gagal (" . $e->getMessage() . "), mencoba fallback ke SMTP default.");
            }
        }

        // 3. Fallback ke driver default (SMTP/Sendmail)
        return self::sendViaDefaultMail($to, $subject, $content);
    }

    private static function sendViaBrevo(string $apiKey, string $to, string $subject, string $content, bool $isHtml): bool
    {
        $senderEmail = config('sirapi.brevo_sender_email') ?: env('BREVO_SENDER_EMAIL', env('MAIL_FROM_ADDRESS', 'sirapikabbogor@gmail.com'));
        $senderName = config('sirapi.brevo_sender_name') ?: env('BREVO_SENDER_NAME', env('MAIL_FROM_NAME', 'RAPID'));

        $htmlContent = $isHtml 
            ? $content 
            : '<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">'
                . '<h2 style="color: #107050; margin-bottom: 20px;">' . e($subject) . '</h2>'
                . nl2br(e($content))
                . '<hr style="margin-top: 30px; border: none; border-top: 1px solid #eee;">'
                . '<small style="color: #888;">Pesan otomatis dari Rapat dan Presensi Integrasi Dashboard (RAPID) Kabupaten Bogor.</small>'
            . '</div>';

        $textContent = $isHtml ? strip_tags($content) : $content;

        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
        ->timeout(10)
        ->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => $senderName,
                'email' => $senderEmail,
            ],
            'to' => [
                [
                    'email' => $to,
                ],
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
            'textContent' => $textContent,
        ]);

        if ($response->successful()) {
            $msgId = $response->json('messageId') ?? '-';
            Log::info("SirapiMailer: Email berhasil dikirim via Brevo API ke {$to}. (MessageID: {$msgId})");
            return true;
        }

        $errorMsg = $response->json('message') ?? $response->body();
        Log::error("SirapiMailer: Gagal kirim email via Brevo API ke {$to}. Respon: {$errorMsg}");
        throw new \RuntimeException("Brevo API: {$errorMsg}");
    }

    private static function sendViaResend(string $apiKey, string $to, string $subject, string $content, bool $isHtml): bool
    {
        $from = config('sirapi.resend_from_address') ?: env('RESEND_FROM_ADDRESS', 'RAPID <onboarding@resend.dev>');

        $htmlContent = $isHtml 
            ? $content 
            : '<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">'
                . '<h2 style="color: #107050; margin-bottom: 20px;">' . e($subject) . '</h2>'
                . nl2br(e($content))
                . '<hr style="margin-top: 30px; border: none; border-top: 1px solid #eee;">'
                . '<small style="color: #888;">Pesan otomatis dari Rapat dan Presensi Integrasi Dashboard (RAPID) Kabupaten Bogor.</small>'
            . '</div>';

        $textContent = $isHtml ? strip_tags($content) : $content;

        $response = Http::withToken($apiKey)
            ->timeout(10)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.resend.com/emails', [
                'from' => $from,
                'to' => [$to],
                'subject' => $subject,
                'html' => $htmlContent,
                'text' => $textContent,
            ]);

        if ($response->successful()) {
            $id = $response->json('id') ?? '-';
            Log::info("SirapiMailer: Email berhasil dikirim via Resend API ke {$to}. (ID: {$id})");
            return true;
        }

        $errorMsg = $response->json('message') ?? $response->body();
        Log::error("SirapiMailer: Gagal kirim email via Resend API ke {$to}. Respon: {$errorMsg}");
        throw new \RuntimeException("Resend API: {$errorMsg}");
    }

    private static function sendViaDefaultMail(string $to, string $subject, string $content): bool
    {
        Mail::raw($content, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });

        return true;
    }
}
