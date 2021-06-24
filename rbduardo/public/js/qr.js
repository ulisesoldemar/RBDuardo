var qr;

function generateQRCode() {
    qr = new QRious({
        element: document.getElementById('qr-code'),
        size: 200,
        value: document.getElementById('qr-text').value
    });
}
