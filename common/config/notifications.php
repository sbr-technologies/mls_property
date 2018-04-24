<?php

/**
 * This file has all the system notification messages. For adding new notifications, be sure to use Yii::t(), in order
 * to enable multilingual notification.
 * parent array key is the notification type, child array's first element is title and second element is the actual notification.
 */
return [
    'hospital_add_request_clinic' => [
        Yii::t('app', 'New Addition Request Notification'),
        Yii::t('app', 'You have been added by {hospital}. Click here to approve.', ["hospital" => "{{hospital}}"])
    ],
    'message_received' => [
        Yii::t('app', 'New Message Notification'),
        Yii::t('app', 'You have received a new message from {sender}', ["sender" => "{{sender}}"])
    ],
    'subscription_expired' => [
        Yii::t('app', 'Your Subscription Has Expired'),
        Yii::t('app', 'Your subscription plan has expired. Please renew the plan to enjoy benifits.')
    ],
    'subscription_expiring' => [
        Yii::t('app', 'Your Subscription is about to expire'),
        Yii::t('app', 'Your subscription plan is about to expire in less than 3 days. Please renew soon.')
    ],
    'booking_placed_doctor' => [
        Yii::t('app', 'New Booking Received'),
        Yii::t('app', 'You have received a new booking at {clinic_name}, from  {patient_name}. Click here to go to your booking page.', [
            "clinic_name" => "{{clinic_name}}",
            "patient_name" => "{{patient_name}}"
        ])
    ],
    'booking_placed_patient' => [
        Yii::t('app', 'New Booking Placed'),
        Yii::t('app', 'A new booking has been placed on your behalf. Click here for more info. ', [
        ])
    ],
    'booking_canceled_patient' => [
        Yii::t('app', 'Booking Canceled'),
        Yii::t('app', 'Your booking has been canceled for {doctor_name} at {clinic_name}. Click here for more info. ', [
            "doctor_name" => "{{doctor_name}}",
            "clinic_name" => "{{clinic_name}}"
        ])
    ],
    'booking_placed_admin' => [
        Yii::t('app', 'New Booking Placed'),
        Yii::t('app', 'A new booking has been placed with bookingID {bookingID}. Click here for more info. ', [
            "bookingID" => "{{bookingID}}",
        ])
    ],
    'booking_status_changed' => [
        Yii::t('app', 'Booking Status Update'),
        Yii::t('app', 'Booking with bookingID {bookingID} is now {bookingStatus}. Click here for more info. ', [
            "bookingID" => "{{bookingID}}",
            "bookingStatus" => "{{bookingStatus}}",
        ])
    ],
    'booking_placed_clinic' => [
        Yii::t('app', 'New Booking Received'),
        Yii::t('app', 'Your clinic has received a new booking for {doctor_name}, from  {patient_name}. Click here to go to your booking page.', [
            "doctor_name" => "{{doctor_name}}",
            "patient_name" => "{{patient_name}}"
        ])
    ],
    'new_schedule_created_clinic' => [
        Yii::t('app', 'Approval for new schedule'),
        Yii::t('app', 'You have a pending request for approval schedule for {doctorName}. Click here to view details.', [
            "doctorName" => "{{doctorName}}",
        ])
    ],
    'new_schedule_created_doctor' => [
        Yii::t('app', 'Approval for new schedule'),
        Yii::t('app', 'You have a pending request for approval schedule for {clinicName}. Click here to view details.', [
            "clinicName" => "{{clinicName}}",
        ])
    ],
    'schedule_approved_clinic' => [
        Yii::t('app', 'Schedule Approved'),
        Yii::t('app', 'Your schedule has been approved for {doctorName}. Click here to view details.', [
            "doctorName" => "{{doctorName}}",
        ])
    ],
    'schedule_approved_doctor' => [
        Yii::t('app', 'Schedule Approved'),
        Yii::t('app', 'Your schedule has been approved for {clinicName}. Click here to view details.', [
            "clinicName" => "{{clinicName}}",
        ])
    ],
    'schedule_rejected_clinic' => [
        Yii::t('app', 'Schedule Rejected'),
        Yii::t('app', 'Your schedule has been approved for {doctorName}. Click here to view details.', [
            "doctorName" => "{{doctorName}}",
        ])
    ],
    'schedule_rejected_doctor' => [
        Yii::t('app', 'Schedule Rejected'),
        Yii::t('app', 'Your schedule has been approved for {clinicName}. Click here to view details.', [
            "clinicName" => "{{clinicName}}",
        ])
    ],
    'send_reminder_doctor' => [
        Yii::t('app', 'Reminder is placed by Doctor'),
        Yii::t('app', 'Your doctor {doctor_name} has sent a reminder. Please Check your email inbox.', [
            "doctor_name" => "{{doctor_name}}",
            "patient_name" => "{{patient_name}}"
        ])
    ],
    'confirm_booking' => [
        Yii::t('app', 'Your booking is confirmed'),
        Yii::t('app', 'Your doctor {doctor_name} booking is confirmed.', [
            "doctor_name" => "{{doctor_name}}",
            "patient_name" => "{{patient_name}}"
        ])
    ],
    'confirm_booking_clinic' => [
        Yii::t('app', 'Your booking is confirmed'),
        Yii::t('app', 'Your clinic {clinic_name} booking is confirmed.', [
            "clinic_name" => "{{clinic_name}}",
            "patient_name" => "{{patient_name}}"
        ])
    ],
    'confirm_booking_patient' => [
        Yii::t('app', 'Your booking is confirmed'),
        Yii::t('app', 'Your clinic is {clinic_name}.', [
            "clinic_name" => "{{clinic_name}}",
            "patient_name" => "{{patient_name}}"
        ])
    ],
    'cancel_booking_by_doctor' => [
        Yii::t('app', 'Your booking is cancelled'),
        Yii::t('app', 'Your doctor {doctor_name} booking is cancelled.', [
            "doctor_name" => "{{doctor_name}}",
            "patient_name" => "{{patient_name}}"
        ])
    ],
    'cancel_booking_by_clinic' => [
        Yii::t('app', 'Your booking is cancelled'),
        Yii::t('app', 'Your doctor {doctor_name} booking is cancelled by clinic {clinic_name}.', [
            "doctor_name" => "{{doctor_name}}",
            "clinic_name" => "{{clinic_name}}"
        ])
    ],
    'make_booking_as_visited' => [
        Yii::t('app', 'Your booking status is changed as Visited'),
        Yii::t('app', 'Your doctor {doctor_name} booking is marked as visited.', [
            "doctor_name" => "{{doctor_name}}",
            "patient_name" => "{{patient_name}}"
        ])
    ],
    'cancel_booking_by_patient' => [
        Yii::t('app', 'Booking is cancelled by patient'),
        Yii::t('app', 'Booking is cancelled by patient {patient_name}.', [
            "patient_name" => "{{patient_name}}",
            "doctor_name" => "{{doctor_name}}"
        ])
    ],
    'patient_create_waiting' => [
        Yii::t('app', 'You are added to waiting list'),
        Yii::t('app', 'You are added to waiting list by clinic {clinic_name} for doctor {doctor_name}.', [
            "clinic_name" => "{{clinic_name}}",
            "doctor_name" => "{{doctor_name}}"
        ])
    ],
    'test_report_uploaded' => [
        Yii::t('app', 'Test Report Uploaded'),
        Yii::t('app', 'Test report is uploaded for Booking with lab booking ID {labBookingID}. Click here for more info. ', [
            "labBookingID" => "{{lab_booking_id}}"
        ])
    ],
    'lab_booking_cancel' => [
        Yii::t('app', 'Booking Cancelled'),
        Yii::t('app', 'Laboratory booking cancelled. Click here for more info. ', [
            
        ])
    ],
    'lab_booking_confirmed' => [
        Yii::t('app', 'Booking Confirmed'),
        Yii::t('app', 'Booking with lab booking ID {labBookingID} is now {bookingStatus}. Click here for more info. ', [
            "labBookingID" => "{{labBookingID}}",
            "bookingStatus" => "{{bookingStatus}}",
        ])
    ],
];
