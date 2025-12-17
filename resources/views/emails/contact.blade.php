<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
</head>
<body style="background-color: #f3f4f6; padding: 20px; font-family: Arial, sans-serif;">

    <div style="max-w-600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        {{-- Header --}}
        <div style="background-color: #001233; padding: 20px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">BusPH Contact Message</h1>
        </div>

        {{-- Content --}}
        <div style="padding: 30px;">
            <p style="color: #6b7280; font-size: 14px; margin-bottom: 20px;">
                You received a new message from the <strong>BusPH Contact Form</strong>.
            </p>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #374151; width: 100px;">Name:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; color: #111827;">{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #374151;">Email:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; color: #111827;">
                        <a href="mailto:{{ $data['email'] }}" style="color: #2563eb; text-decoration: none;">{{ $data['email'] }}</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; font-weight: bold; color: #374151;">Subject:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; color: #111827;">{{ $data['subject'] }}</td>
                </tr>
            </table>

            <div style="background-color: #f9fafb; padding: 20px; border-radius: 6px; border: 1px solid #e5e7eb;">
                <p style="font-weight: bold; color: #374151; margin-top: 0;">Message:</p>
                <p style="color: #4b5563; line-height: 1.6; white-space: pre-wrap;">{{ $data['message'] }}</p>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background-color: #f3f4f6; padding: 15px; text-align: center; color: #9ca3af; font-size: 12px;">
            &copy; {{ date('Y') }} BusPH System. All rights reserved.
        </div>
    </div>

</body>
</html>