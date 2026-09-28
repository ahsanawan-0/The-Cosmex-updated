New enquiry from the website contact form

Name:    {!! $data['name'] !!}
Email:   {!! $data['email'] !!}
Phone:   {!! $data['phone'] ?: '-' !!}
Subject: {!! $data['subject'] ?: '-' !!}

{!! $data['message'] !!}

--
Sent from {{ url('/contact') }}. Reply to this email to answer the sender.
