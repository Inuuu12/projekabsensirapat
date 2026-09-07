<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Pegawai SIRAPI</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #2d3748;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f7f6; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0f513f 0%, #163830 100%); padding: 32px 30px; text-align: center;">
                            <div style="font-size: 11px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: #a7f3d0; margin-bottom: 6px;">
                                PEMERINTAH KABUPATEN BOGOR
                            </div>
                            <h1 style="margin: 0; font-size: 22px; font-weight: 900; color: #ffffff; letter-spacing: -0.5px;">
                                RAPID &bull; SIRAPI
                            </h1>
                            <p style="margin: 6px 0 0 0; font-size: 13px; color: #d1fae5; font-weight: 500;">
                                Rapat dan Presensi Integrasi Dashboard
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px;">
                            <h2 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 800; color: #0f513f;">
                                Halo, {{ $nama }}! 👋
                            </h2>
                            <p style="margin: 0 0 20px 0; font-size: 14px; line-height: 1.6; color: #4a5568;">
                                Akun Pegawai Anda untuk portal **SIRAPI Kabupaten Bogor** telah berhasil dibuat oleh Administrator. Berikut adalah rincian kredensial akun Anda:
                            </p>

                            <!-- Credentials Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            @if(!empty($nip))
                                            <tr>
                                                <td width="35%" style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #166534;">NIP</td>
                                                <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #1f2937;">: {{ $nip }}</td>
                                            </tr>
                                            @endif
                                            @if(!empty($jabatan))
                                            <tr>
                                                <td width="35%" style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #166534;">Jabatan</td>
                                                <td style="padding: 6px 0; font-size: 13px; font-weight: 600; color: #1f2937;">: {{ $jabatan }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td width="35%" style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #166534;">Email Login</td>
                                                <td style="padding: 6px 0; font-size: 13px; font-weight: 700; color: #0f513f;">: {{ $email }}</td>
                                            </tr>
                                            <tr>
                                                <td width="35%" style="padding: 10px 0 6px 0; font-size: 13px; font-weight: 700; color: #166534; vertical-align: middle;">Password Sementara</td>
                                                <td style="padding: 10px 0 6px 0; vertical-align: middle;">
                                                    <span style="display: inline-block; font-family: 'Courier New', Courier, monospace; font-size: 15px; font-weight: 800; color: #0f513f; background-color: #dcfce7; border: 1px solid #86efac; padding: 6px 14px; border-radius: 8px; letter-spacing: 1.5px;">
                                                        {{ $password }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 28px 0;">
                                <a href="{{ url('/') }}" target="_blank" style="display: inline-block; background-color: #0f513f; color: #ffffff; font-size: 14px; font-weight: 800; text-decoration: none; padding: 14px 32px; border-radius: 12px; box-shadow: 0 4px 12px rgba(15, 81, 63, 0.25); transition: background-color 0.2s;">
                                    🚀 Login ke Portal SIRAPI
                                </a>
                            </div>

                            <!-- Security Tip Note -->
                            <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 14px 16px; border-radius: 6px; margin-top: 24px;">
                                <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #92400e;">
                                    🔒 <strong>Keamanan Akun:</strong> Demi keamanan akun Anda, harap segera mengganti password sementara ini melalui menu <strong>Pengaturan Profil</strong> setelah berhasil login.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #f1f5f9;">
                            <p style="margin: 0 0 6px 0; font-size: 12px; font-weight: 700; color: #64748b;">
                                Dinas Komunikasi dan Informatika Kabupaten Bogor
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                                Email ini dikirimkan secara otomatis oleh Sistem SIRAPI. Harap tidak membalas email ini secara langsung.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
