WhatsApp API MultiDevice
BASE URL : http://localhost:3000

1. Authentication (Basic Auth HTTP) 
    Basic auth tokens are constructed with the Basic keyword, followed by a space, followed by a base64-encoded string of your username:password (separated by a : colon).

    Example: send a Authorization: Basic aGVsbG86aGVsbG8= HTTP header with your requests to authenticate with the API.

2. Login WhatsApp
    (GET) /app/login

    Response 200:
    {
        "code": "SUCCESS",
        "message": "Success",
        "results": {
            "qr_duration": 30,
            "qr_link": "http://localhost:3000/statics/images/qrcode/scan-qr-b0b7bb43-9a22-455a-814f-5a225c743310.png"
        }
    }

    Response 500:
    {
        "code": "INTERNAL_SERVER_ERROR",
        "message": "you are not loggin",
        "results": {}
    }


3. Reconect WhatsApp
    (GET) /app/reconnect

    Response 200:
    {
        "code": "SUCCESS",
        "message": "Success",
        "results": {
            "qr_duration": 30,
            "qr_link": "http://localhost:3000/statics/images/qrcode/scan-qr-b0b7bb43-9a22-455a-814f-5a225c743310.png"
        }
    }

    Response 500:
    {
        "code": "INTERNAL_SERVER_ERROR",
        "message": "you are not loggin",
        "results": {}
    }

4. Logout
    (GET) /app/logout

    Response 200:
    {
        "code": "SUCCESS",
        "message": "Success",
        "results": "string"
    }

    Response 500:
    {
        "code": "INTERNAL_SERVER_ERROR",
        "message": "you are not loggin",
        "results": {}
    }

5. Get Devices
    (GET) /app/devices

    Response 200:
    {
        "code": "SUCCESS",
        "message": "Fetch device success",
        "results": [
            {
            "name": "Aldino Kemal",
            "device": "628960561XXX.0:64@s.whatsapp.net"
            }
        ]
    }

    Response 500:
    {
        "code": "INTERNAL_SERVER_ERROR",
        "message": "you are not loggin",
        "results": {}
    }

6. Send Message
    (POST) /send/message

    Request Body:
    {
        "phone": "6289685028129@s.whatsapp.net",
        "message": "selamat malam",
        "reply_message_id": "3EB089B9D6ADD58153C561",
        "is_forwarded": false,
        "duration": 3600
    }

    Response 200:
    {
        "code": "SUCCESS",
        "message": "Success",
        "results": {
            "message_id": "3EB0B430B6F8F1D0E053AC120E0A9E5C",
            "status": "<feature> success ...."
        }
    }

    Response 400:
    {
        "code": 400,
        "message": "field cannot be blank",
        "results": {}
    }

    Response 500:
    {
        "code": "INTERNAL_SERVER_ERROR",
        "message": "you are not loggin",
        "results": {}
    }

7. Send Image
    (POST) /send/image

    Request Body:
    --request POST 'http://localhost:3000/send/image' \
    --user "username:password" \
    --header "Content-Type: multipart/form-data" \
    --form "phone=6289685028129@s.whatsapp.net" \
    --form "caption=selamat malam" \
    --form "view_once=false" \
    --form "image=@file" \
    --form "image_url=https://example.com/image.jpg" \
    --form "compress=false" \
    --form "duration=3600" \
    --form "is_forwarded=false"

    Response 200:
    {
        "code": "SUCCESS",
        "message": "Success",
        "results": {
            "message_id": "3EB0B430B6F8F1D0E053AC120E0A9E5C",
            "status": "<feature> success ...."
        }
    }

    Response 400:
    {
        "code": 400,
        "message": "field cannot be blank",
        "results": {}
    }

    Response 500:
    {
        "code": "INTERNAL_SERVER_ERROR",
        "message": "you are not loggin",
        "results": {}
    }

8. Send File
    (POST) /send/file

    Request Body:
    --request POST 'http://localhost:3000/send/file' \
    --user "username:password" \
    --header "Content-Type: multipart/form-data" \
    --form "phone=6289685028129@s.whatsapp.net" \
    --form "caption=selamat malam" \
    --form "file=@file" \
    --form "is_forwarded=false" \
    --form "duration=3600"

    Response 200:
    {
        "code": "SUCCESS",
        "message": "Success",
        "results": {
            "message_id": "3EB0B430B6F8F1D0E053AC120E0A9E5C",
            "status": "<feature> success ...."
        }
    }

    Response 400:
    {
        "code": 400,
        "message": "field cannot be blank",
        "results": {}
    }

    Response 500:
    {
        "code": "INTERNAL_SERVER_ERROR",
        "message": "you are not loggin",
        "results": {}
    }


