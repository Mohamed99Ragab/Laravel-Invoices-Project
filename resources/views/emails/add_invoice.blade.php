@component('mail::message')
# تم اضافة الفاتورة بنجاح

مرحبا بك في منصتنا الكترونية.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/InvoiceDetails/'.$invoice_id])
عرض الفاتورة
@endcomponent

شكرا لك,<br>
{{ config('app.name') }}
@endcomponent
